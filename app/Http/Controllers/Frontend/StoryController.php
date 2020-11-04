<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comments;
use DB;
Use App\Models\Post;
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
  public function showCreateStory()
  {
      $categories = DB::table('categories')->get();
      return view('frontend.create-story',['categories' => $categories]);
  }
  public function createStory(Request $request)
    {
        request()->validate([
            'title' => 'required|unique:posts',
            'category' => 'required',
            'content' => 'required|min:1',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        $data = $request->All();
        $imageName = time().'.'.$request->thumbnail->extension();  
        $request->thumbnail->move(public_path('images'), $imageName);
        Post::create([
            'title' => $data['title'],
            'slug' => str_replace(" ","-",strtolower($data['title'])),
            'content' => $data['content'],
            'category_id' => $data['category'],
            'thumbnail' => '/images/'.$imageName,
            'user_id' => Auth::id()
        ]);
        return Redirect::to("/")->withSuccess('You create articles success!');
    }
}
