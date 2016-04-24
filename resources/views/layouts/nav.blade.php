<nav class="navbar navbar-light bg-faded">

<div class="container fluid">
	<a class="navbar-brand" href="{{ url('/') }}">Laravel</a>

	<ul class="nav navbar-nav">
	@if (Auth::guest())
		<li class="nav-item">
			<a class="nav-link" href="{{ url('/login') }}">Login</a>
		</li>
		<li class="nav-item">
			<a class="nav-link text-success" href="{{ url('/register') }}">Register</a>
		</li>
	@else
		<li class="nav-item active">
			<a class="nav-link" href="{{ url('/home') }}">Home <span class="sr-only">(current)</span></a>
		</li>
		<li class="nav-item pull-xs-right">
		<div class="dropdown">
			<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			{{ Auth::user()->first_name }}
			</button>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
			@if(Auth::user()->is_admin)
				<a class="dropdown-item" href="{{ url('/admin') }}">Admin</a>
			@endif
			<a class="dropdown-item" href="{{ url('/user/settings') }}">Settings</a>
			<a class="dropdown-item" href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
			</div>
		</div>
		</li>

	@endif

	<form class="form-inline pull-xs-right hidden-xs-down">
	<input class="form-control" type="text" placeholder="Search">
	<button class="btn btn-success-outline" type="submit">Search</button>
	</form>
	</ul>
</div>

</nav>
