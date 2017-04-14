@if ($errors->any())
	<div class="alert alert-danger" role="alert">
		<strong>
			<i class="glyphicon glyphicon-warning-sign"></i>&nbsp;
			{{ trans('globals.error_label') }}!
		</strong>
		<ul>
			@foreach ($errors->all() as $message)
				<li>{{ $message }}</li>
			@endforeach
		</ul>
	</div>
@endif

@if (session('status'))
	<div class="alert alert-success" role="alert">
		<strong>
			<i class="glyphicon glyphicon-ok"></i>&nbsp;
			{{ trans('globals.success_label') }}!
		</strong>
		{{ session('status') }}
	</div>
@endif
