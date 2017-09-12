<div class="card">
    <div class="card-body">
       	<p class="card-text"> 
       		{{ $reply->body }} 
       	</p>
	<p class="card-text">

		Posted: {{ $reply->created_at->diffForHumans() }} by

		<a href="{{ route('profile', $reply->user->id ) }}">
			{{ $reply->user->name }}
		</a>
	</p>
    </div>
</div>