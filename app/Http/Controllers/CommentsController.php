<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Comment;

class CommentsController extends Controller
{
    /**
     * コメントを投稿する
     * 
     * @param Request $request
     */
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



    /**
    * コメントを編集する
    *
    * @param  int $id
    */
    public function edit(int $id)
    {
        $comment = Comment::findOrFail($id);

        $this->authorize('update', $comment);

        return view('comments.edit', [
            'comment' => $comment,
        ]);
    }



    /**
     * コメントを更新する
     * 
     * @param int $id
     * @param Reqiest $request
     */
    public function update(int $id, Request $request)
    {
        $params = $request->validate([
            'body' => 'required|max:2000',
        ]);

        $comment = comment::findOrFail($id);

        $this->authorize('update', $comment);

        $comment->fill($params)->save();

        return redirect()->route('posts.show', ['post' => $comment->post_id]);
    }



    /**
     * コメントを削除
     * 
     * @param int $id
     */
    public function destroy(int $id)
    {
        $comment = Comment::findOrFail($id);

        $this->authorize('delete', $comment);

        \DB::transaction(function()use ($comment){
            $comment->delete();
        });

        return redirect()->route('top');
    }
}
