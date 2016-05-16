@extends('layouts.app')

@section('content')

<div class="container">

	@if(Auth::user()->is_admin)

		@include('content.admin.partials.organizationpanel')

	@else

	@endif

</div>

@endsection
