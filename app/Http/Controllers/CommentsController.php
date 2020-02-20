<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
        $params = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'body' => 'required|max:2000',
        ]);

        $post = Post::findOrFail($params['post_id']);
        $post->comments()->create($params);

        return redirect()->route('posts.show', ['post' => $post]);
    }

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);

        return view('comments.edit', [
            'comment' => $comment,
        ]);
    }

    public function update($id, Request $request)
    {
        $params = $request->validate([
            'body' => 'required|max:2000',
        ]);

        $comment = comment::findOrFail($id);
        $comment->fill($params)->save();

        return redirect()->route('posts.show', ['post' => $comment->post_id]);
    }

}
