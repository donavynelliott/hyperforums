@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                {!! Form::open(['url' => 'threads']) !!}
                <div class="panel-heading">
                    <div class="form-group">
                        {{ Form::label('title', 'Thread Title') }}
                        {{ Form::text('title', null, array('class'=>'form-control') ) }}
                    </div>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        {{ Form::label('body', 'Thread Content') }}
                        {{ Form::textarea('body', null, array('class'=>'form-control')) }}
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
