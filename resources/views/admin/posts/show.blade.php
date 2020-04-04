@extends('layouts.app')

@section('content')
<div class="container text-center">
	<h1>Post view for Admin</h1>
</div>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 mb-4">
			<div class="card">
				<a href="{{route('admin.posts.show', $post->slug)}}">
					<div class="card-header">{{$post->title}}</div>
				</a>
				<div class="card-body">
					<div class="post">
						@if (!empty($post->path_image))
						<img class="mb-2" src="{{asset('storage/' . $post->path_image)}}" alt="post_image" style="width:80px;">
						@endif
						<p>{{$post->text}}</p>
						<h6 class="text-right">{{$post->user->name}}</h6>
						@if (Auth::id() === $post->user_id)
						<div class="container text-center mb-2">
							<a href="{{route('admin.posts.edit', $post->slug)}}"><button type="button"
									class="btn btn-warning">Edit</button></a>
							<form class="d-inline-block" action="{{route('admin.posts.destroy', $post->slug)}}" method="POST">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-danger">Delete</button>
							</form>
						</div>
						@endif
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
@endsection