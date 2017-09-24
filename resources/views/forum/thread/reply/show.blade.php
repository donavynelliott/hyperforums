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

	@if (!(Auth::guest()) && Auth::user()->id == $reply->user->id)
            <p class="card-text">
                <a href="{{ route('replies.edit', $reply) }}" name="reply_{{ $reply->id}}_edit">
                    <button class="btn btn-default">Edit Reply</button>
                </a>
            </p>
            @endif

    </div>
</div>
