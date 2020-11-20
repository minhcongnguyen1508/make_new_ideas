<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
Use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{
  public function index(){
    $category = DB::table('categories')->get();
    $notifications = DB::table('notifications')->where('notifiable_id',Auth::id())->get();
    $stories = DB::table('posts')->paginate(3);
    $user_stories = DB::table('users')->join('posts', 'users.id','=', 'posts.user_id')->paginate(3);
    $the_most_stories_ids = DB::table('likes')
                          ->select(DB::raw('count(user_id) as user_count, post_id'))
                          ->groupBy('post_id')
                          ->orderBy('user_count', 'desc')
                          ->get();
    $the_most_stories = DB::table('users')->join('posts', 'users.id','=', 'posts.user_id')
                        ->whereIn('posts.id',[$the_most_stories_ids[0]->post_id,
                                        $the_most_stories_ids[1]->post_id,
                                        $the_most_stories_ids[2]->post_id,
                                        $the_most_stories_ids[3]->post_id])
                        ->get();
    $newest_stories = DB::table('users')->join('posts', 'users.id','=', 'posts.user_id')->orderByRaw('posts.created_at DESC')->limit(5)->get();
    return view('frontend.homepage', ['newest_stories'=> $newest_stories,'the_most_stories'=>$the_most_stories,'stories'=>$user_stories,'category' => $category,'notifications'=> $notifications]);
  }
}
