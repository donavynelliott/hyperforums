@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $thread->title }}</div>

                <div class="panel-body">
                    {{ $thread->body }}    
                </div>

                <div class="panel-body">
                    Posted: {{ $thread->created_at->diffForHumans() }} by  
                    <a href="{{ route('profile', $thread->user->id) }}">
                        {{ $thread->user->name }}
                    </a>
                </div>

            </div>
            @foreach ($thread->replies as $reply)
                 @include('forum.reply')
            @endforeach
        </div>
    </div>
</div>
@endsection
