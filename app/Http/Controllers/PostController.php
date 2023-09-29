<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){

        $posts = Post::orderBy('created_at', 'desc')->with(['user', 'likes'])->paginate(20);

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function show(Post $post){
        return view('posts.show', [
            'post' => $post
        ]);
    }

    public function store(Request $request, User $user){
        $this->validate($request, [
            'body' => 'required'
        ]);

        if($request->user() !== null){
            $request->user()->posts()->create($request->only('body'));
        }
        


        return back();
    }

    public function destroy(Post $post){
       
        $this->authorize('delete', $post);
        $post->delete();

        return back();
    }
}
