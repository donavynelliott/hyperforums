<div class="panel panel-default">
    <div class="panel-body">
        {{ $reply->body }} 
    </div>

    <div class="panel-body">
        Posted: {{ $reply->created_at->diffForHumans() }} by  
        <a href="{{ route('profile', $reply->user->id ) }}">
        	{{ $reply->user->name }}
        </a>
    </div>

</div>