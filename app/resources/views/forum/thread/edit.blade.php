@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Breadcrumbs Placeholder --}}

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">

                @if ( Auth::user()->id == $thread->user->id )

                {!! Form::open(['url' => '/threads/' . $thread->id, 'method' => 'put']) !!}

                <div class="card-body">
                    <div class="form-group">
                       <h4 class="card-title"> {{ Form::label('title', 'Thread Title') }} </h4>
                        {{ Form::text('title', $thread->title, array('class'=>'form-control') ) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('body', 'Thread Content') }}
                        {{ Form::textarea('body', $thread->body, array('class'=>'form-control')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::submit('Submit', array('class'=>'btn btn-default')) }}
                    </div>
                </div>

                {!! Form::close() !!}

                @else

                <div class="card-body">
                    You must be the author of this thread to edit.
                </div>

                @endif

            </div>
        </div>
    </div>
</div>
@endsection
