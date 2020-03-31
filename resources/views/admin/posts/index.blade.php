@extends('layouts.app')

@section('content')
<div class="container text-center">
	<h1>Posts view for Admin</h1>
	<a href="{{route('admin.posts.create')}}"><button type="button" class="btn btn-primary mb-4">Add</button></a>
</div>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			@foreach ($posts as $post)
			<div class="card mb-4">
				<a href="{{route('admin.posts.show', $post->slug)}}">
					<div class="card-header">{{$post->title}}</div>
				</a>
				<div class="card-body">
					<p>{{$post->text}}</p>
					<h6 class="text-right">{{$post->user->name}}</h6>
				</div>
				<div class="container text-center mb-2">
					<a href="{{route('admin.posts.edit', $post->slug)}}"><button type="button"
							class="btn btn-warning">Edit</button></a>
					<form class="d-inline-block" action="{{route('admin.posts.destroy', $post->slug)}}" method="POST">
						@csrf
						@method('DELETE')
						<button type="submit" class="btn btn-danger">Delete</button>
					</form>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
@endsection