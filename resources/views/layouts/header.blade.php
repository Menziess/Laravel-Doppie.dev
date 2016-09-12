

<div id="header" class="collapse">
	<div class="container fluid">
		<div class="row">
			<div class="col-xs-18 col-sm-6 col-md-4 col-lg-4 left">
			<a href="{{ url($subject->getProfileUrl()) }}" class="over round">
				<img id="picture" src="{{ asset($subject->getPicture()) }}" class="img-circle profile-picture-small" alt="" href="#" data-content="" rel="popover" data-placement="right" data-original-title="" data-trigger="hover">
			</a>
			</div>

			<div class="col-xs-18 col-sm-6 col-md-4 col-lg-4 left">
			<h4 class="card-title">{{ $subject->getName() }}</h4>
			<p class="card-text">
				Wins: {{ $subject->getData('wins') ?? 0 }}<br />
				Losses: {{ $subject->getData('losses') ?? 0 }}<br />
			</p>
			</div>
		</div>
	</div>
</div>

<div id="progress" class="p-t-1 div-centered-large">
	<a data-toggle="collapse" href="#header" aria-expanded="false" aria-controls="header" onClick="saveCollapseState()" style="color: black;">
	<label class="progress-label">Lvl: {{ $subject->getLevel() }}</label>
	<progress class="progress progress-success" value="{{ $subject->getCurrentXp() }}" max="{{ $subject->getXpNext() }}">
	</progress>
	</a>
</div>

@push('scripts')
<script>
	function saveCollapseState() {
		localStorage.setItem('in', $('#header').hasClass('in'));
	}
	jQuery(document).ready(function($) {
		(localStorage.getItem('in') == 'true') ? $('#header').removeClass('in') : $('#header').addClass('in');
		var is_touch_device = ("ontouchstart" in window) || window.DocumentTouch && document instanceof DocumentTouch;
		$('[data-toggle="popover"]').popover();
		$('#picture').popover({
			trigger: is_touch_device ? "dblclick" : "hover",
			delay: {
            	show: 500,
            	hide: 100
		    },
		});
	});
</script>
@endpush
