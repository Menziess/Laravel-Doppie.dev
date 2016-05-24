<div id="users" class="card card-block">
	<div class="row">
		<div class="card-block">
			<h4 class="card-title">Owner</h4>

			@if($subject->user)
			<div class="col-md-6 col-md-offset-3">
				<div class="row margin-bottom-20">
					<a href="{{ url($subject->user->getProfileUrl()) }}" class="over round">
					<img src="{{ asset($subject->user->getPicture()) }}" class=" img-circle profile-picture-large center-block" alt="" >
					</a>
				</div>
			</div>

			@else

			This {{ $subject->getModel() }} doesn't have a owner.
			@endif

		</div>
	</div>
</div>
