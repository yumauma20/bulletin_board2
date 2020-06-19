<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Post;
use App\User;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);

        return view('posts.index', ['posts' => $posts]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $params = $request->validate([
            'title' => 'required|max:50',
            'body' => 'required|max:2000',
        ]);

        $post = new Post();

        $post->title = $request->title;
        $post->body = $request->body;
        
        Auth::user()->posts()->save($post);

        return redirect()->route('top');
    }

    public function show($post_id)
    {
        $post = Post::findOrFail($post_id);
        $user = User::findOrFail($post->user_id);

        $comments = DB::table('comments');
        $comment = $comments->where('post_id',$post->id)->get();
        $comment_user_name = [];
        foreach($comment as $value){
            $comment_user_id = $value->user_id;
            $user_data = User::findOrFail($comment_user_id);
            $comment_user_name[] = $user_data->name;
        }

        return view('posts.show', [
            'post' => $post,
            'user' => $user,
            'comment_user_name' => $comment_user_name,
        ]);
    }

    public function edit($post_id)
    {
        $post = Post::findOrFail($post_id);

        $this->authorize('update', $post);

        return view('posts.edit', [
            'post' => $post,
        ]);
    }

    public function update($post_id, Request $request)
    {
        $params = $request->validate([
            'title' => 'required|max:50',
            'body' => 'required|max:2000',
        ]);

        $post = Post::findOrFail($post_id);

        $this->authorize('update', $post);

        $post->fill($params)->save();

        return redirect()->route('posts.show', ['post' => $post]);
    }

    public function destroy($post_id)
    {
        $post = Post::findOrFail($post_id);

        $this->authorize('delete', $post);

        \DB::transaction(function()use ($post){
            $post->comments()->delete();
            $post->delete();
        });

        return redirect()->route('top');
    }
}
