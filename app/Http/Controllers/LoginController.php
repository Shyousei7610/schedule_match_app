<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {


    public function authenticate(Request $request){
        $credentials = $request->only('email', 'password');
        $remember = true;
        if(Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect('/home');
        }

        return back()->withErrors([
            'message' => 'メールアドレスまたはパスワードが正しくありません',
        ]);
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(RouteServiceProvider::HOME);
    }
}
