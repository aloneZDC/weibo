@extends('layouts/master', [
	'panel' => [
        'left'   => ['width' => '2', 'class' => 'user-panel'],
        'center' => ['width' => '10'],
    ]
])
@section('page_class')user-profile @stop

@section('navigation') @parent @stop

@include('partial.message')

@section('content')
	@parent
	@section('panel_left_content')
		@include('users.partials.menu_dashboard')
	@stop

	@section('center_content')

		<div class="page-header">
			<h5>{{ trans('user.user_prifle_info') }}</h5>
		</div>

		<form action="{{ route('user.update', ['user' => auth()->user()]) }}" enctype="multipart/form-data" method="POST">
			@include ('users.partials.profile_inputs')
		</form>

		<div class="page-header">
			<h5>{{ trans('user.social_information') }}</h5>
		</div>

		<form action="{{ route('user.update', ['user' => auth()->user()]) }}" method="POST">
			@include ('users.partials.social_inputs')
		</form>

		<div class="page-header">
			<h5>{{ trans('user.user_account_settings') }}</h5>
		</div>

		<form action="{{ route('user.update', ['user' => auth()->user()]) }}" method="POST">
			@include ('users.partials.settings_inputs')
		</form>

	@stop

@endsection
