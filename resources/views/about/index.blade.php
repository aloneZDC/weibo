@extends('layouts.master', [
	'panel' => ['center' => ['width' => '12']]
])

@section('title')@parent - About @stop

@section('content')
	@parent

	@section('center_content')

		<div class="page-header">
            <h5>{{ trans('company.' . $tab) }}</h5>
        </div>

        <div class="row">
        	<div class="col-md-12">

				<ul class="nav nav-tabs">
					<li class="{{ $tab == 'about' ? 'active' : '' }}">
						<a href="{{ route('about') }}">{{ trans('company.about') }}</a>
					</li>

					<li class="{{ $tab == 'refunds' ? 'active' : '' }}">
						<a href="{{ route('about', ['section' => 'refunds']) }}">{{ trans('company.refunds') }}</a>
					</li>

					<li class="{{ $tab == 'terms' ? 'active' : '' }}">
						<a href="{{ route('about', ['section' => 'terms']) }}">{{ trans('company.terms') }}</a>
					</li>
				</ul>

				<div id="my-tab-content" class="tab-content">
					<div class="tab-pane {{ $tab == 'about' ? 'active' : '' }}">
						<div class="well">{{ $company['about'] }}</div>
					</div>
					<div class="tab-pane {{ $tab == 'refunds' ? 'active' : '' }}">
						<div class="well">{{ $company['refunds'] }}</div>
					</div>
					<div class="tab-pane {{ $tab == 'terms' ? 'active' : '' }}">
						<div class="well">{{ $company['terms'] }}</div>
					</div>
				</div>

        	</div>
        </div>

	@endsection

@endsection
