<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileEditRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function show($id){
        if(Auth::check()){
            $user = User::find($id);
        
            return view('frontend.profile', ['user' => $user]);
        } else {
            return Redirect::to("/signin");
        }
    }

    public function edit(ProfileEditRequest $request, $id){
        if(Auth::check()){
            $user = User::find($id);       
            $user->username = $request->username;
            $user->email = $request->email;

            if($request->hasFile('avatar')) {
                $imageName = time().'_'.$request->avatar->getClientOriginalName(); 
                $request->avatar->move(public_path('avatars'), $imageName);
                $user->avatar = $imageName;
            }
            
            $user->save();

            return redirect()->back()->with('success', 'You edit profile successfully!');
        } else {
            return Redirect::to("/signin");
            }
        }
}
