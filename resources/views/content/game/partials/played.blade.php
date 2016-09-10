
<div class="row">

	<div class="card">
		<div class="card-block">
			<h2>Congratulations!</h2>
			<div class="row">
				@if($winners->count() > 0)
					@foreach($winners as $winner)
						<div style="display: inline-block;">
							<h4>{{ $winner['winner']->first_name }}</h4>
							<a href="{{ url($winner['winner']->getProfileUrl()) }}" class="over round">
								<img src="{{ url($winner['winner']->getPicture()) }}" class="img-circle profile-picture-small">
							</a>
						</div>
					@endforeach
				@else
					Winner account has been deactivated...
					<img src="{{ asset('img/placeholder.jpg') }}" class="img-circle profile-picture-small">
				@endif
			</div>
		</div>
	</div>

	<table class="table table-large text-small text-xs-left">
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

	<div class="card">
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
							+ <span class="text-success">10</span> xp for winning
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
							+ <span class="text-success">{{ 50 - $loser['points']}}</span> xp
						</div>
					</div>
				@endforeach
			@else
				Loser accounts have been deactivated...
			@endif
		</div>
	</div>

</div>
