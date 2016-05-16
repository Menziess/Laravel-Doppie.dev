@extends('layouts.app')

@section('content')

<div class="container">

	@include('content.subject.partials.owner')

	@include('content.subject.partials.users')

	@include('content.subject.partials.organizations')

</div>

@push('scripts')
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".clickable-row").click(function() {
			window.document.location = $(this).data("href");
		});
	});
</script>
@endpush

@endsection
