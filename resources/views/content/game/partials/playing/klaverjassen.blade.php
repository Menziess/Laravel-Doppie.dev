
<form id="score-form" class="form-horizontal" method="POST" action="{{ url('game/save-score') }}">
{!! csrf_field() !!}
{{ method_field('PUT') }}

	<div class="card shadow m-t-3 scrolling-content">
		<table class="table table-hover table-striped table-large text-small text-xs-left">
			<thead style="background: #f5f5f5;">
				<tr">
					<th>#</th>
					@foreach($game->users as $i => $user)
						<th>
							{{ $user->first_name }}
						</th>
					@endforeach
				</tr>
			</thead>

			<tbody class="unselectable touchable">
				@foreach($game->data['scores'] as $round => $value)
					<tr {!! $round < count($game->data['scores']) ? 'class="clickable-row"' : '' !!}
						data-href="{{ url('game/round/' . $round) }}">
						<td class="td-fixed"><strong>{{ $round }}</strong></td>
						@foreach($game->users as $user)
							@if($round == count($game->data['scores']) && Auth::user() == $game->user)
								<td>
									<input name="{{ $user->id }}" class="form-control" style="width: 70px;" type="number" inputmode="numeric" pattern="[0-9]*"
									placeholder="0" autofocus="autofocus">
								</td>
							@else
								<td>{{ $game->data['scores'][$round][$user->id] }}</td>
							@endif
						@endforeach
					</tr>
				@endforeach

				@if(count($game->data['scores']) > 1)
					<tr style="background: #f5f5f5;">
						<td></td>
						@foreach($game->users as $i => $user)
							<td>
								<strong>{{ $user->first_name }}</strong>
								<br/>
								{{ $game->getTotalScores()[$user->id] }}
								@if(++$i % count($game->users) == count($game->data['scores']) % count($game->users))
									- <i class="fa fa-random text-primary" aria-hidden="true" title="Shuffle"></i>
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
				val = parseInt(e.value) || 0;
				if (val != pointsPerRound && val != 0) {
					playerHasAllPoints = false;
				}
				enteredScore += val;
			});

			submit = (playerHasAllPoints && enteredScore == (inputs.size() - 1) * pointsPerRound) || (!playerHasAllPoints && enteredScore == pointsPerRound);
			message = playerHasAllPoints ? 'Did you forget someone?' : 'You distributed ' + enteredScore + ' of ' + pointsPerRound + ' points.';
			content = (
				'<div class="alert alert-warning" role="alert">' +
				message	+
				'</div>'
			);
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

