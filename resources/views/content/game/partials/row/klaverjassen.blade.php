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
								@foreach(array_keys($game->getTeams()) as $team)
									<th>
										{{ $team }}
									</th>
									<th>
										Roem
									</th>
								@endforeach
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>{{ $nr }}</td>
								@foreach($game->getData('scores')->{$nr} as $input => $points)
									<td>
										<div class="form-inline">
											<input name="{{ $input }}" class="form-control" style="width: 75px;" min="0" step="1" type="number" inputmode="numeric" pattern="[0-9]*"
											placeholder="0" value="{{ $points }}" autofocus="autofocus">
										</div>
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
