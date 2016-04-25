
<div class="hero-unit">
	<div class="container fluid">
		<div class="row row-centered">

		<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-centered">
		<a href="{{ url('/user/profile') }}" class="over round">
			<img src="{{ asset('img/profile.jpg') }}" class="img-circle width-100 profile-picture" alt="" >
		</a>

		</div>
		<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-centered">
		<h4 class="card-title">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</h4>
		<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
		</div>

		<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-centered">
		<p class="card-text col-centered">With supporting text below as a natural lead-in to additional content.</p>
		<a href="#" class="btn btn-primary">Go somewhere</a>
		</div>

		</div>
	</div>
</div>
