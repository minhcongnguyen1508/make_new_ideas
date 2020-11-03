<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comments;
use Illuminate\Support\Facades\Auth;
use Exception;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $comment = new Comments;
        $comment->content = $request->content;
        $comment->post_id = $id;
        $comment->user_id = Auth::user()->id;
        $comment->type = 1;
        $comment->status = 1;

        $comment->save();
    
        return redirect()->back();
    }
}