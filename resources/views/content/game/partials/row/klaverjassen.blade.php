@extends('layouts.app')

@section('content')

<div class="container">

	@if($game)

		<form id="score-form" class="form-horizontal" method="POST" action="{{ url('game/round/' . $nr) }}">
		{!! csrf_field() !!}
		{{ method_field('PUT') }}
			<div class="card shadow m-t-3">
				<div class="card-block">
					<h2 class="card-title">Edit Row {{ $nr }}</h2>
				</div>
				<div class="scrolling-content">
					<table class="table table-hover table-large text-small text-xs-left">
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
							<tr>
								<td>{{ $nr }}</td>
								@foreach(array_keys($game->getTeams()) as $team)
									<td>
										<div class="form-inline">
											<input name="{{ $team }}" class="form-control" style="width: 100px;" min="0" max="162" type="number" inputmode="numeric" pattern="[0-9]*"
											placeholder="0" autofocus="autofocus" value={{ $game->data['scores'][$nr][$team] }}>
											<input name="{{ $team }}-roem" class="form-control" style="width: 100px;" min="0" step="10" type="number" inputmode="numeric" pattern="[0-9]*"
											placeholder="Roem" autofocus="autofocus" value={{ $game->data['scores'][$nr][$team . '-roem'] }}>
										</div>
									</td>
								@endforeach
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			@if(Auth::user() == $game->user || Auth::user()->is_admin)
				<div class="container">
					<div class="row">
						@include('errors.feedback')
						<button class="btn btn-primary-outline" type="submit">Save</button>
						<a href="{{ url('game') }}" class="btn btn-secondary" role="button">Back</a>
					</div>
				</div>
			@endif
		</form>
	@else
		The requested game doesn't exist...
	@endif

</div>

@endsection

@push('scripts')
<script type="text/javascript">
	jQuery(document).ready(function($) {

		var wij = $("[name='Wij']");
		var zij = $("[name='Zij']");
		wij.bind('keyup change', function(e) {
			if (this.value <= 162) {
				zij.val(162 - this.value);
			}
		});
		zij.bind('keyup change', function(e) {
			if (this.value <= 162) {
				wij.val(162 - this.value);
			}
		});

		$("#score-form").submit(function() {
			var message = "The scores don't add up to 162.";
			var submit = (+wij.val() + +zij.val() == 162);

			content = (
				'<div class="alert alert-warning" role="alert">' +
				message	+
				'</div>'
			);

			if (!submit) {
				document.getElementById("feedback").innerHTML = content;
			} else {
				document.getElementById("feedback").innerHTML = null;
			}
			return submit;
		});
	});
</script>
@endpush
