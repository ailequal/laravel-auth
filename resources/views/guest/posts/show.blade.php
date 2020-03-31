@extends('layouts.app')

@section('content')
<h1 class="text-center">Post view for Guest</h1>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card mb-4">
				<a href="{{route('guest.posts.show', $post)}}">
					<div class="card-header">{{$post->title}}</div>
				</a>
				<div class="card-body">
					<div class="post">
						<p>{{$post->text}}</p>
						<h6 class="text-right">{{$post->user->name}}</h6>
					</div>
					<div class="comments">
						<h6>Comments</h6>
						@forelse ($post->comments as $comment)
						<div class="mb-2">
							<p>{{$comment->text}}</p>
							<h6 class="text-right">{{$comment->name}}</h6>
						</div>
						@empty
						<p>No comment</p>
						@endforelse
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection