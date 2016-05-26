@extends('layouts.app')

@section('content')

<div class="container">

	@if(isset($users))
		@include('content.user.partials.list')
	@endif

	@if(isset($projects))
		@include('content.project.partials.list')
	@endif

	@if(isset($organizations))
		@include('content.organization.partials.list')
	@endif

</div>

@endsection


@push('scripts')
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".clickable-row").click(function() {
			window.document.location = $(this).data("href");
		});
	});
</script>
@endpush
