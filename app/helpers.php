<?php
Use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;


function current_user()
{
    return User::find(Auth::id());
}
function followers_of_current_user()
{
    $followers_id = Follow::where('writer_id',Auth::id())->get('user_id');
    return User::whereIn('id', $followers_id)->get();
}
function following_writer_ids(){
    $following_writer_ids = Follow::where('user_id',Auth::id())->get('writer_id');
    return $following_writer_ids;
}