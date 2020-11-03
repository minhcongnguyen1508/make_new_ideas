<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comments;
use DB;

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
}
