<div class="card shadow m-t-3">
	<div class="card-block">
		<h2 class="card-title">New Game</h2>
		<form style="display: inline-block;" method="POST" action="{{ url('game/set-type') }}">
			{!! csrf_field() !!}
			{{ method_field('PUT') }}
			<input name="type" value="Hartenjagen" hidden="hidden">
			<button class="btn btn-primary-outline center-block" type="submit">Hartenjagen</button>
		</form>
		<form style="display: inline-block;" method="POST" action="{{ url('game/set-type') }}">
			{!! csrf_field() !!}
			{{ method_field('PUT') }}
			<input name="type" value="Klaverjassen" hidden="hidden">
			<button class="btn btn-primary-outline center-block" type="submit">Klaverjassen</button>
		</form>
	</div>
</div>
