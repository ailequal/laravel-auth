@extends('layouts.app')

@section('content')
<div class="container text-center">
	<h1>Create view for Admin</h1>
</div>
<form action="{{route('admin.posts.store')}}" method="POST" enctype='multipart/form-data'>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card mb-4">
					<div class="card-body">
						@csrf
						@method('POST')
						<div class="d-block">
							<label for="title">Title</label>
							<input type="text" name="title" placeholder="Title">
						</div>
						<div class="d-block">
							<label for="text">Text</label>
							<input type="text" name="text" placeholder="Insert here your text">
						</div>
						<div class="d-block">
							<input type="file" name="path_image" accept="image/*">
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
							<input type="checkbox" name="tags[]" value="{{$tag->id}}">
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