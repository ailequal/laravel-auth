@extends('layouts.app')

@section('content')
<div class="container text-center">
	<h1>Create view for Admin</h1>
</div>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-body">
					<form action="{{route('admin.posts.store')}}" method="POST">
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
						<input type="submit" value="Submit">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection