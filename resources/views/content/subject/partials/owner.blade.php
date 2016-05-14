@if($subject->user)
<div id="users" class="card card-block">
	<div class="row">
		<div class="card-block">
			<h4 class="card-title">Owner</h4>
			<div class="col-md-6 col-md-offset-3 col-centered">

				<div class="row margin-bottom-20">
					<a href="{{ url($subject->user->getProfileUrl()) }}" class="over round">
					<img src="{{ asset($subject->user->getPicture()) }}" class=" img-circle profile-picture-large center-block" alt="" >
					</a>
				</div>

			</div>
		</div>
	</div>
</div>
@else
This organization doesn't have a owner.
@endif
