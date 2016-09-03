
<div id="players" class="card card-block">
	<div class="row">
		<div class="col-md-6 col-md-offset-3 col-centered">

			<table class="table table-hover table-large text-small text-xs-left">
				<thead>
					<tr>
						<th>#</th>
						@foreach($game->users as $user)
							<th>{{ $user->first_name }}</th>
						@endforeach
					</tr>
				</thead>
			<tbody>

				{{-- <tr class="clickable-row" data-href="{{ url($user->getProfileUrl()) }}">
					<td>{{ $user->id }}</td>
					<td><img src="{{ asset($user->getPicture()) }}" class="img-circle profile-picture-small" style="width: 50px;" alt="" ></td>
					<td>
						{{ $user->getName() }}
						@if(Auth::user()->is_admin)
						<br>
						{!! $user->is_active
							? '<span class="label label-pill label-success">active</span>'
							: '<span class="label label-pill label-warning">inactive</span>' !!}
						{!! $user->is_admin
							? '<span class="label label-pill label-primary">admin</span>'
							: '' !!}
						@endif
					</td>
					<td class="hidden-xs-down">{{ $user->email }}</td>
					<td class="hidden-xs-down">{{ $user->created_at }}</td>
				</tr> --}}

			</tbody>
			</table>

		</div>
	</div>
</div>

<form id="form-profile" class="form-horizontal" method="POST" action="{{ url('game/delete-game') }}">
	{!! csrf_field() !!}
	{{ method_field('DELETE') }}
	<button class="btn btn-danger-outline center-block" type="submit">Stop Game</a>
</form>
