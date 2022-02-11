<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;


class ProfileController extends Controller {

    public function store(Request $request){
        $request->validate([
            'profile_introduction' => 'string|max:50|nullable',
            'profile_icon' => 'file|image|nullable',
            'profile_header' => 'file|image|nullable'
        ]);

        $user_id = Auth::id();
        $user = Profile::find($user_id);

        if(! empty($request->profile_introduction)){
            $user->profile_introduction = $request->profile_introduction;
        }

        if(! empty($request->profile_icon)){
            $profile_icon = $request->file('profile_icon');
            $icon_path = $profile_icon->storeAs($user_id, $profile_icon->getClientOriginalName(),'public');
            $user->profile_icon = $icon_path;
        }

        if(! empty($request->profile_header)){
            $profile_header = $request->file('profile_header');
            $header_path = $profile_header->storeAs($user_id, $profile_header->getClientOriginalName(),'public');
            $user->profile_header = $header_path;
        }

        $user->save();

         return redirect('/profile');
        }
}
