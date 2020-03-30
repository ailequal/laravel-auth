@extends('layouts.app')

@section('content')
<div class="container text-center">
	<h1>Create view for Admin</h1>
</div>
<div class="container">
	<form action="{{route('admin.posts.store')}}" method="POST">
		@csrf
		@method('POST')
		<label for="title">Title</label>
		<input type="text" name="title" placeholder="Title">
		<label for="text">Text</label>
		<input type="text" name="text" placeholder="Insert here your text">
		<input type="submit" value="Submit">
	</form>
</div>
@endsection