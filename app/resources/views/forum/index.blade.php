@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Forums</div>

                <div class="panel-body">
                    @foreach ($threads as $thread)
                        <article>
                            <a href="{{ route('forum.show', $thread) }}">
                                <h4>{{ $thread->title }}</h4>
                            </a>
                        </article>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
