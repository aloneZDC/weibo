@extends('dashboard.layouts.panel')

@section('sectionTitle', trans('categories.edit_title'))

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
					<label for="name">
						@if (! is_null($category->icon))
							<i class="{{ $category->icon }}"></i>&nbsp;
						@endif
						{{ trans('categories.icon') }}:
					</label>
					<input type="text" class="form-control" name="icon" value="{{ $category->icon }}">
				</div>
				<div class="form-group">
					<label for="name">{{ trans('globals.status') }}:</label>
					<select name="status" class="form-control">
						<option value="1" @if ($category->status) selected="selected" @endif>{{ trans('globals.active') }}</option>
						<option value="0" @if (! $category->status) selected="selected" @endif>{{ trans('globals.inactive') }}</option>
					</select>
				</div>
				<div class="form-group">
					<label for="name">{{ trans('categories.parent') }}:</label>
					<select name="category_id" class="form-control">
						<option value="">---</option>
						@foreach ($parents as $parent)
							<option value="{{ $parent->id }}" @if ($hasParent && $parent->id == $category->parent->id) selected="selected" @endif >
								{{ ucfirst($parent->name) }}
							</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-12">
							<label for="name">{{ trans('categories.background') }}:</label>
								@if (is_null($category->image))
									<input type="file" class="form-control" name="pictures[storing]">
								@else
									<div class="input-group">
										<span class="input-group-addon">
											<input type="checkbox" name="pictures[deleting]">&nbsp;<span class="label label-danger">{{ trans('globals.delete') }}</span>
										</span>
										<input type="file" class="form-control" name="pictures[storing]">
										<div class="input-group-btn">
											<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#image_{{ $category->id }}">
												<i class="glyphicon glyphicon-search"></i>
											</button>
										</div>
									</div>
								@endif
						</div>
					</div>
				</div>
				<div class="form-group">
					<input type="hidden" name="current_category" value="{{ $category->id }}">
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

	@if (! is_null($category->image))
		@include ('dashboard.partials.image', [
			'modalId' => $category->id,
			'image' => $category->image
		])
	@endif

@endsection
