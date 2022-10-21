<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bundle;
use Braintree\Gateway;

class SponsorController extends Controller
{
    public function getSponsorPackages(Request $request) {
        $user = $request->user();
        $bundles = Bundle::all();

        $data = [
            'user' => $user,
            'bundles' => $bundles,
        ];
        return view ('admin.sponsors', $data);
    }
}