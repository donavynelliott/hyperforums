<?php

// /Home
Breadcrumbs::register('home', function ($breadcrumbs) {
	$breadcrumbs->push('Home', route('home'));
});


// /Forum
// Forums
Breadcrumbs::register('forum', function ($breadcrumbs) {
	$breadcrumbs->push('Forums', route('forum'));
});


// /Forum/{forum_id}
// Forums -> Announcements
Breadcrumbs::register('forum.show', function ($breadcrumbs, $forum) {
	$breadcrumbs->parent('forum');
	$breadcrumbs->push($forum->name, route('forum.show', $forum));
});

// /Forum/{forum_id}/threads/create
// Forums -> Announcements -> Create Thread
Breadcrumbs::register('threads.create', function ($breadcrumbs, $forum) {
	$breadcrumbs->parent('forum.show', $forum);
	$breadcrumbs->push('Create Thread', route('threads.create', $forum));
});

// /Forum/{forum_id}/threads/{thread_id}
// Forums -> Announcements -> Welcome to Hyperforums
Breadcrumbs::register('threads.show', function ($breadcrumbs, $thread) {
	$breadcrumbs->parent('forum.show', $thread->forum);
	$breadcrumbs->push($thread->title, route('threads.show', [$thread->forum, $thread]));
});