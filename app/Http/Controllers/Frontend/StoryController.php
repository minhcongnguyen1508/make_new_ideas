<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comments;
use DB;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Validator,Redirect,Response;

class StoryController extends Controller
{
  public function index(Request $req){
    $story = DB::table('posts')
            ->where('id', $req->id)
            ->get();

    $name = DB::table('users')->leftjoin('posts', 'users.id','=', 'posts.user_id')
            ->where('posts.id', $req->id)
            ->get();
    
    $comments = Comments::where('post_id', $req->id)->get();

    return view('frontend.story')->with(['story'=> $story, 'name' => $name, 'comments' => $comments]);
  }
  public function countLike($post_id)
    {
        return count(DB::table('likes')->where('post_id',$post_id)->get());
    }
    public function like($post_id)
    {
        Like::create(['user_id'=>Auth::id(), 'post_id' => $post_id]);
        return count(DB::table('likes')->where('post_id',$post_id)->get());
        
    }
    public function unLike($post_id)
    {
        DB::table('likes')->where(['post_id'=>$post_id,'user_id'=>Auth::id()])->delete();
        return count(DB::table('likes')->where('post_id',$post_id)->get());
    }
    public function statusLike($post_id)
    {
        if(count(DB::table('likes')->where(['post_id'=>$post_id,'user_id'=>Auth::id()])->get()) >= 1){
            return 'liked';
        }
    }
}
