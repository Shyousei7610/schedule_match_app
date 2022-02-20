<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;


class SignupController extends Controller {

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|min:1|max:30',
            'personal' => 'required|string|alpha_dash|min:5|max:20|unique:users',
            'email' => 'required|string|email:strict,dns,spoof|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'personal' => $request->personal,
            'identifier' => Str::uuid(),
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $remember = true;
        Auth::login($user, $remember);

        event(new Registered($user));


        Profile::create([
            'profile_introduction' => '',
        ]);

        return redirect('/email/verify');
    }
}
