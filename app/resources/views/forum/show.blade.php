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

            <!-- Show Replies -->
            @foreach ($thread->replies as $reply)
                 @include('forum.reply')
            @endforeach

            <!-- Show Reply Form -->
            @auth
            <div class="panel panel-default">
                <div class="panel-body">

                     {!! Form::open(['url' => 'threads/' . $thread->id . '/replies']) !!}

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
            <div class="panel panel-default">
                <div class="panel-body">
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
