@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Breacrumbs --}}

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-body">

                    @if ( Auth::user()->id == $reply->user->id )

                     {!! Form::open(['url' => '/replies/' . $reply->id, 'method' => 'put']) !!}

                     <div class="form-group">
                            {{ Form::label('body', 'Reply to thread') }}
                            {{ Form::textarea('body', $reply->body, array('class'=>'form-control')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::submit('Submit', array('class'=>'btn btn-default')) }}
                    </div>

                    {!! Form::close() !!}

                    @else
                        You must be the author of this reply to edit.
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
