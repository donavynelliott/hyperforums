@if ($errors->any())
    <div class="alert alert-danger">
        <h4>Please correct the following errors</h4>
        <hr>
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
