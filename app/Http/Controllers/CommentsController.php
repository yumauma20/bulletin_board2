<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
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
        $user = User::findOrFail(Auth::User()->id);
        $user_id = $user->id;
            
        $comment = new Comment();
        $comment->body = $request->body;
        $comment->user_id = $user_id;

        $post->comments()->save($comment);

        return redirect()->route('posts.show', ['post' => $post]);
    }

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);

        $this->authorize('update', $comment);

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

        $this->authorize('update', $comment);

        $comment->fill($params)->save();

        return redirect()->route('posts.show', ['post' => $comment->post_id]);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        $this->authorize('delete', $comment);

        \DB::transaction(function()use ($comment){
            $comment->delete();
        });

        return redirect()->route('top');
    }
}
