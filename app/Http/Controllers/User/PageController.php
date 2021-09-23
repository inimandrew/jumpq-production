<?php

namespace App\Http\Controllers\User;

use App\Models\Configurations;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function home(Request $request)
    {
        $title = "Dashboard";
        return view('user.home', ['title' => $title]);
    }

    public function homePage(Request $request)
    {
        return redirect()->route('cart');
    }

    public function profile(Request $request)
    {
        $title = "User Profile";
        return view('landing.user.profile', ['title' => $title]);
    }

    public function checkOut(Request $request)
    {
        $title = 'Cart';
        $service_charge = Configurations::where('type', 'service_charge')->first();
        return view('landing.user.cart', ['title' => $title, 'service_charge' => $service_charge->value]);
    }

    public function transactions(Request $request)
    {
        $title = 'Transactions';
        return view('landing.user.transaction', ['title' => $title]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('new-landing');
    }
}
