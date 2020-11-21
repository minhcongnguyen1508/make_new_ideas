<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comments;
use App\Models\LikeComment;
use Illuminate\Support\Facades\Auth;

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

    public function countLike($comment_id)
    {
        return count(LikeComment::where(['comment_id'=>$comment_id, 'stauts'=>1])->get());
    }

    public function countUnLike($comment_id)
    {
        return count(LikeComment::where(['comment_id'=>$comment_id, 'stauts'=>2])->get());
    }

    public function like($comment_id)
    {
        $like_comment = LikeComment::where(['comment_id' => $comment_id, 'user_id' => Auth::id()])->first(); 

        if($like_comment == NULL){
            $like_comment = new LikeComment();
            $like_comment->create(['user_id'=>Auth::id(), 'comment_id' => $comment_id, 'status' => 1]);
        } else{
            $like_comment->status = 1;
            $like_comment->save();
        }
        
        return count(LikeComment::where('comment_id', $comment_id)->get());
    }
    public function unLike($comment_id)
    {
        $like_comment = LikeComment::where(['comment_id' => $comment_id, 'user_id' => Auth::id()])->first(); 

        if($like_comment == NULL){
            $like_comment = new LikeComment();
            $like_comment->create(['user_id'=>Auth::id(), 'comment_id' => $comment_id, 'status' => 2]);
        } else{
            $like_comment->status = 2;
            $like_comment->save();
        }
        
        return count(LikeComment::where('comment_id', $comment_id)->get());
    }

    public function statusLike($comment_id)
    {
        if(count(LikeComment::where(['comment_id'=>$comment_id,'user_id'=>Auth::id(), 'status'=>1])->get()) >= 1){
            return 'liked';
        }

        if(count(LikeComment::where(['comment_id'=>$comment_id,'user_id'=>Auth::id(), 'status'=>2])->get()) >= 1){
            return 'unliked';
        }
    }
}