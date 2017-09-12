@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $user->name }}'s Profile</h4>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    Welcome
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
