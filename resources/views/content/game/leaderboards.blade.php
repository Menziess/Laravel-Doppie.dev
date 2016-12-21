@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">

		<div class="col-md-6 col-centered">
			<div class="card shadow card-block">
				<h4 class="card-title">Klaverjassen</h4>
				@if(isset($klaverjassen) && count($klaverjassen) > 0)
					<table class="table table-hover table-striped table-large text-small text-xs-left">
						<thead>
							<tr>
								<th>Rank</th>
								<th>Picture</th>
								<th>Name</th>
								<th class="hidden-xs-down">Wins</th>
								<th class="hidden-md-down">Losses</th>
								<th class="hidden-md-down">Total games</th>
							</tr>
						</thead>
						<tbody>
						@foreach($klaverjassen as $key => $player)
							<tr class="clickable-row touchable" data-href="{{ url($player[0]->getProfileUrl()) }}">
								<td>
									<h3>{{ $key }}</h3>
									<strong><span class="text-success">{{ round($player[2] / ($player[2] + $player[3]) * 100) }}%</span></strong>
								</td>
								<td>
									<img src="{{ asset($player[0]->getPicture()) }}" class="img-circle profile-picture-small" style="width: 50px;" alt="" >
								</td>
								<td>{{ $player[0]->getName() }}</td>
								<td class="hidden-xs-down">{{ $player[2] }}</td>
								<td class="hidden-md-down">{{ $player[3] }}</td>
								<td class="hidden-md-down">{{ $player[2] + $player[3] }}</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				@endif
			</div>
		</div>

		<div class="col-md-6 col-centered">
			<div class="card shadow card-block">
				<h4 class="card-title">Hartenjagen</h4>
				@if(isset($hartenjagen) && count($hartenjagen) > 0)
					<table class="table table-hover table-striped table-large text-small text-xs-left">
						<thead>
							<tr>
								<th>Rank</th>
								<th>Picture</th>
								<th>Name</th>
								<th class="hidden-xs-down">Wins</th>
								<th class="hidden-md-down">Losses</th>
								<th class="hidden-md-down">Total games</th>
							</tr>
						</thead>
						<tbody>
						@foreach($hartenjagen as $key => $player)
							<tr class="clickable-row touchable" data-href="{{ url($player[0]->getProfileUrl()) }}">
								<td>
									<h3>{{ $key }}</h3>
									<strong><span class="text-success">{{ round($player[2] / ($player[2] + $player[3]) * 100) }}%</span></strong>
								</td>
								<td>
									<img src="{{ asset($player[0]->getPicture()) }}" class="img-circle profile-picture-small" style="width: 50px;" alt="" >
								</td>
								<td>{{ $player[0]->getName() }}</td>
								<td class="hidden-xs-down">{{ $player[2] }}</td>
								<td class="hidden-md-down">{{ $player[3] }}</td>
								<td class="hidden-md-down">{{ $player[2] + $player[3] }}</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				@endif
			</div>
		</div>

	</div>
</div>

@endsection
