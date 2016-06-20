@extends('layouts.app')

@section('content')

<div class="container">
	<div class="gridster">

	    <ul class="gridster-pane">
	        <div class="card" data-row="1" data-col="1" data-sizex="1" data-sizey="1">
				<div class="card-header bg-success" data-toggle="collapse" aria-expanded="false" aria-controls="header">
					<h4 class="card-title unselectable" data-href="{{ url('http://www.google.com') }}">A4</h4>
				</div>
				<div class="card-block">
	        	<button class="btn btn-secondary">Edit</button>
	        	</div>
	        </div>

	        <div class="bg-warning" data-row="2" data-col="1" data-sizex="1" data-sizey="1"></div>
	        <div class="bg-warning" data-row="3" data-col="1" data-sizex="1" data-sizey="1"></div>

	        <div class="bg-warning" data-row="1" data-col="2" data-sizex="2" data-sizey="1"></div>
	        <div class="bg-warning" data-row="2" data-col="2" data-sizex="2" data-sizey="2"></div>

	        <div class="bg-warning" data-row="1" data-col="4" data-sizex="1" data-sizey="1"></div>
	        <div class="bg-warning" data-row="3" data-col="4" data-sizex="1" data-sizey="1"></div>
	        <div class="bg-warning" data-row="2" data-col="4" data-sizex="2" data-sizey="1"></div>

	        <div class="bg-warning" data-row="1" data-col="5" data-sizex="1" data-sizey="1"></div>
	        <div class="bg-warning" data-row="3" data-col="5" data-sizex="1" data-sizey="1"></div>

	        <div class="bg-warning" data-row="1" data-col="6" data-sizex="1" data-sizey="1"></div>
	        <div class="bg-warning" data-row="2" data-col="6" data-sizex="1" data-sizey="2"></div>
	    </ul>

	</div>
</div>

@endsection

@push('scripts')
	<link rel="stylesheet" href="https://cdn.rawgit.com/ducksboard/gridster.js/master/dist/jquery.gridster.min.css"></link>
	<script type="text/javascript" src="https://cdn.rawgit.com/ducksboard/gridster.js/master/dist/jquery.gridster.min.js"></script>
	<script>
		$(function(){
			$(".clickable-row").click(function() {
				window.document.location = $(this).data("href");
			});

		    var gridster = $(".gridster ul").gridster({
		    	widget_selector: "div",
		        widget_margins: [2, 2],
		        widget_base_dimensions: [110, 140],
		    });

		    console.log(gridster);

		    var gridster = $(".gridster ul").gridster().data('gridster');

			gridster.add_widget('<div class="new">The HTML of the widget...</div>', 2, 1);
		});
	</script>
@endpush
