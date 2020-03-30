@extends('layouts.app')

@section('content')
<h1 class="text-center">Post view for Admin</h1>
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