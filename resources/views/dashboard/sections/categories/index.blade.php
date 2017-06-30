@extends('dashboard.layouts.panel')

@section('sectionTitle', trans('dashboard.nav.categories'))

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<a href="{{ route('categories.create') }}" class="btn btn-success">
				{{ trans('categories.create') }}
			</a>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table class="table table-hover">
				<thead>
					<th class="text-center">{{ trans('globals.id') }}</th>
					<th class="text-center">{{ trans('categories.icon') }}</th>
					<th class="text-left">{{ trans('globals.name') }}</th>
					<th class="text-left">{{ trans('categories.parent_category') }}</th>
					<th class="text-center">{{ trans('globals.status') }}</th>
					<th class="text-center">{{ str_plural(trans('globals.action')) }}</th>
				</thead>
				<tbody>
					@foreach ($categories as $category)
						<tr>
							<td class="text-center">{{ $category->id }}</td>
							<td class="text-center"><i class="{{ $category->icon }}"></i></td>
							<td class="text-left">{{ ucfirst($category->name) }}</td>
							<td class="text-left">{{ is_null($category->parent) ? '---' : ucfirst($category->parent->name) }}</td>
							<td class="text-center">
								@if ($category->status)
									<span class="label label-success">{{ trans('globals.active') }}</span>
								@else
									<span class="label label-danger">{{ trans('globals.inactive') }}</span>
								@endif
							</td>
							<td class="text-center">
								<a href="{{ route('categories.edit', ['category' => $category->id]) }}" class="btn btn-primary btn-sm">
									<i class="glyphicon glyphicon-edit"></i>
								</a>
								@if (! is_null($category->image))
									<button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#image_{{ $category->id }}">
										<i class="glyphicon glyphicon-picture"></i>
									</button>
								@endif

								@if (! is_null($category->image))
									@include ('dashboard.partials.image', [
										'modalId' => $category->id,
										'image' => $category->image,
									])
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<hr>
        	{!! $categories->render() !!}
        </div>
    </div>

@endsection
