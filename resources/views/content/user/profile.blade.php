@extends('layouts.app')

@section('content')

<div class="container">

	@if($subject && $subject->profile)

		<div class="card shadow card-block">
			<div class="row">
				<div class="col-md-4">
					<h4 class="card-title">{{ $subject->getName() }}</h4>

					<div class="row margin-bottom-20">
						<a {{ Auth::user()->is_admin ? 'href=' . url('admin/user/' . $subject->id) : '' }}>
							<img src="{{ asset($subject->getPicture()) }}" class="img-circle profile-picture-small center-block" alt="">
						</a>
					</div>

				</div>

				<div class="col-md-8 text-xs-left">
					<h4 class="card-title">Statistics</h4>
					Wins: {{ $subject->getData('wins') ?? 0 }}<br />
					Average score: {{ 'N/A' }}<br />
					Last game: {{ 'N/A' }}<br />
					XP: {{ $subject->getLevelObtainedXp() }} / {{ $subject->getLevelRequiredXp($subject->getLevel()) }}<br/>
					{{-- Total XP: {{ $subject->getXp() }}<br /> --}}
					Lvl: {{ $subject->getLevel() }}
				</div>

			</div>
		</div>


	@endif

</div>

@endsection
