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
                    Posted: {{ $thread->created_at->diffForHumans() }} by  {{ $thread->user->name }}
                </div>

            </div>
            @foreach ($thread->replies as $reply)
                 <div class="panel panel-default">
                    <div class="panel-body">
                        {{ $reply->body }} 
                    </div>

                    <div class="panel-body">
                        Posted: {{ $reply->created_at->diffForHumans() }} by  {{ $reply->user->name }}
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
