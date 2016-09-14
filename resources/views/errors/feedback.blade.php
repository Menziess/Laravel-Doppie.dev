<div class="p-t-1">

	@if (count($errors) > 0)
	    <div class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
	    </div>
	@endif
	@if (Session::has('message'))
		<div class="alert alert-success" role="alert">
			{{ Session::get('message') }}
		</div>
	@endif

</div>
