@extends('foundation.layouts.panel')

@section('sectionTitle', trans('foundation.nav.categories'))

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<table class="table table-hover">
				<thead>
					<th class="text-center">ID</th>
					<th class="text-left">Name</th>
					<th class="text-left">Parent</th>
					<th class="text-center">Status</th>
					<th class="text-center">Actions</th>
				</thead>
				<tbody>
					@foreach ($categories as $category)
						<tr>
							<td class="text-center">{{ $category->id }}</td>
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
								<button class="btn btn-danger btn-sm" type="submit">
									<i class="glyphicon glyphicon-trash"></i>
								</button>
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
