@extends('layouts.app')

@section('content')

<div class="container">

    {{ Breadcrumbs::render('forum') }}

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">

                <div class="card-header">
                    <h1>Forums</h1>
                </div>

                <div class="card-body">

                <table id="forums" class="table">
                    <thead>
                        <tr>
                            <th>Forum</th>
                            <th>Threads</th>
                            <th>Replies</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($forums as $forum)
                            <tr>

                                <td name="forum_name">
                                    <a href="{{ route('forum.show', $forum) }}">
                                        {{ $forum->name }}
                                    </a>
                                </td>
                                <td name="forum_{{ $forum->id }}_thread_count">
                                    {{ $forum->threads->count() }}
                                </td>

                                <td name="forum_{{ $forum->id }}_reply_count">
                                    {{ $forum->replies->count() }}
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
