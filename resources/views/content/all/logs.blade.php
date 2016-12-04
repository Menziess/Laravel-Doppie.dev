@extends('layouts.app')

@section('content')

<div class="container m-t-3">
	<h4 class="card-title">Logs</h4>
	<div class="col-md-12" style="word-wrap: break-word;">
	@foreach($lines as $line)
		{!! $line !!}<br />
	@endforeach
	</div>
</div>

@endsection
