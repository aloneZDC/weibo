<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
	<title>@yield('title', trans('foundation.title'))</title>
	{!! Html::style('/antvel-bower/bootstrap/dist/css/bootstrap.css') !!}
	{!! Html::style('/antvel-bower/font-awesome/css/font-awesome.min.css') !!}
	<style>
		html {
			position: relative;
			min-height: 100%;
		}
		body {
			margin-top: 60px;
			margin-bottom: 60px;
		}
	</style>
</head>
<body>
	<header>
		@include ('foundation.partials.nav')
	</header>

	<section>
		<div class="container">
			<div class="page-header">
				<h3>#@yield('sectionTitle', 'Antvel')</h3>
			</div>

			@section('content') @show
		</div>
	</section>

	{!! Html::script('/antvel-bower/jquery/dist/jquery.min.js') !!}
	{!! Html::script('/antvel-bower/bootstrap/dist/js/bootstrap.min.js') !!}
</body>
</html>
