<div class="col-md-6 col-md-offset-3 col-centered">

	<div id="modal-upload" class="modal fade">
		<div class="modal-dialog" role="document">
			<form class="form-horizontal" method="POST" action="{{ url('game/add-users') }}">
			{!! csrf_field() !!}
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
						<h4 class="modal-title">Set Players</h4>
					</div>

					<div style="padding: 3px;" class="unselectable">
						@foreach($users as $user)
							<i style="position: absolute; left: 10vw; margin-top: 1em;">{{ $user->first_name }}</i>
							<input {{ $game->users->contains($user) ? 'checked="checked"' : '' }} id="{{ $user->id }}" name="{{ $user->id }}" type="checkbox" value="{{ @Session::get('time-added')[$user->id] ?? null}}"/>
							<label class="img-circle profile-picture-small" style="cursor: pointer; background-image: url({{ url($user->getPicture()) }});" for="{{ $user->id }}"></label>
							<br />
						@endforeach
					</div>
					<div class="modal-footer">
						<button class="btn btn-success-outline center-block" type="submit">Set</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	@if($game->users->count() > 0)
		<div class="text-xs-left" style="margin-left: 1em;">
			@foreach($game->users as $i => $user)
				{{ ++$i }}
				<img src="{{ $user->getPicture() }}" class="img-circle profile-picture-small" style="width: 50px;">
				{{ $user->getName() }} {!! $i == 1 ? '<i class="fa fa-random text-primary" aria-hidden="true" title="Shuffle"></i>' : null !!}
				<br/>
			@endforeach
		</div>
	@else
		<p>
			Start with the <span class="text-primary">shuffling <i class="fa fa-random text-primary" aria-hidden="true" title="Shuffle"></i></span>
			player, adding players clockwise.
		</p>
	@endif

	<hr/>

	<button class="btn btn-primary-outline center-block" type="button" data-toggle="modal" data-target="#modal-upload">Set Players</button>

	<hr/>

	@if($game->users->count() >= 3)
		<form id="form-profile" style="display: inline-block;" method="POST" action="{{ url('game/start-game') }}">
			{!! csrf_field() !!}
			{{ method_field('PUT') }}
			<button class="btn btn-success-outline center-block" type="submit">Start</button>
		</form>
	@endif

	<form style="display: inline-block;" method="POST" action="{{ url('game/reset-game') }}">
		{!! csrf_field() !!}
		{{ method_field('PUT') }}
		<button class="btn btn-warning-outline center-block" type="submit">Back</button>
	</form>

</div>

@push('scripts')
	<script type="text/javascript">
		jQuery(function(){
		    var max = 7;
		    var checkboxes = $('input[type="checkbox"]');

		    checkboxes.change(function(i){
		    	i.currentTarget.value = $.now();
		        var current = checkboxes.filter(':checked').length;
		        checkboxes.filter(':not(:checked)').prop('disabled', current >= max);
		    });
		});
	</script>
@endpush
