
<div class="row">
	<form id="score-form" class="form-horizontal" method="POST" action="{{ url('game/save-score') }}">
	{!! csrf_field() !!}
	{{ method_field('PUT') }}

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

				@foreach($game->score as $round => $value)
					<tr>
						<td>{{ $round }}</td>
						@foreach($game->users as $user)
							@if($round == count($game->score))
								<td>
									<input name="{{ $user->first_name }}" class="form-control" style="width: 70px;" type="number" min="0" step="1" inputmode="numeric" pattern="[0-9]*"
									max="{{ $game->getPointsPerRound() }}"
									placeholder="{{ $game->score[$round][$user->first_name] }}">
								</td>
							@else
								<td>{{ $game->score[$round][$user->first_name] }}</td>
							@endif
						@endforeach
					</tr>
				@endforeach
		</tbody>
		</table>
		<button class="btn btn-primary-outline" type="submit">Save</button>

	</form>
</div>

<div class="row">
	<div id="modal-delete" class="modal fade">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
					<h4 class="modal-title">Delete {{ class_basename($game) }}</h4>
				</div>
				<div class="modal-body">
					<p>
						Deleting your {{ class_basename($game) }} will remove player scores too.
					</p>
				</div>
				<div class="modal-footer">
					<form class="form-horizontal" method="POST" action="{{ url('game/delete-game') }}">
						{!! csrf_field() !!}
						{{ method_field('DELETE') }}
						<button class="btn btn-danger-outline center-block" type="submit">Delete Game</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<hr>

	<button class="btn btn-danger center-block" type="submit" data-toggle="modal" data-target="#modal-delete">Stop</button>
</div>
