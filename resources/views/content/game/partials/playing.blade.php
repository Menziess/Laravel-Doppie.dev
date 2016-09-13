
<form id="score-form" class="form-horizontal" method="POST" action="{{ url('game/save-score') }}">
{!! csrf_field() !!}
{{ method_field('PUT') }}

	<div class="card shadow m-t-3 scrolling-content">
		<table class="table table-hover table-striped table-large text-small text-xs-left">
			<thead style="background: #f5f5f5;">
				<tr">
					<th>#</th>
					@foreach($game->users as $user)
						<th>{{ $user->first_name }}</th>
					@endforeach
				</tr>
			</thead>

			<tbody>
				@foreach($game->data['scores'] as $round => $value)
					<tr {!! $round < count($game->data['scores']) ? 'class="clickable-row"' : '' !!}
						data-href="{{ url('game/round/' . $round) }}">
						<td class="td-fixed"><strong>{{ $round }}</strong></td>
						@foreach($game->users as $user)
							@if($round == count($game->data['scores']) && Auth::user() == $game->user)
								<td>
									<input name="{{ $user->id }}" class="form-control" style="width: 70px;" type="number" min="0" step="1" inputmode="numeric" pattern="[0-9]*"
									max="{{ $game->getPointsPerRound() }}"
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
						@foreach($game->users as $user)
							<td>
								<strong>{{ $user->first_name }}</strong>
								<br/>
								{{ $game->getTotalScores()[$user->id] }}
							</td>
						@endforeach
					</tr>
				@endif
			</tbody>
		</table>
	</div>

	<div class="container">
		<div class="row">
		@include('errors.feedback')
			@if(Auth::user() == $game->user || Auth::user()->is_admin)
				<button class="btn btn-primary-outline" type="submit">Save</button>
			@endif
			<button style="display: inline-block;" class="btn btn-danger center-block" type="button" data-toggle="modal" data-target="#modal-delete">Stop</button>
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
						<br/><br/>

						Time untill delete button will be publicly available in:<br/>
						<b>{{ $game->started_at->addMinutes(80)->diffInMinutes(Carbon\Carbon::now()) }}</b> minutes
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
			var result = false;
			$("input[type=number]").each(function ($i, $e) {
				if ({{ $game->getPointsPerRound() }} == parseInt($e.value)) {
					result = true;
				}
				enteredScore += parseInt($e.value) || 0;
			});
			return (enteredScore == {{ $game->getPointsPerRound() }}) || result;
		});
	});
</script>
@endpush
