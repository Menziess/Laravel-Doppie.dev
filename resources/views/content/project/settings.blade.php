@extends('layouts.app')

@section('content')

<div class="container">

	@if(Auth::user()->is_admin)

		@include('content.subject.partials.permissions')

	@elseif(true)

		@include('content.subject.partials.delete')

	@endif

</div>

@endsection
