@extends('layouts.app')

@section('content')
<div class="container text-center">
	<h1>Posts view for Guest</h1>
</div>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			@foreach ($posts as $post)
			<div class="card mb-4">
				<a href="{{route('guest.posts.show', $post->slug)}}">
					<div class="card-header">{{$post->title}}</div>
				</a>
				<div class="card-body">
					<p>{{$post->text}}</p>
					<h6 class="text-right">{{$post->user->name}}</h6>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
@endsection