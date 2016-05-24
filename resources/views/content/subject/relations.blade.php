@extends('layouts.app')

@section('content')

<div class="container">

	@if($subject->getModel() != 'user')
	@include('content.subject.partials.owner')
	@endif

	@include('content.user.partials.list', ['users' => $subject->users])

	@include('content.project.partials.list', ['projects' => $subject->projects])

	@include('content.organization.partials.list', ['organizations' => $subject->organizations])

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
