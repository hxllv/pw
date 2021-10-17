<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function index()
    {
        session_start();
        session_create_id();
        return view('checkout');
    }

    public function captcha()
    {
        return Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => "6LfYy7IcAAAAAODUQ8HhbRVp0m-Ss1WdGIGqGMUW",
            'response' => request('token'),
            'remoteip' => request()->ip()
        ])->json();
    }

    public function checkItems()
    {
        $validator = Validator::make(request()->all(), [
            'items' => 'required|json'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => ['items' => 'Poslani podatki niso v obliki JSON, obrnite se na skrbnika spletne strani.']]);
        }

        $data = json_decode(request()->all()['items'], true);

        foreach ($data as $key => $item) {
            $item = Item::find($key);

            $validator = Validator::make($data, [
                '*.price' => ['string', 'required', function ($attribute, $value, $fail) use ($item) {
                    if ($value !== $item->price) {
                        $fail('The ' . $attribute . ' is invalid.');
                    }
                }]
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()]);
            }
        }
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

        $data = request()->all();

        return response()->json($data);
    }
}
