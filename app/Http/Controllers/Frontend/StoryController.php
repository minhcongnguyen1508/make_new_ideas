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
        
        // $newest_stories = DB::table('users')->join('posts', 'users.id','=', 'posts.user_id')->orderByRaw('posts.created_at DESC')->limit(5)->get();
        $newest_stories = DB::table('posts')->join('users', 'posts.user_id','=', 'users.id')->join('suggestion', 'posts.id','=', 'suggestion.post_id')->where('suggest_id', $req->id)->get();
        $this->suggest($newest_stories, $req->id);
        $newest_stories = DB::table('posts')->join('users', 'posts.user_id','=', 'users.id')->join('suggestion', 'posts.id','=', 'suggestion.post_id')->where('suggest_id', $req->id)->get();
        $newest_stories = $this->checkEmpty($newest_stories, $req->id);

        return view('frontend.story')->with(['story'=> $story, 'name' => $name, 'comments' => $comments,'notifications'=> $notifications, 'newest_stories'=>$newest_stories]);
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

    public function suggest($newest_stories, $req){
        // dd($p_id);
        if(empty($newest_stories[0])){
            exec("python ../AIsuggestion/app.py ".$req);
        }
    }
    public function checkEmpty($newest_stories, $req){
        // If you can't connect AI susggestion, you can comment code above & uncomment code below.
        if(empty($newest_stories[0])){
            $newest_stories = DB::table('users')->join('posts', 'users.id','=', 'posts.user_id')->orderByRaw('posts.created_at ASC')->limit(4)->get();
            for ($i = 0; $i<4; $i++) {
                $newest_stories[$i]->post_id = $newest_stories[$i]->id;
            }
        }
        return $newest_stories;
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
                        'thumbnail' => url('images/'.$imageName),
                        'user_id' => Auth::id()
                    ]);
        $data_notifi_title = "Writer ".Auth::user()->username." vừa có bài viết mới!";
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
