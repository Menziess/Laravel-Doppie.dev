@extends('layouts.app')

@section('content')

<div class="container">

	@if ($games->count() > 0)
		<div class="card-columns">

			@foreach($games as $game)
				<div class="card">
					<div class="card-header clickable-row unselectable touchable" data-href="scores/{{ $game['game']->id }}">
					<img class="card-img-top"
						style="	width: 3em;"
						src="{{ $game['game']->type == \App\Game::HARTENJAGEN ?
							asset('img/games/heart.png') :
							asset('img/games/clover.png') }}"
						alt="Game type">
						<h4  class="card-title">{{ $game['game']->type }}</h4>
					</div>
					<div class="card-block">
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
