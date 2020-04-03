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
						<img src="{{$post->path_image}}" alt="image">
						<img src="{{asset('storage/' . $post->path_image)}}" alt="image" style="width:100px;">
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
	<h3>Tags</h3>
</div>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card mb-4">
				<div class="card-body">
					<div>
						@foreach ($post->tags as $tag)
						<span>{{$tag->name}}</span>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection