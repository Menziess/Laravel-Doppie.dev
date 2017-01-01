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
					Level: {{ $subject->getLevel() }}<br />
					XP: {{ round($subject->getLevelObtainedXp()) }} / {{ ceil($subject->getLevelRequiredXp($subject->getLevel())) }}<br/>
					@if($subject->games->last()->finished_at)
					Last game: <a href="{{ url('scores/' . $subject->games->last()->id) }}">{{ $subject->games->last()->finished_at->toFormattedDateString() }}</a><br />
					@else
					Last game: <a href="{{ url('/game') }}">Currently playing</a>
					@endif
				</div>

			</div>
		</div>


	@endif

</div>

@endsection
