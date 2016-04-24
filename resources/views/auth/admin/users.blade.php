@extends('layouts.app')

@section('content')
<div class="container fluid">
	<div class="row row-centered">
		<div class="col-md-8 col-md-offset-2 col-centered">
			<div class="panel panel-default">

				@if(isset($users))

					<table class="table table-hover text-small">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Email</th>
								<th>Creation Date</th>
							</tr>
						</thead>
					<tbody>
					@foreach($users as $user)
						<tr>
							<td>{{ $user->id }}</td>
							<td>{{ $user->first_name }} {{ $user->last_name }}</td>
							<td>{{ $user->email }}</td>
							<td>{{ $user->created_at }}</td>
						</tr>
					@endforeach
					  </tbody>
					</table>

					{!! $users->links() !!}

				@else
					No users... Sorry!
				@endif

			</div>
		</div>
	</div>
</div>
@endsection
