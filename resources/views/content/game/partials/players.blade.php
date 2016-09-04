
<div class="row">
	<h4 class="card-title">New Game</h4>

	<div class="col-md-6 col-md-offset-3 col-centered">

		<div id="modal-upload" class="modal fade">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
						<h4 class="modal-title">Add Players</h4>
					</div>

					@foreach($users as $user)
						<form class="form-horizontal" method="POST" action="{{ url('game/add-user/' . $user->id) }}">
							{!! csrf_field() !!}
							{{ method_field('PUT') }}
							<input type="image" name="submit" src="{{ $user->getPicture() }}" class="img-circle profile-picture-small" style="width: 50px;" border="0" alt="Submit">
						</form>
					@endforeach
				</div>
			</div>
		</div>

		<hr/>

		<button class="btn btn-primary-outline center-block" type="button" data-toggle="modal" data-target="#modal-upload">Add Players</button>

		<hr/>

		@if($game->users->count() >= 3)
			<form id="form-profile" class="form-horizontal" method="POST" action="{{ url('game/start-game') }}">
				{!! csrf_field() !!}
				{{ method_field('PUT') }}
				<button class="btn btn-warning-outline center-block" type="submit">Start</a>
			</form>
		@endif
	</div>
</div>
