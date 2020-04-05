@extends('layout')

@section('content')
    <div class="container mt-4">
        <div class="border p-4">
            <div class="mb-4 text-left">
                <a class="btn btn-success" href="{{ route('top') }}">
                    投稿一覧に戻る
                </a>
            </div>
            <div class="mb-4 text-right">
                @if(Auth::user()->id === $post->user_id)
                    <a class="btn btn-primary" href="{{ route('posts.edit', ['post' => $post]) }}">
                        編集する
                    </a>
                    <form style="display: inline-block;" method="POST" action="{{ route('posts.destroy', ['post' => $post]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">削除する</button>
                    </form>
                @endif
            </div>  
            <h1 class="h5 mb-4">
                {{ $post->title }}
            </h1>
            <p class="mb-5">
                {!! nl2br(e($post->body)) !!}
            </p>
            <span class="h6 mb-4">投稿者:{{ $user->name }}さん</span>
            <section>
                <h2 class="h5 mb-4">
                    コメント
                </h2>
            <form class="mb-4" method="POST" action="{{ route('comments.store') }}">
                @csrf
                <input name="post_id" type="hidden" value="{{ $post->id }}">
                <div class="form-group">
                    <label for="body">
                        本文
                    </label>
                    <textarea id="body" name="body" class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" rows="4">{{ old('body') }}</textarea>
                    @if($errors->has('body'))
                        <div class="invalid-feedback">
                            {{ $errors->first('body') }}
                        </div>
                    @endif
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        コメントする
                    </button>
                </div>
            </form>

                @forelse($post->comments as $comment)
                    <div class="border-top p-4">
                        <time class="text-secondary">
                            {{ $comment->created_at->format('Y.m.d H:i') }}
                        </time>
                        <p class="mt-2">
                            {!! nl2br(e($comment->body)) !!}
                        </p>
                        <a class="btn btn-primary" href="{{ route('comments.edit', ['comment' => $comment]) }}">
                            編集する
                        </a>
                        <form style="display: inline-block;" method="POST" action="{{ route('comments.destroy', ['comment' => $comment]) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">削除する</button>
                        </form>
                    </div>
                @empty
                    <p>コメントはまだありません。</p>
                @endforelse
            </section>
        </div>
    </div>
@endsection