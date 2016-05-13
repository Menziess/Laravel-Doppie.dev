
<nav class="navbar navbar-light bg-faded">
	<div class="container fluid">

		<a class="navbar-brand" href="{{ url('/home') }}">Laravel</a>

		@if (Auth::guest())

			<div class="padding pull-xs-right">
				<a href="{{ url('login') }}" class="btn btn-secondary-outline">Login</a>
			</div>

		@else

			<div class="dropdown padding nav-item pull-right">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				{{ Auth::user()->first_name }}
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">

				@if(Auth::user()->is_admin)
					<a class="dropdown-item" href="{{ url('/admin') }}">Admin</a>
				@endif

				<a class="dropdown-item" href="{{ url('/user/your-profile') }}">Profile</a>
				<a class="dropdown-item" href="{{ url('/user/your-settings') }}">Settings</a>
				<a class="dropdown-item" href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
				</div>
			</div>

			<form class="form-inline pull-xs-right hidden-xs-down" method="GET" action="{{ Auth::user()->is_admin ? url('/admin/') : url('/subject/') }}">
			<input class="form-control" type="text" placeholder="Search" name="search" value="{{ isset($input) ? $input : '' }}">
			<button class="btn btn-success-outline" type="submit">Search</button>
			</form>
		@endif



	</div>

</nav>
