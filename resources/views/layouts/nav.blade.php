
<nav class="navbar navbar-light bg-faded">
	<div class="container">

		<a class="navbar-brand" href="{{ url('/game') }}">Doppie er <span class="text-success">app</span></a>

		@if (Auth::guest())

			<div class="nav-padding pull-xs-right">
				<a href="{{ url('login') }}" class="btn btn-secondary-outline">Login</a>
			</div>

		@else

			<div class="dropdown nav-padding nav-item pull-right">
				<button class="btn btn-secondary dropdown-toggle truncate" style="max-width: 7em;" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				{{ Auth::user()->first_name }}
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">

				@if(Auth::user()->is_admin)
					<a class="dropdown-item" href="{{ url('/admin') }}">Admin</a>
					<div class="dropdown-divider"></div>
				@endif


				@if(isset($links) && count($links) > 0)
					@foreach($links as $link)
						<a class="dropdown-item" href="{{ url($link['href']) }}">{{ $link['title'] }}</a>
					@endforeach
					<div class="dropdown-divider"></div>
				@endif

				<a class="dropdown-item" href="{{ url('/user/settings') }}">Settings</a>

				<div class="dropdown-divider"></div>

				<a class="dropdown-item" href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a>

				</div>
			</div>

			<form class="form-inline pull-xs-right hidden-xs-down" method="GET" action="{{ url('/subject/') }}">
				<div class="input-group">
					<input class="searchbar form-control" type="text" placeholder="Search" name="search" value="{{ isset($input) ? $input : '' }}">
					<span class="input-group-btn">
						<button class="btn btn-success-outline" type="submit">Search</button>
					</span>
				</div>
			</form>

		@endif

	</div>
</nav>
