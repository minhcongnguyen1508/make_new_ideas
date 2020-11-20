<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comments;
use DB;
use App\Models\Like;
Use App\Models\Post;
Use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator,Redirect,Response;
use App\Notifications\TestNotification;
//use pusher
use Pusher\Pusher;
use App\Events\NotificationEvent;

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
        $notifications = DB::table('notifications')->where('notifiable_id',Auth::id())->get();
        return view('frontend.story')->with(['story'=> $story, 'name' => $name, 'comments' => $comments,'notifications'=> $notifications]);
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
        $id_new_post = Post::create([
                        'title' => $data['title'],
                        'slug' => str_replace(" ","-",strtolower($data['title'])),
                        'content' => $data['content'],
                        'category_id' => $data['category'],
                        'thumbnail' => '/public/images/'.$imageName,
                        'user_id' => Auth::id()
                    ]);
        $data_notifi_title = "Writer ".Auth::user()->username." vừa mới có bài viết mới!";
        $data_notifi_link = "story/".$id_new_post->id;
        $followers = followers_of_current_user();
        foreach ($followers as $key => $follower) {
            $follower->notify(new TestNotification(['title'=>$data_notifi_title,'link'=>$data_notifi_link]));
        }
        // $user = User::find(Auth::id());
        // $user->notify(new TestNotification(['title'=>$data_notifi_title,'link'=>$data_notifi_link]));
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
        $pusher->trigger('notification-channel', 'notification-event', ['title'=>$data_notifi_title,'link'=>$data_notifi_link,'writer_id'=>current_user()->id,'created_at'=>explode('.',$id_new_post->created_at)[0]]);
        // event(new NotificationEvent(['title'=>$data_notifi_title,'link'=>$data_notifi_link],current_user()->id));
        return Redirect::to("/")->withSuccess('You create articles success!');
    }
}
