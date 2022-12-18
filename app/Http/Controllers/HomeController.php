<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Item;
use App\Models\Type;
use App\Mail\MessageMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /* public function __construct()
    {
        $this->middleware('auth');
    } */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $types = Type::get();

        $items = Item::get();

        $imgs = Image::get();

        return view('home')->with("types", $types)->with("items", $items)->with("imgs", $imgs);
    }

    public function imgs(\App\Models\Item $item)
    {
        $imgs = $item->hasManyImages()->get();

        return response()->json($imgs, 200);
    }

    public function mail()
    {
        $captchaResponse = null;

        if (env("APP_ENV") == "local")
            $captchaResponse['success'] = true;

        if (env("APP_ENV") != "local")
            $captchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => "6LfYy7IcAAAAAODUQ8HhbRVp0m-Ss1WdGIGqGMUW",
                'response' => request('token'),
                'remoteip' => request()->ip()
            ])->json();

        if ($captchaResponse['success']) {

            $data = request()->validate([
                'ime' => 'required|string',
                'priimek' => 'required|string',
                'email' => 'required|email',
                'tel' => 'required|string',
                'zadeva' => 'required|string',
                'sporocilo' => 'required|string',
            ]);

            Mail::to("info@pragwald-woodworks.si")->send(new MessageMail($data));

            if (count(Mail::failures()) > 0) {
                return response()->json(['success' => false, 'fail' => Mail::failures()]);
            }

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
