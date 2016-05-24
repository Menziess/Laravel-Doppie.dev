@extends('layouts.app')

@section('content')

<div class="container">

	@include('content.user.partials.list')

	@include('content.project.partials.list')

	@include('content.organization.partials.list')

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
