<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index($cate_id, $name){

        $category = DB::table('categories')->get();
        $category_name = DB::table('categories')
                        ->where('id', $cate_id)
                        ->get();
 
        $notifications = DB::table('notifications')->where('notifiable_id',Auth::id())->get();

        $newest_stories = DB::table('users')
                            ->join('posts', 'users.id','=', 'posts.user_id')
                            ->orderByRaw('posts.created_at ASC')
                            ->where('posts.category_id', $cate_id)
                            ->limit(5)->get();
        
        $stories = DB::table('users')
                    ->join('posts', 'users.id','=', 'posts.user_id')
                    ->where('posts.category_id', $cate_id)
                    ->paginate(3);
     
        return view('frontend.category_posts', 
                ['newest_stories'=> $newest_stories,
                'notifications'=> $notifications,
                'stories'=>$stories,
                'category_name'=> $category_name,
                'category'=>$category],);
    
    }
}
