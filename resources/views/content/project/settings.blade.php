@extends('layouts.app')

@section('content')


	@if($project)




	@endif



	@if(Auth::user()->is_admin)

		@include('content.admin.partials.projectpanel')

	@else



	@endif


@endsection
