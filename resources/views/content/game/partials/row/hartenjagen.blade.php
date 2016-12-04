@extends('layouts.app')

@section('content')

<div class="container">

	@if($game)

		<form id="score-form" class="form-horizontal" method="POST" action="{{ url('game/round/' . $nr) }}">
		{!! csrf_field() !!}
		{{ method_field('PUT') }}
			<div class="card shadow m-t-3">
				<div class="card-block">
					<h2 class="card-title">Edit Row {{ $nr }}</h2>
				</div>
				<div class="scrolling-content">
					<table class="table table-hover table-large text-small text-xs-left">
						<thead style="background: #f5f5f5;">
							<tr>
								<th>#</th>
								@foreach($game->users as $user)
									<th>{{ $user->first_name }}</th>
								@endforeach
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>{{ $nr }}</td>
								@foreach($game->getData('scores')->{$nr} as $user => $points)
									<td>
										<input name="{{ $user }}" class="form-control" style="width: 70px;" type="number" min="0" step="1" inputmode="numeric" pattern="[0-9]*"
										max="{{ $game->getPointsPerRound() }}"
										value="{{ $points }}" autofocus="autofocus"
										{{ Auth::user() == $game->user || Auth::user()->is_admin ? '' : '' }}>
									</td>
								@endforeach
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			@if(Auth::user() == $game->user || Auth::user()->is_admin)
				<div class="container">
					<div class="row">
						@include('errors.feedback')
						<button class="btn btn-primary-outline" type="submit">Save</button>
						<a href="{{ url('game') }}" class="btn btn-secondary" role="button">Back</a>
					</div>
				</div>
			@endif
		</form>
	@else
		The requested game doesn't exist...
	@endif

</div>

@endsection


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

