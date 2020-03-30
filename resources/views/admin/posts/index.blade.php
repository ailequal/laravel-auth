@extends('layouts.app')

@section('content')
<div class="container text-center">
	<h1>Posts view for Admin</h1>
	<button type="button" class="btn btn-primary mb-4">Add</button>
</div>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			@foreach ($posts as $post)
			<div class="card mb-4">
				<a href="{{route('admin.posts.show', $post)}}">
					<div class="card-header">{{$post->title}}</div>
				</a>
				<div class="card-body">
					<p>{{$post->text}}</p>
				</div>
				<button type="button" class="btn btn-warning">Edit</button>
				<button type="button" class="btn btn-danger">Delete</button>
			</div>
			@endforeach
		</div>
	</div>
</div>
@endsection