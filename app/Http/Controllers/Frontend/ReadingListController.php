<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Posts;
use Illuminate\Support\Facades\DB;
use App\Models\ReadingList;
use Illuminate\Support\Facades\Auth;

use Redirect;


class ReadingListController extends Controller
{
    public function index(){

        $story = DB::table('reading_lists')
                    ->join('posts', 'reading_lists.post_id', '=', 'posts.id')
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->get();
                 

        if(Auth::check()){
            return view('frontend.reading-list')->with('story', $story);
        } else {
            return Redirect::to("/signin");
        }
    }

    public function save($post_id){
        ReadingList::create(['user_id'=>Auth::id(), 'post_id'=>$post_id]);
        
    }

    public function unsave($post_id){
        DB::table('reading_lists')->where(['post_id'=>$post_id,'user_id'=>Auth::id()])->delete();
       
    }

    public function statusSave($post_id){
        if(count(DB::table('reading_lists')->where(['post_id'=>$post_id,'user_id'=>Auth::id()])->get()) == 1){
            return 'saved';
        }
    }

    public function remove($post_id){
        DB::table('reading_lists')->where(['post_id'=>$post_id, 'user_id'=>Auth::id()])->delete();
        
    }
}
