@extends('layouts.app')

@section('content')

<div class="container">

    {{ Breadcrumbs::render('home') }}

    <div class="jumbotron">
        <h5 class="display-4">What's New?</h5>
        <p class="lead">
            Latest Announcement:
            <a id="latest-announcement" href="{{ route('threads.show', [$latestAnnouncement->forum->id, $latestAnnouncement->id]) }}">
                {{ $latestAnnouncement->title }}
            </a>
        </p>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ env('APP_NAME', 'home') }}</h4>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
