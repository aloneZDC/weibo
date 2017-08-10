@extends('dashboard.layouts.panel')

@section('sectionTitle', trans('features.edit'))

@section('content')

	<div class="row">

		<div class="col-lg-6">

			<form action="{{ route('features.update', ['id' => $feature->id ]) }}" method="POST" role="form">
				{{ csrf_field() }}
				{{ method_field('PATCH') }}
				<div class="form-group">
					<label for="name">{{ trans('globals.name') }}:</label>
					<input type="text" class="form-control" name="name" value="{{ $feature->name }}">
				</div>
				<div class="form-group">
					<label for="name">{{ trans('features.input_type') }}:</label>
					<select name="input_type" class="form-control">
						<option value="text" @if (old('input_type') == 'text' || $feature->input_type == 'text') selected="selected" @endif >{{ trans('globals.text') }}</option>
						<option value="select" @if (old('input_type') == 'select' || $feature->input_type == 'select') selected="selected" @endif >{{ trans('globals.select') }}</option>
					</select>
				</div>

				@foreach ($allowed_rules as $rule)
					@if (view()->exists($view = 'dashboard.sections.features.validations.' . $rule))
						@include ($view, [
							'validation_rules' => $validation_rules,
							'feature' => $feature,
							'rule' => $rule
						])
					@endif
				@endforeach

				<div class="form-group">
					<label for="name">{{ trans('features.help_message') }}:</label>
					<input type="text" class="form-control" name="help_message" value="{{ $feature->help_message }}">
				</div>
				<div class="form-group">
					<label for="filterable">filterable:</label>
					<select name="filterable" class="form-control">
						<option value="1" @if ($feature->filterable == '1') selected="selected" @endif >{{ trans('globals.yes') }}</option>
						<option value="0" @if ($feature->filterable == '0') selected="selected" @endif >{{ trans('globals.no') }}</option>
					</select>
				</div>
				<div class="form-group">
					<label for="name">{{ trans('globals.status') }}:</label>
					<select name="status" class="form-control">
						<option value="1" @if ($feature->status == 1) selected="selected" @endif >{{ trans('globals.active') }}</option>
						<option value="0" @if ($feature->status == 0) selected="selected" @endif >{{ trans('globals.inactive') }}</option>
					</select>
				</div>
				<div class="form-group">
					<input type="hidden" name="current_feature" value="{{ $feature->id }}">
				</div>
				<div class="form-group">
					<hr>
					<div class="row">
						<div class="col-lg-12">
							<div class="alert alert-warning" role="alert">
								<i class="glyphicon glyphicon-warning-sign"></i>&nbsp;{{ trans('features.warning_message') }}
							</div>
						</div>
					</div>
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
