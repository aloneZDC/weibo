@extends('foundation.layouts.panel')

@section('sectionTitle', 'features')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<a href="{{ route('categories.create') }}" class="btn btn-success">
				<i class="glyphicon glyphicon-plus"></i>&nbsp;
				features
			</a>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">

			<table class="table table-hover">
				<thead>
					<th class="text-center">{{ trans('globals.id') }}</th>
					<th class="text-left">{{ trans('globals.name') }}</th>
					<th class="text-center">{{ trans('features.input_type') }}</th>
					<th class="text-left">{{  trans('features.product_type') }}</th>
					<th class="text-center">{{ trans('globals.status') }}</th>
					<th class="text-center">{{ trans('globals.created_at') }}</th>
					<th class="text-center">{{ trans('globals.updated_at') }}</th>
					<th class="text-center">{{ str_plural(trans('globals.action')) }}</th>
				</thead>
				<tbody>
					@foreach ($features as $feature)
						<tr>
							<td class="text-center">{{ $feature->id }}</td>
							<td class="text-left">{{ ucfirst($feature->name) }}</td>
							<td class="text-center">{{ ucfirst($feature->input_type) }}</td>
							<td class="text-left">{{ ucfirst($feature->product_type) }}</td>
							<td class="text-center">
								@if ($feature->status)
									<span class="label label-success">{{ trans('globals.active') }}</span>
								@else
									<span class="label label-danger">{{ trans('globals.inactive') }}</span>
								@endif
							</td>
							<td class="text-center">{{ $feature->created_at->diffForHumans() }}</td>
							<td class="text-center">{{ $feature->updated_at->diffForHumans() }}</td>
							<td class="text-center">
								<a href="{{ route('features.edit', ['feature' => $feature->id]) }}" class="btn btn-primary btn-sm">
									<i class="glyphicon glyphicon-edit"></i>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection
