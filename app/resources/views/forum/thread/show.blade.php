@extends('layouts.app')

@section('content')
<div class="container">

    {{ Breadcrumbs::render('threads.show', $thread) }}
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">{{ $thread->title }}</h4>

                    <p class="card-text"> 
                        {{ $thread->body }}
                    </p>

                    <p class="card-text">
                        Posted: {{ $thread->created_at->diffForHumans() }} by  
                        <a href="{{ route('profile', $thread->user->id) }}">
                            {{ $thread->user->name }}
                        </a>
                    </p>
                </div>
            </div>

            <!-- Show Replies -->
            @foreach ($thread->replies as $reply)
                 @include('forum.thread.reply')
            @endforeach

            <!-- Show Reply Form -->
            @auth
            <div class="card">
                <div class="card-body">

                     {!! Form::open(['url' => '/forum/' . $thread->forum->id . '/threads/' . $thread->id . '/replies']) !!}

                     <div class="form-group">
                            {{ Form::label('body', 'Reply to thread') }}
                            {{ Form::textarea('body', null, array('class'=>'form-control')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::submit('Submit', array('class'=>'btn btn-default')) }}
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
            @else
            <div class="card">
                <div class="card-body">
                    <a id="login-to-reply" href="{{ route('login') }}">
                        Login
                    </a>
                    to reply to threads.
                </div>
            </div>
            @endauth

        </div>
    </div>
</div>
@endsection