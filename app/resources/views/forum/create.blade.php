@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                {!! Form::open(['url' => 'threads']) !!}
                <div class="panel-heading">
                    {!! Form::label('title', 'Thread Title') !!}
                    {!! Form::text('title') !!}
                </div>

                <div class="panel-body">
                    {!! Form::label('body', 'Thread Content') !!}
                    {!! Form::textarea('body') !!}
                    {!! Form::submit('Submit') !!}
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>
@endsection
