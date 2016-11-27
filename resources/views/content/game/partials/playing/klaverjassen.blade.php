
<form id="score-form" class="form-horizontal" method="POST" action="{{ url('game/save-score') }}">
{!! csrf_field() !!}
{{ method_field('PUT') }}

	<div class="card shadow m-t-3 scrolling-content">
		<table class="table table-hover table-striped table-large text-small text-xs-left">
			<thead style="background: #f5f5f5;">
				<tr>
					<th>#</th>
					@foreach(array_keys($game->getTeams()) as $team)
						<th>
							({{ $game->getTeams()[$team][0]->first_name }} & {{ $game->getTeams()[$team][1]->first_name }})<br/>
							{{ $team }}
						</th>
					@endforeach
				</tr>
			</thead>

			<tbody class="unselectable touchable">
				@foreach($game->data['scores'] as $round => $value)
					<tr {!! $round < count($game->data['scores']) ? 'class="clickable-row"' : '' !!}
						data-href="{{ url('game/round/' . $round) }}">
						<td class="td-fixed"><strong>{{ $round }}</strong></td>

						@foreach(array_keys($game->getTeams()) as $team)
							@if($round == count($game->data['scores']) && Auth::user() == $game->user)
								<td>
									<div class="form-inline">
										<input name="{{ $team }}" class="form-control" style="width: 100px;" type="number" inputmode="numeric" pattern="[0-9]*"
										placeholder="0" autofocus="autofocus">
										<input name="{{ $team }}-roem" class="form-control" style="width: 100px;" min="0" step="10" type="number" inputmode="numeric" pattern="[1-9]+[0]"
										placeholder="Roem" autofocus="autofocus">
									</div>
								</td>
							@else
								<td>
									<span style="margin-right: 10px;">
										{{ $game->data['scores'][$round][$team] }}
									</span>
									@if ($game->data['scores'][$round][$team . '-roem'] > 0)
									<span class="text-success" style="width: 100px;">
										<b>{{ $game->data['scores'][$round][$team . '-roem'] }} roem</b>
									</span>
									@endif
								</td>
							@endif
						@endforeach

					</tr>
				@endforeach

				@if(count($game->data['scores']) > 1)
					<tr style="background: #f5f5f5;">
						<td></td>
						@foreach(array_keys($game->getTeams()) as $team)
							<td>
								<strong>{{ $team }}</strong>
								<br/>
								{{ $game->getTotalKlaverjassenScores()[$team] }}
								@if($game->getTotalKlaverjassenScores()[$team . '-roem'] > 0)
									+
									<span class="text-success"><b>{{ $game->getTotalKlaverjassenScores()[$team . '-roem'] }}</b></span> = &emsp;
									<b>{{ $game->getTotalKlaverjassenScores()[$team] + $game->getTotalKlaverjassenScores()[$team . '-roem'] }}</b>
								@endif
							</td>
						@endforeach
					</tr>
				@endif
			</tbody>
		</table>
	</div>

	<div class="container">
		<div class="row">
		<div id="feedback"></div>
		@include('errors.feedback')
			@if(Auth::user() == $game->user || Auth::user()->is_admin)
				<button class="btn btn-primary-outline" type="submit">Save</button>
			@endif
			<button style="display: inline-block;" class="btn btn-danger-outline center-block" type="button" data-toggle="modal" data-target="#modal-delete">Stop</button>
		</div>
	</div>

</form>

<div id="bottom" class="row">
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
						Beware <strong>{{ Auth::user()->first_name }}</strong>,<br/>
						your action will be registered and charged against you in case of game manipulation.
						@if($game->started_at->addMinutes(80) > Carbon\Carbon::now())
						<br/><br/>
						Time untill delete button will be publicly available in:<br/>
						<b>{{ $game->started_at->addMinutes(80)->diffInMinutes(Carbon\Carbon::now()) }}</b> minutes
						@endif
					</p>
				</div>
				<div class="modal-footer">
					@if(Auth::user() == $game->user || Auth::user()->is_admin || $game->started_at->addMinutes(80) < Carbon\Carbon::now())
					<form class="form-horizontal" method="POST" action="{{ url('game/delete-game') }}">
						{!! csrf_field() !!}
						{{ method_field('DELETE') }}
						<button class="btn btn-danger" type="submit">Delete</button>
					</form>
					@else
						<button class="btn btn-danger disabled">Delete</button>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

@push('scripts')
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".clickable-row").click(function() {
			window.document.location = $(this).data("href");
		});
		$("#score-form").submit(function() {

			var enteredScore = 0;
			var playerHasAllPoints = true;
			var pointsPerRound = {{ $game->getPointsPerRound() }};
			var inputs = $("input[type=number]");

			inputs.each(function (i, e) {
				// val = parseInt(e.value) || 0;
				// if (val != pointsPerRound && val != 0) {
				// 	playerHasAllPoints = false;
				// }
				// enteredScore += val;
			});

			// submit = (playerHasAllPoints && enteredScore == (inputs.size() - 1) * pointsPerRound) || (!playerHasAllPoints && enteredScore == pointsPerRound);
			// message = playerHasAllPoints ? 'Did you forget someone?' : 'You distributed ' + enteredScore + ' of ' + pointsPerRound + ' points.';
			// content = (
			// 	'<div class="alert alert-warning" role="alert">' +
			// 	message	+
			// 	'</div>'
			// );
			submit = true;
			if (!submit) {
				document.getElementById("feedback").innerHTML = content;
			} else {
				document.getElementById("feedback").innerHTML = null;
			}
			return submit;
		});
	});
</script>
@endpush

