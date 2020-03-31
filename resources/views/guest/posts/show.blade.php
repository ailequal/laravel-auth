@extends('layouts.app')

@section('content')
<div class="container text-center">
	<h1>Post view for Guest</h1>
</div>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card mb-4">
				<a href="{{route('guest.posts.show', $post->slug)}}">
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
						<p>Empty</p>
						@endforelse
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container text-center">
	<h3>Add a comment</h3>
</div>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-body">
					<form action="{{route('guest.comments.store')}}" method="POST">
						@csrf
						@method('POST')
						<div class="d-block">
							<label for="name">Name</label>
							<input type="text" name="name" placeholder="Name">
						</div>
						<div class="d-block">
							<label for="email">Email</label>
							<input type="text" name="email" placeholder="Email">
						</div>
						<div class="d-block">
							<label for="text">Text</label>
							<input type="text" name="text" placeholder="Text">
						</div>
						<input type="submit" value="Submit">
						<input type="hidden" name="post_id" value="{{$post->id}}">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection