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
						Beware <b>{{ Auth::user()->first_name }}</b>,<br/>
						your action will be registered and charged against you in case of game manipulation.
						@if($game->started_at->addMinutes(80) > Carbon\Carbon::now())
						<br/><br/>
						Time untill delete button will be publicly available in:<br/>
						<b><span class="text-danger">{{ $game->started_at->addMinutes(80)->diffInMinutes(Carbon\Carbon::now()) }}</span></b> minutes.
						@endif
						@if(Auth::user() == $game->user || Auth::user()->is_admin || $game->started_at->addMinutes(80) < Carbon\Carbon::now())
						<br/><br/>
						Button available in <b><span id="timer" class="text-danger">5</span></b> seconds.
						@endif
					</p>
				</div>
				<div class="modal-footer">
					@if(Auth::user()->is_admin && $game->trashed())
						<form class="form-horizontal" method="POST" action="{{ url('game/activate-game/' . $game->id) }}">
							{!! csrf_field() !!}
							{{ method_field('PUT') }}
							<button class="btn btn-success" type="submit">Activate</button>
						</form>
					@endif
					<br />
					@if(Auth::user() == $game->user || Auth::user()->is_admin || $game->started_at->addMinutes(80) < Carbon\Carbon::now())
					<form class="form-horizontal" method="POST" action="{{ url('game/delete-game') }}">
						{!! csrf_field() !!}
						{{ method_field('DELETE') }}
						<button id="delete" class="btn btn-danger" type="submit">Delete</button>
					</form>
					@else
						<button class="btn btn-danger disabled">Delete</button>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

@if(Auth::user() == $game->user || Auth::user()->is_admin || $game->started_at->addMinutes(80) < Carbon\Carbon::now())
	@push('scripts')
	<script type="text/javascript">
		$(function() {
			var counter = 5;
			var interval = null;
			$("#delete").hide();
			$("#modal-delete").on("shown.bs.modal", function() {
				interval = setInterval(function() {
				    counter--;
				    $("#timer").text(counter);
				    if (counter == 0) {
				        $("#delete").show();
				        clearInterval(interval);
				    }
				}, 1000);
			});
			$("#modal-delete").on("hidden.bs.modal", function() {
				counter = 5;
				clearInterval(interval);
				$("#timer").text(counter);
				$("#delete").hide();
			});
		});
	</script>
	@endpush
@endif
