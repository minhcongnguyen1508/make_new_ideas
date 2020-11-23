<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    function getSearch(Request $req) {

        $search = $req->get('key');
        $post = DB::table('users')
                ->join('posts', 'posts.user_id', '=', 'users.id')
                ->where('title', 'like', '%'.$search.'%')->get();

        return view('frontend.searchpage')->with('post', $post);

    }
}
