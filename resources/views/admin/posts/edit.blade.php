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
	<h1>Edit view for Admin</h1>
</div>
<form action="{{route('admin.posts.update', $post->id)}}" method="POST">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card mb-4">
					<div class="card-body">
						@csrf
						@method('PATCH')
						<div class="d-block">
							<label for="title">Title</label>
							<input type="text" name="title" placeholder="Title" value="{{$post->title}}">
						</div>
						<div class="d-block">
							<label for="text">Text</label>
							<input type="text" name="text" placeholder="Insert here your text" value="{{$post->text}}">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container text-center">
		<h3>Add some tags</h3>
	</div>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card mb-4">
					<div class="card-body">
						@foreach ($tags as $tag)
						<div>
							<span>{{$tag->name}}</span>
							<input type="checkbox" name="tags[]" value="{{$tag->id}}" {{$tag->id}}
								{{($post->tags->contains($tag->id)) ? 'checked' : ''}}>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card mb-4">
					<div class="card-body text-center">
						<input type="submit" value="Submit">
					</div>
				</div>
			</div>
		</div>
</form>
@endsection