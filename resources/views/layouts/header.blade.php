

<div id="header" class="collapse">
	<div class="container fluid">
		<div class="row row-centered">

			<div class="col-xs-18 col-sm-6 col-md-4 col-lg-4 col-centered">
			<a href="{{ url($subject->getProfileUrl()) }}" class="over round">
				<img id="picture" src="{{ asset($subject->getPicture()) }}" class="img-circle profile-picture-small" alt="" href="#" data-content="" rel="popover" data-placement="right" data-original-title="" data-trigger="hover">
			</a>
			</div>

			<div class="col-xs-18 col-sm-6 col-md-4 col-lg-4 col-centered">
			<h4 class="card-title">{{ $subject->getName() }}</h4>
			<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
			</div>

			<div class="col-xs-18 col-sm-6 col-md-4 col-lg-4 col-centered">
			</div>

		</div>
	</div>
</div>

<div id="progress" class="padding-top div-centered-large">
	<a data-toggle="collapse" href="#header" aria-expanded="false" aria-controls="header" onClick="saveCollapseState()">
	<progress class="progress progress-success" value="{{ $subject->getXp() }}" max="100"></progress>
	</a>
</div>

@push('scripts')
<script>
	function saveCollapseState() {
		localStorage.setItem('in', $('#header').hasClass('in'));
		console.log('set state: ' + localStorage.getItem('in'));
	}
	jQuery(document).ready(function($) {
		var is_touch_device = ("ontouchstart" in window) || window.DocumentTouch && document instanceof DocumentTouch;
		$('[data-toggle="popover"]').popover();
		$('#picture').popover({
			trigger: is_touch_device ? "dblclick" : "hover",
			delay: {
            	show: 500,
            	hide: 100
		    },
		});
		console.log('true == ' + localStorage.getItem('in') + ' is ' + localStorage.getItem('in') == true);
		localStorage.getItem('in') ? $('#header').addClass('in') : $('#header').removeClass('in');
	});
</script>
@endpush
