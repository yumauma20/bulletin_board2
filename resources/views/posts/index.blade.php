@extends('layout')

@section('content')
    <div class="container mt-4">
        @foreach($posts as $post)
            <div class="card md-4">
                <div class="card-header">
                    {{ $post->title }}
                </div>
                <div class="card-body">
                    <p class="card-text">
                        {{ $post->body }}
                    </p>
                </div>
                <div class="card-footer">
                    <span class="mr-2">
                        投稿日時{{ $post->created_at->format('Y.m.d') }}
                    </span>

                    @if ($post->comments->count())
                        <span class="badge badge-primary">
                            コメント{{ $post->comments->count() }}件
                        </span>
                    @endif
                </div>
            </div>
            <br>
        @endforeach   
    </div>
@endsection    