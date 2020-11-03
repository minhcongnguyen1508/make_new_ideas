<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comments;

class CommentController extends Controller
{
    public function store (Request $req)
    {
        $comments = Comments::where('post_id', $req->id)->get();
    
        return view('frontend.story')->with(['comments'=> $comments]);
    }

    public function postReview(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'title' => 'required'
            ],
            [
                'title.required' => 'Please enter your review and then Submit'
            ]
        );
        $review = new Review;
        $review->title = $request->title;
        $review->book_id = $id;
        $review->user_id = Auth::user()->id;
        $review->save();
        return redirect()->back();
    }
}