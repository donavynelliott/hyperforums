@extends('layouts.app')

@section('content')
<div class="container">

    {{ Breadcrumbs::render('threads.create', $forum) }}

    @php
        $title = (isset($_GET['thread']['title'])) ? $_GET['thread']['title'] : '';
        $body = (isset($_GET['thread']['body'])) ? $_GET['thread']['body'] : '';
    @endphp

    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            @include('partials.errors')

            <div class="card">
                {!! Form::open(['url' => '/forum/' . $forum->id . '/threads/store']) !!}

                <div class="card-body">
                    <div class="form-group">
                       <h4 class="card-title"> {{ Form::label('title', 'Thread Title') }} </h4>
                        {{ Form::text('title', $title, array('class'=>'form-control') ) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('Thread Body', 'Body') }}
                        {{ Form::textarea('body', $body, array('class'=>'form-control')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::submit('Submit', array('class'=>'btn btn-default')) }}
                    </div>
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>
@endsection
