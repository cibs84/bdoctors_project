<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        return view('show');
    }

    public function debug(Faker $faker)
    {   
        // $response = Http::get('https://randomuser.me/api/');
        //     $apiResponse = $response->json();
        //     dd($apiResponse);

        $user = User::with('specializations', 'reviews', 'messages', 'bundles')->get()->find(140);


        // return view('show');
    }
}
