<?php

namespace App\Http\Controllers\User;
use App\Models\Configurations;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home(Request $request){
        $title = "Dashboard";
        return view('user.home',['title' => $title]);
    }

    public function profile(Request $request){
        $title = "User Profile";
        return view('user.profile',['title' => $title]);
    }

    public function checkOut(Request $request){
        $title = 'Cart';
        $service_charge = Configurations::where('type','service_charge')->first();
        return view('user.cart',['title' => $title,'service_charge' => $service_charge->value]);
    }

    public function transactions(Request $request){
        $title = 'Transactions';
        return view('user.transactions',['title' => $title]);
    }



}
