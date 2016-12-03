<div class="card shadow m-t-3">
	<div class="card-block">
		<h2 class="card-title">New Game</h2>
		@if($game->finished_at->addDays(1) < Carbon\Carbon::now())
			<p>
				The last game was played on {{ $game->finished_at->toFormattedDateString() }}
			</p>
		@endif
		<form style="display: inline-block;" method="POST" action="{{ url('game/create-game') }}">
			{!! csrf_field() !!}
			<button class="btn btn-warning-outline center-block" type="submit">Create New Game</button>
		</form>
	</div>
</div>

<div class="card shadow">
	<div class="card-block">
		@if($winners->count() > 0)
		<h2>Congratulations!</h2>
		<img src="{{ asset($game->getPicture()) }}" class="img-circle profile-picture-small" style="width: 50px;" alt="">
			{!! ucfirst($game->type) !!}{{ ', ' . count($winners) . (count($winners) > 1 ? ' winners:' : 'winner:') }}
		<div class="row">
			@foreach($winners as $winner)
				<div style="display: inline-block;">
					<h4>{{ $winner['winner']->first_name }}</h4>
					<a href="{{ url($winner['winner']->getProfileUrl()) }}" class="over round">
						<img src="{{ url($winner['winner']->getPicture()) }}" class="img-circle profile-picture-small">
					</a>
				</div>
			@endforeach
		</div>
		@else
			Winner account has been deactivated...
			<img src="{{ asset('img/placeholder.jpg') }}" class="img-circle profile-picture-small">
		@endif
	</div>
</div>

<div class="card shadow scrolling-content" style="min-height: 40vh;">
	<table class="table table-large text-small text-xs-left">
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
		<tbody>

			@foreach($game->data['scores'] as $round => $value)
				<tr {!! $round < count($game->data['scores']) ? 'class="clickable-row"' : '' !!}
					data-href="{{ url('game/round/' . $round) }}">
					<td class="td-fixed"><strong>{{ $round }}</strong></td>

					@foreach(array_keys($game->getTeams()) as $team)
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
							{{ $game->getTotalKlaverjassenScores()[$team] }} +
							<span class="text-success"><b>{{ $game->getTotalKlaverjassenScores()[$team . '-roem'] }}</b></span> = &emsp;
							<b>{{ $game->getTotalKlaverjassenScores()[$team] + $game->getTotalKlaverjassenScores()[$team . '-roem'] }}</b>
						</td>
					@endforeach
				</tr>
			@endif
		</tbody>
	</table>
</div>

<div class="card shadow">
	<div class="card-block">
		<h2>Experience Points</h2>
		@if($winners->count() > 0)
			@foreach($winners as $winner)
				<div class="row">
					<div class="col-md-6 text-md-right text-sm-center">
						<strong>{{ $winner['winner']->getName() }}</strong>
					</div>
					<div class="col-md-6 text-md-left text-sm-center">
						+ <span class="text-success">50</span> xp
						<br />
						+ <span class="text-success">20</span> xp for winning
					</div>
				</div>
			@endforeach
		@else
			Winner account has been deactivated...
		@endif

		@if($losers->count() > 0)
			@foreach($losers as $loser)
				<div class="row">
					<div class="col-md-6 text-md-right text-sm-center">
						<strong>{{ $loser['loser']->getName() }}</strong>
					</div>
					<div class="col-md-6 text-md-left text-sm-center">
						+ <span class="text-success">25</span> xp
					</div>
				</div>
			@endforeach
		@else
			Loser accounts have been deactivated...
		@endif
	</div>
</div>
