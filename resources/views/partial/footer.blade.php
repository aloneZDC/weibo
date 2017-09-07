<div class="container">
	<div class="row">
		<div class="col-xs-4 col-sm-4 col-md-4 menu">
			<h3>{{ trans('globals.company_label') }}</h3>
			<ul>
				<li><a href="{{ route('about') }}">{{ trans('company.about') }}</a></li>
				<li><a href="{{ route('about', ['section' => 'refunds']) }}">{{ trans('company.refunds') }}</a></li>
				<li><a href="{{ route('about', ['section' => 'terms']) }}">{{ trans('company.terms') }}</a></li>
			</ul>
		</div>

		<div class="col-xs-4 col-sm-4 col-md-4 menu">
			<h3>{{ trans('globals.social_label') }}</h3>
			<ul>
				<li><a href="https://www.facebook.com/{{ $company['facebook'] }}" target="_blank">{{ trans('globals.facebook_label') }}</a></li>
				<li><a href="https://twitter.com/{{ $company['twitter'] }}" target="_blank">{{ trans('globals.twitter_label') }}</a></li>
			</ul>
		</div>

		<div class="col-xs-4 col-sm-4 col-md-4 newsletter" ng-controller = "NewslettersCtrl">
			@if (auth()->check())
				<p>{{ trans('globals.reach_us_msg') }}</p>
				<p><strong><a href="{{ route('contact') }}"><span class="glyphicon glyphicon-envelope"></span>&nbsp;{{ trans('globals.send_a_email_label') }}</a></strong></p>
			@else
				<div class="signup clearfix">
					<p>{{ trans('user.newsletter_sign_up') }}</p>
					<form>
						<input type="text" ng-model = "newsEmail"  class = "form-control input-sm" placeholder = "{{ trans('user.your_email_address_label') }}">
						<input type="button" ng-click = "save()" value = "{{ trans('user.sign_up_label') }}">
					</form>
				</div>
			@endif
		</div>

	</div>

	<div class="row credits">
		<div class="col-md-12">
			{{ trans('globals.power_by_label') }}&nbsp;<a href="http://antvel.com">{{ trans('globals.antvel_eCommerce') }}</a>
		</div>
	</div>

</div>

@section('scripts')
    @parent
        <script>
            (function(app){
	                app.controller('NewslettersCtrl', function($scope, $window, notify)
					{
					  	$scope.newsEmail = '';
					  	$scope.save = function()
					  	{
					  		if ($scope.newsEmail.trim() != '') {
					  			$window.location.href = "{{ route ('register') }}?email=" + $scope.newsEmail;
					  		} else {
					  			notify({ duration:5000, messageTemplate: '<strong>{{ trans('globals.validation_error_label') }}</strong><br><br><p>{{ trans('globals.newsletter_email_error') }}</p>', classes: 'alert alert-danger' });
					  		}
					  	};
					});
            })(angular.module("AntVel"));
        </script>
    @stop
