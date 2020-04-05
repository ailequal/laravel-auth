@extends('layouts.app')

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif
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
						@if (!empty($post->path_image))
						<img class="mb-2" src="{{asset('storage/' . $post->path_image)}}" alt="post_image" style="width:80px;">
						@endif
						<p>{{$post->text}}</p>
						<h6 class="text-right">{{$post->user->name}}</h6>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container text-center">
	<h3>Tags</h3>
</div>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card mb-4">
				<div class="card-body">
					<div>
						@forelse ($post->tags as $tag)
						<span>{{$tag->name}}</span>
						@empty
						<span>Empty</span>
						@endforelse
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container text-center">
	<h3>Comments</h3>
</div>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card mb-4">
				<div class="card-body">
					<div>
						@forelse ($post->comments as $comment)
						<p>{{$comment->text}}</p>
						<h6 class="text-right">{{$comment->name}}</h6>
						@empty
						<span>Empty</span>
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
							<input type="text" name="name" placeholder="Name" value="{{old('name')}}">
						</div>
						<div class="d-block">
							<label for="email">Email</label>
							<input type="text" name="email" placeholder="Email" value="{{old('email')}}">
						</div>
						<div class="d-block">
							<label for="text">Text</label>
							<input type="text" name="text" placeholder="Text" value="{{old('text')}}">
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