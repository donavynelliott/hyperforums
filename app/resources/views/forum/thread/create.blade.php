@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                {!! Form::open(['url' => '/forum/' . $forum->id . '/threads/store']) !!}
                
                <div class="card-body">
                    <div class="form-group">
                       <h4 class="card-title"> {{ Form::label('title', 'Thread Title') }} </h4>
                        {{ Form::text('title', null, array('class'=>'form-control') ) }}
                    </div>

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
