<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Item;
use App\Models\Type;
use App\Mail\MessageMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
        $types = Cache::remember("types", now()->addMinutes(120), function() {
            return Type::get();
        });

        $items = Cache::remember("items", now()->addMinutes(120), function() {
            return Item::get();
        });

        $imgs = Cache::remember("imgs", now()->addMinutes(120), function() {
            return Image::get();
        });

        return view('home')->with("types", $types)->with("items", $items)->with("imgs", $imgs);
    }

    public function mail()
    {
        /* dd(request()); */

        $data = request()->validate([
            'ime' => 'required|string',
            'priimek' => 'required|string',
            'email' => 'required|email',
            'tel' => 'required|string',
            'zadeva' => 'required|string',
            'sporocilo' => 'required|string',
        ]);

        Mail::to("nace.tavcer20@gmail.com")->send(new MessageMail($data));

        if(count(Mail::failures()) > 0){
            return false;
        }

        return true;
    }

    public function checkout() {
        return view('checkout');
    }
}
