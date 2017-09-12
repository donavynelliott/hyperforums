@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Forums</h4>

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
