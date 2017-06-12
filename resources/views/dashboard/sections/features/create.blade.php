@extends('dashboard.layouts.panel')

@section('sectionTitle', trans('features.create'))

@section('content')

	<div class="row">

		<div class="col-lg-6">

			<form action="{{ route('features.store') }}" method="POST" role="form">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="name">{{ trans('globals.name') }}:</label>
					<input type="text" class="form-control" name="name" value="{{ old('name') }}">
				</div>
				<div class="form-group">
					<label for="name">{{ trans('features.input_type') }}:</label>
					<select name="input_type" class="form-control">
						<option value="text" @if (old('input_type') == 'text') selected="selected" @endif >{{ trans('globals.text') }}</option>
						<option value="select" @if (old('input_type') == 'select') selected="selected" @endif >{{ trans('globals.select') }}</option>
					</select>
				</div>

				@foreach ($allowed_rules as $rule)
					@if (view()->exists($view = 'dashboard.sections.features.validations.' . $rule))
						@include ($view, [
							'validation_rules' => $validation_rules,
							'rule' => $rule
						])
					@endif
				@endforeach

				<div class="form-group">
					<label for="name">{{ trans('features.help_message') }}:</label>
					<input type="text" class="form-control" name="help_message" value="{{ old('help_message') }}">
				</div>
				<div class="form-group">
					<label for="filterable">filterable:</label>
					<select name="filterable" class="form-control">
						<option value="1" @if (old('filterable') == '1') selected="selected" @endif >{{ trans('globals.yes') }}</option>
						<option value="0" @if (old('filterable') == '0') selected="selected" @endif >{{ trans('globals.no') }}</option>
					</select>
				</div>
				<div class="form-group">
					<label for="name">{{ trans('globals.status') }}:</label>
					<select name="status" class="form-control">
						<option value="1" @if (old('status') == '1') selected="selected" @endif >{{ trans('globals.active') }}</option>
						<option value="0" @if (old('status') == '0') selected="selected" @endif >{{ trans('globals.inactive') }}</option>
					</select>
				</div>
				<div class="form-group">
					<hr>
					<a href="{{ route('features.index') }}" class="btn btn-danger">
						<i class="glyphicon glyphicon-remove"></i>&nbsp;
						{{ trans('globals.close_label') }}
					</a>
					<button type="submit" class="btn btn-success">
						<i class="glyphicon glyphicon-send"></i>&nbsp;
						{{ trans('globals.submit') }}
					</button>
				</div>
			</form>

		</div>
	</div>

@endsection
