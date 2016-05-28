@extends('layouts.app')

@section('content')

	<div class="container">

		Network planning.

	</div>
	<link rel="stylesheet" href="https://cdn.rawgit.com/ducksboard/gridster.js/master/dist/jquery.gridster.min.css"></link>

	<div class="gridster ready">
    <ul>
        <li data-row="1" data-col="1" data-sizex="1" data-sizey="1">one</li>
        <li data-row="2" data-col="1" data-sizex="1" data-sizey="1">two</li>
        <li data-row="3" data-col="1" data-sizex="1" data-sizey="1"></li>

        <li data-row="1" data-col="2" data-sizex="2" data-sizey="1"></li>
        <li data-row="2" data-col="2" data-sizex="2" data-sizey="2"></li>

        <li data-row="1" data-col="4" data-sizex="1" data-sizey="1"></li>
        <li data-row="2" data-col="4" data-sizex="2" data-sizey="1"></li>
        <li data-row="3" data-col="4" data-sizex="1" data-sizey="1"></li>

        <li data-row="1" data-col="5" data-sizex="1" data-sizey="1"></li>
        <li data-row="3" data-col="5" data-sizex="1" data-sizey="1"></li>

        <li data-row="1" data-col="6" data-sizex="1" data-sizey="1"></li>
        <li data-row="2" data-col="6" data-sizex="1" data-sizey="2"></li>
    </ul>
</div>

@endsection

@push('scripts')
	<script type="text/javascript" src="https://cdn.rawgit.com/ducksboard/gridster.js/master/dist/jquery.gridster.min.js"></script>
	<script>
	$(function(){ //DOM Ready

    $(".gridster ul").gridster({
        widget_margins: [10, 10],
        widget_base_dimensions: [140, 140]
    });

});
	</script>
@endpush
