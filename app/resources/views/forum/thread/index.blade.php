@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">

                <div class="card-header">
                    <h1 class="inline-block">{{ $forum->name }}</h1>
                    <div class="text-right float-right">
                        <a href="{{ route('forum.addthread', $forum) }}">
                            <button class="btn btn-default">New Thread</button>
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card-text">
                        <table id="threads" class="table">
                            <thead>
                                <tr>
                                    <th>Thread</th>
                                    <th>Replies</th>
                                    <th>Created</th>
                                </tr>    
                            </thead>
                            <tbody>

                                @foreach ($forum->threads as $thread)
                                    <tr>
                                        
                                        <td>
                                           <a href="{{$forum->id}}/threads/{{$thread->id}}">
                                                {{ $thread->title }}
                                            </a>
                                        </td>
                                        <td name="thread_{{ $thread->id }}_reply_count">
                                            {{$thread->replies->count()}}
                                        </td>
                                        <td>today</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
