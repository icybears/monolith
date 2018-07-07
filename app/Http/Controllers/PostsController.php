<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Post;
use App\Room;
use App\User;

class PostsController extends Controller
{

    public function store ($room_id) 
    {
        $this->validate(request(), [
            'body' => 'required|min:1'
        ]);

        $post = Post::create([
            'body' => trim(request('body')),
            'user_id' => auth()->id(),
            'room_id' => $room_id
        ]);

        if($post->user->posts_count < 0){
            $post->user->resetCommentsCount();
        }
      
        $post->user->incrementPostsCount();


        return redirect("/room/$room_id");
    }

    public function update(Room $room, Post $post)
    {
        $this->validate(request(),
        ['body' => 'required|min:2']);

       

        $post->body = trim(request('body'));

        $post->save();


            return back();
    }

    public function destroy (Room $room, Post $post)
    {
        $post->deleteComments();

        $post->user->decrementPostsCount();

        // to avoid the bug where a post is posted twice but only counts for 1
        if($post->user->posts_count < 0){
            $post->user->resetCommentsCount();
        }
        Post::destroy($post->id);

        return redirect()->back();
    }
}
