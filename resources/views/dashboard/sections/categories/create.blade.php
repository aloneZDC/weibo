@extends('dashboard.layouts.panel')

@section('sectionTitle', trans('categories.create'))

@section('content')

	<div class="row">

		<div class="col-lg-6">
			<form action="{{ route('categories.store') }}" method="POST" role="form" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="name">{{ trans('globals.name') }}:</label>
					<input type="text" class="form-control" name="name" value="{{ old('name') }}">
				</div>
				<div class="form-group">
					<label for="name">{{ trans('globals.description') }} :</label>
					<textarea class="form-control"  name="description" cols="30" rows="2">{{ old('description') }}</textarea>
				</div>
				<div class="form-group">
					<label for="name">{{ trans('categories.icon') }}:</label>
					<input type="text" class="form-control" name="icon" value="{{ old('icon') }}">
				</div>
				<div class="form-group">
					<label for="name">{{ trans('globals.status') }}:</label>
					<select name="status" class="form-control">
						<option value="1" @if (old('status') == '1') selected="selected" @endif >{{ trans('globals.active') }}</option>
						<option value="0" @if (old('status') == '0') selected="selected" @endif >{{ trans('globals.inactive') }}</option>
					</select>
				</div>
				<div class="form-group">
					<label for="name">{{ trans('categories.parent') }}:</label>
					<select name="category_id" class="form-control">
						<option value="">---</option>
						@foreach ($parents as $parent)
							<option value="{{ $parent->id }}" @if (old('category_id') == $parent->id) selected="selected" @endif >
								{{ ucfirst($parent->name) }}
							</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-12">
							<label for="name">{{ trans('categories.background') }}:</label>
							<input type="file" class="form-control" name="pictures[storing]">
						</div>
					</div>
				</div>
				<div class="form-group">
					<hr>
					<a href="{{ route('categories.index') }}" class="btn btn-danger">
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
