

<div id="header" class="collapse {{ isset($in) ? 'in' : '' }}">
	<div class="container fluid">
		<div class="row row-centered">

			<div class="col-xs-18 col-sm-6 col-md-4 col-lg-4 col-centered">
			<a href="{{ url('/user/profile') }}" class="over round">
				<img src="{{ asset(Auth::user()->getPicture()) }}" class="img-circle profile-picture-small" alt="" >
			</a>
			</div>

			<div class="col-xs-18 col-sm-6 col-md-4 col-lg-4 col-centered">
			<h4 class="card-title">{{ Auth::user()->getName() }}</h4>
			<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
			</div>

			<div class="col-xs-18 col-sm-6 col-md-4 col-lg-4 col-centered">
				@if(isset($links))
				<div class="btn-group-vertical padding-top">
					@foreach($links as $link)
						<a class="btn btn-primary-outline" href="{{ url($link['href']) }}">{{ $link['title'] }}</a> {!! $link['text'] !!}
					@endforeach
				</div>
				@else
			 	@endif
			</div>

		</div>
	</div>
</div>

    <a id="popover" class="btn" href="#" data-content="Popover with data-trigger" rel="popover" data-placement="bottom" data-original-title="Title" data-trigger="hover">Test</a>
<div id="progress" class="padding-top div-centered-large">
	<a data-toggle="collapse" href="#header" aria-expanded="false" aria-controls="header">
	<progress class="progress progress-success" value="25" max="100"></progress>
	</a>
</div>


@push('scripts')
<script>
	jQuery(document).ready(function($) {
		$('#popover').popover();
		$('#popover').popover({ trigger: "hover" });
	});
</script>
@endpush
