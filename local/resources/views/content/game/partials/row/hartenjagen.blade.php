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
										<input name="{{ $user }}" class="form-control" style="width: 70px;" type="number" step="1" inputmode="numeric" pattern="[0-9]*"
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
						<button class="btn btn-primary-outline" type="submit">Update</button>
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
