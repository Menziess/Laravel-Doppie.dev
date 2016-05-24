@extends('layouts.app')

@section('content')

<div class="container">

	@if($subject && $subject->profile)

		@include('content.user.partials.picture')

		@include('content.user.partials.profile')

		@include('content.user.partials.password')

	@endif



	@if(Auth::user()->is_admin && Auth::user()->getKey() != $subject->getKey())

		@include('content.subject.partials.permissions')

	@elseif(true)

		@include('content.subject.partials.delete')

	@endif

</div>

@endsection
