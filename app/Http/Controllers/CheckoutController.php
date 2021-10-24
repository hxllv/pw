<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Exception;
use App\Mail\OrderMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class CheckoutController extends Controller
{
    public function index()
    {
        session()->forget(['userData', 'items', 'price', 'notes']);
        session()->regenerate();
        return view('checkout');
    }

    public function captcha()
    {
        $captchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => "6LfYy7IcAAAAAODUQ8HhbRVp0m-Ss1WdGIGqGMUW",
            'response' => request('token'),
            'remoteip' => request()->ip()
        ])->json();

        if ($captchaResponse['success']) {
            $data = [
                'id' => Str::uuid()->toString(),
                'userData' => session('userData'),
                'items' => session('items'),
                'price' => session('price'),
                'notes' => session('notes')
            ];

            Mail::to("info@pragwald-woodworks.si")->send(new OrderMail($data));

            Mail::to($data['userData']['email'])->send(new OrderMail($data));

            if (count(Mail::failures()) > 0) {
                return response()->json(['success' => false]);
            }

            foreach (session('items') as $item) {
                $item->available = false;
                $item->save();
            }

            session()->forget(['userData', 'items', 'price', 'notes']);
            session()->regenerate();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function checkItems()
    {
        $validator = Validator::make(request()->all(), [
            'items' => 'required|json',
            'opombe' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            if (isset($validator->errors()['items']) && !empty($validator->errors()['items']))
                $text = 'Poslani podatki niso v obliki JSON, obrnite se na skrbnika spletne strani.';
            elseif (isset($validator->errors()['opombe']) && !empty($validator->errors()['opombe']))
                $text = 'Neveljavni vnos za opombe.';


            return response()->json(['error' => $text]);
        }

        session(['notes' => request()->all()['opombe']]);
        $data = json_decode($validator->validated()['items'], true);

        if (count($data) === 0)
            return response()->json(['error' =>  'V košarici ni izdelkov.']);

        $items = [];
        $price = 0;
        foreach ($data as $key => $itemJson) {
            $item = Item::find($key);

            if ($item === null)
                return response()->json([
                    'error' => 'Izdelek "' . $itemJson['title'] . '" v košarici ima neveljaven ID, obrnite se na skrbnika spletne strani.'
                ]);
            if (!$item->available)
                return response()->json([
                    'error' => 'Izdelek "' . $itemJson['title'] . '" v košarici ni na voljo, obrnite se na skrbnika spletne strani.'
                ]);

            $items[$key] = $item;
            $price += $item->price;
        }
        session(['price' => $price]);
        session(['items' => $items]);

        return response()->json(['items' => $items, 'price' => $price]);
    }

    public function checkUserData()
    {
        $validator = Validator::make(request()->all(), [
            'ime' => 'required|string',
            'priimek' => 'required|string',
            'email' => 'required|email',
            'tel' => 'required|numeric',
            'naslov' => 'required|string',
            'kraj' => 'required|string',
            'posta' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $data = $validator->validated();

        session(['userData' => $data]);

        return response()->json(['data' => $data]);
    }
}
