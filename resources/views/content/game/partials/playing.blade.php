
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

				<tr>
					<td>1</td>

				</tr>

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
