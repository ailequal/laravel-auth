@extends('layouts.app')

@section('content')
<h1 class="text-center">Post view for Guest</h1>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<a href="{{route('guest.posts.show', $post)}}">
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