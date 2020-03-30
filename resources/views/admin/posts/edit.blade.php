@extends('layouts.app')

@section('content')
<div class="container text-center">
	<h1>Edit view for Admin</h1>
</div>
<div class="container">
	<form action="{{route('admin.posts.update', $post->id)}}" method="POST">
		@csrf
		@method('PATCH')
		<label for="title">Title</label>
		<input type="text" name="title" placeholder="Title" value="{{$post->title}}">
		<label for="text">Text</label>
		<input type="text" name="text" placeholder="Insert here your text" value="{{$post->text}}">
		<input type="submit" value="Submit">
	</form>
</div>
@endsection