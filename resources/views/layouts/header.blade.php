
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
	<p class="card-text col-centered">With supporting text below as a natural lead-in to additional content.</p>
	<a href="#" class="btn btn-primary-outline">Go somewhere</a>
	</div>


	</div>
</div>
