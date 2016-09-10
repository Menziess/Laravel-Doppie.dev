@extends('layouts.app')

@section('content')

<div class="container">

	@if ($games->count() > 0)
		<div class="card-columns">

			@foreach($games as $game)
				<div class="card">
					<img class="card-img-top"
						style="	width: 3em; margin-top: 1em;"
						src="{{ asset('img/games/heart.png') }}"
						alt="Game type">
					<div class="card-block">
						<h4 data-href="scores/{{ $game['game']->id }}" class="card-title unselectable clickable-row">{{ $game['game']->type }}</h4>
						<p class="card-text">
							<p><strong>Winners:</strong></p>
							@if($game['winners']->count() > 0)
								@foreach($game['winners'] as $winner)
									{{ $winner->getName() }}<br/>
								@endforeach
							@else
								Winner account has been deactivated...
							@endif
						</p>
						<p class="card-text"><small class="text-muted">Game played {{ Carbon\Carbon::now()->diffForHumans($game['game']->finished_at, true) }} ago</small></p>
					</div>
				</div>
			@endforeach

		</div>
	@else
		No games have been played recently...
	@endif

</div>

@endsection

@push('scripts')
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".clickable-row").click(function() {
			window.document.location = $(this).data("href");
		});
	});
</script>
@endpush
