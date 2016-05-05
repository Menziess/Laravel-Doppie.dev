@extends('layouts.app')

@section('content')


	@if($organization)




	@endif



	@if(Auth::user()->is_admin)

		@include('content.admin.partials.organizationpanel')

	@else



	@endif


@endsection
