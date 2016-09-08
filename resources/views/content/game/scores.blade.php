@extends('layouts.app')

@section('content')

<div class="container">

	<div class="card">
		<div class="card-block">
			<h4 class="card-title unselectable">Scores</h4>
			<p class="card-body">
			Here you will previously played games:
			</p>
		</div>
	</div>

	<div class="card-columns">

		@foreach($games as $game)
			<div class="card">
				<img class="card-img-top" src="{{ '' }}" alt="Card image cap">
				<div class="card-block">
					<h4 data-href="scores/{{ $game->id }}" class="card-title unselectable clickable-row">Hartenjagen</h4>
					<p class="card-text">

					</p>
					<p class="card-text"><small class="text-muted">Game played {{ Carbon\Carbon::now()->diffForHumans($game->finished_at, true) }} ago</small></p>
				</div>
			</div>
		@endforeach

	</div>
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
