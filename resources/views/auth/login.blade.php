@extends('layouts/master')

@section('page_class') wrapper-page @stop

@section('navigation')
	&nbsp;
@stop

@include('partial.message')

@section('content')

	<div class="content_wrapper_header">
		<h3>
			<a href="/" title="{{ trans('globals.go_back_label') }}">
		    	{{ trans('user.sign_in_your_account') }}
		    </a>
	    </h3>
    </div>

	<div class="content_wrapper">
	    <div class="row" ng-controller="LoginController">
	    	<div class="col-md-12">

	    		{!! Form::open(['url'=>'/login','name'=>'loginForm', 'class'=>'form-horizontal','role'=>"form",'method'=>"POST"]) !!}

				{{ csrf_field() }}

				<div class="form-group">
					<h6 class="black_color">{{ trans('user.email_address') }}:</h6>
					<div class="input-group">
	      				<div class="input-group-addon"><span class="fa fa-envelope-o"></span></div>
						<input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
					</div>
				</div>

				<div class="form-group">
					<h6 class="black_color">{{ trans('user.password') }}:</h6>
					<div class="input-group">
	  					<div class="input-group-addon"><span class="fa fa-lock"></span></div>
						<input type="password" class="form-control" name="password">
					</div>
				</div>

				@if (app()->environment() == 'production')
					<div class="form-group" style="height: 120px">
						<h6 class="black_color">{{ trans('user.are_you_human') }}</h6>
						{!! Recaptcha::render() !!}
					</div>
				@endif

				<div class="form-group">
					<label>
						<input ng-disabled="!havePassword" type="checkbox" name="remember"> {{ trans('user.remember_me') }}
						&nbsp;|&nbsp;
						<a style="100%" href="{{ url('/password/reset') }}">
						<span class="fa fa-paper-plane-o"></span>&nbsp;
						{{ trans('user.forgot_your_password') }}?
					</a>
					</label>
				</div>

				<div class="form-group">
					<hr>

					<button type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-log-in"></span>&nbsp;
						{{ trans('user.sign_in_my_account') }}
					</button>

					<a href="{{ route('register') }}" class="btn btn-default">
						<span class="glyphicon glyphicon-ok-circle"></span>&nbsp;
						{{ trans('user.create_my_account') }}
					</a>

				</div>

				{!! Form::close() !!}

	    	</div> {{-- col --}}

	    </div> {{-- row --}}

	</div> {{-- panel --}}
@endsection

@section('footer')
	&nbsp;
@endsection
