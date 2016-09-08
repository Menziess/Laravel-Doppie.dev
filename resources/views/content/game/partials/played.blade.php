
<div class="row">

	<div class="card">
		test
	</div>

	<table class="table table-hover table-large text-small text-xs-left">
		<thead>
			<tr class="table-success">
				<th>#</th>
				@foreach($game->users as $user)
					<th>{{ $user->first_name }}</th>
				@endforeach
			</tr>
		</thead>
	<tbody>

		@foreach($game->data['scores'] as $round => $value)
			@if($round != count($game->data['scores']))
				<tr>
					<td><strong>{{ $round }}</strong></td>
					@foreach($game->users as $user)
						<td>{{ $game->data['scores'][$round][$user->id] }}</td>
					@endforeach
				</tr>
			@endif
		@endforeach
		@if(count($game->data['scores']) > 1)
			<tr class="table-success">
				<td>Total</td>
				@foreach($game->users as $user)
					<td>{{ $user->first_name . ': ' . $game->getTotalScores()[$user->id] }}</td>
				@endforeach
			</tr>
		@endif

	</tbody>
	</table>

</div>
