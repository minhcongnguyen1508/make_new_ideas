<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite, Auth, Redirect, Session, URL;
use App\Models\User;

class SocialAuthController extends Controller
{
    /**
     * Chuyển hướng người dùng sang OAuth Provider.
     *
     * @return Response
     */
    const DEFAULT_PASSWORD = "12345678";
    public function redirectToProvider($provider)
    {
        if(!Session::has('pre_url')){
            Session::put('pre_url', URL::previous());
        }else{
            if(URL::previous() != URL::to('signin')) Session::put('pre_url', URL::previous());
        }
        if (URL::previous() == URL::to('signin')) {
            Session::put('pre_url', URL::to('/'));
        }
        return Socialite::driver($provider)->redirect();
    }  

    /**
     * Lấy thông tin từ Provider, kiểm tra nếu người dùng đã tồn tại trong CSDL
     * thì đăng nhập, ngược lại nếu chưa thì tạo người dùng mới trong SCDL.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return Redirect::to(Session::get('pre_url'));
    }

    /**
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('email', $user->email)->first();
        if ($authUser) {
            return $authUser;
        }
         
        return User::create([
            'username' => $user->name,
            'email'    => $user->email,
            'password' => Hash::make(self::DEFAULT_PASSWORD),
            'provider' => $provider,
            'provider_id' => $user->id,
            'role_id' => 1
        ]);
    }
}