<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;


class SignupController extends Controller {

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|string|email:strict,dns,spoof|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $remember = true;
        Auth::login($user, $remember);

        event(new Registered($user));

        return redirect('/email/verify');
    }
}
