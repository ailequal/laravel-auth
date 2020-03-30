@extends('layouts.app')

@section('content')
<div class="container text-center">
	<h1>Post view for Admin</h1>
</div>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 mb-4">
			<div class="card">
				<a href="{{route('admin.posts.show', $post)}}">
					<div class="card-header">{{$post->title}}</div>
				</a>
				<div class="card-body">
					<p>{{$post->text}}</p>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection