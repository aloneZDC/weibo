@extends('foundation.layouts.panel')

@section('sectionTitle', 'categories edit')

@section('content')
	<div class="row">
		<div class="col-lg-6">

			<form action="{{ route('categories.update', ['category' => $category->id]) }}" method="POST" role="form" enctype="multipart/form-data">
				{{ csrf_field() }}
				{{ method_field('PATCH') }}
				<div class="form-group">
					<label for="name">{{ trans('globals.name') }}:</label>
					<input type="text" class="form-control" name="name" value="{{ $category->name }}">
				</div>
				<div class="form-group">
					<label for="name">{{ trans('globals.description') }} :</label>
					<textarea class="form-control"  name="description" cols="30" rows="2">{{ $category->description }}</textarea>
				</div>
				<div class="form-group">
					<label for="name">{{ trans('categories.background') }}:</label>
					<input type="file" class="form-control" name="background">
				</div>
				<div class="form-group">
					<label for="name">{{ trans('categories.icon') }}:</label>
					<input type="text" class="form-control" name="icon" value="{{ $category->icon }}">
				</div>
				<div class="form-group">
					<label for="name">{{ trans('globals.status') }}:</label>
					<select name="status" class="form-control">
						<option value="1" @if ($category->status == 1) selected @endif>{{ trans('globals.active') }}</option>
						<option value="0" @if ($category->status == 2) selected @endif>{{ trans('globals.inactive') }}</option>
					</select>
				</div>
				<div class="form-group">
					<label for="name">{{ trans('categories.parent') }}:</label>
					<select name="parent" class="form-control">
						@foreach ($parents as $parent)
							<option value="{{ $parent->id }}" @if ($hasParent && $parent->id == $category->parent->id) selected="selected" @endif >
								{{ ucfirst($parent->name) }}
							</option>
						@endforeach
					</select>
				</div>
				<button type="submit" class="btn btn-default">
					<i class="glyphicon glyphicon-send"></i>&nbsp;
					{{ trans('globals.submit') }}
				</button>
			</form>

		</div>
	</div>
@endsection
