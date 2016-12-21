@extends('layouts.app')

@section('content')

<div class="container">
	<div class="card shadow card-block">
		<div class="row">
			<h4>Hartenjagen</h4>
			{{ App\User::find(15)->getName() }}
			@if(isset($hartenjagen))
				<div class="col-md-6 col-centered">
					Wins:
					@foreach($hartenjagen["winners"] as $winner => $amount)
						<br />{{ $winner }} : {{ $amount }}
						<label class="img-circle profile-picture-small" style="cursor: pointer; background-image: url({{ "" }});"></label>
					@endforeach
				</div>
				<div class="col-md-6 col-centered">
					Losses:
					@foreach($hartenjagen["losers"] as $winner => $amount)
						<br />{{ $winner }} : {{ $amount }}
					@endforeach
				</div>
			@endif
		</div>
		<div class="row">
			<h4>Klaverjassen</h4>
			@if(isset($klaverjassen))
				<div class="col-md-6 col-centered">
					Wins:
					@foreach($klaverjassen["winners"] as $winner => $amount)
						<br />{{ $winner }} : {{ $amount }}
					@endforeach
				</div>
				<div class="col-md-6 col-centered">
					Losses:
					@foreach($klaverjassen["losers"] as $winner => $amount)
						<br />{{ $winner }} : {{ $amount }}
					@endforeach
				</div>
			@endif
		</div>
	</div>
</div>

@endsection
