<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

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

        if ($validator->fails())
            return response()->json(['error' => ['items' => 'Poslani podatki niso v obliki JSON, obrnite se na skrbnika spletne strani.']]);

        $data = json_decode(request()->all()['items'], true);

        if (count($data) === 0)
            return response()->json(['error' => ['items' => 'V košarici ni izdelkov.']]);

        $items = [];
        foreach ($data as $key => $itemNotUsed) {
            $item = Item::find($key);

            if ($item === null)
                return response()->json(['error' => ['items' => 'Izdelek v košarici ima neveljaven ID, obrnite se na skrbnika spletne strani.']]);

            $items[$key] = $item;
        }

        $_SESSION['items'] = $items;

        return;
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
        $_SESSION['userData'] = $data;

        return;
    }
}
