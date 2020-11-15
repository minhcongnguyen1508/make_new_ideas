<?php

namespace App\Http\Controllers\Frontend;
use DB;
Use App\Models\User;
Use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use Validator,Redirect,Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FollowController extends Controller
{
    public function follow(Request $request)
    {
        Follow::create(['user_id'=>Auth::id(), 'writer_id' => $request->writer_id]);
    }
    public function unfollow(Request $request)
    {
        DB::table('follows')->where(['user_id'=>Auth::id(), 'writer_id' => $request->writer_id])->delete();
    }
    public function isFollowed(Request $request)
    {
        return count(DB::table('follows')->where(['user_id'=>Auth::id(), 'writer_id' => intval($request->writer_id)])->get());
    }
}
