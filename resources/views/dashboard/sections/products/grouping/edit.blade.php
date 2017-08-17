@extends('dashboard.layouts.panel')

@section('sectionTitle', 'Manage Group for - ' . $product->name)

@section('content')

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="col-lg-8">
						@include ('dashboard.sections.products.grouping.partials.filters')
					</div>
					<div class="col-lg-4 text-right">
						@if (trim($getQueryString) != '')
							<a href="{{ route('itemgroup.edit', $product) }}" class="btn btn-danger">
							<i class="glyphicon glyphicon-remove"></i>&nbsp;Reset Filters</a>
						@else
							&nbsp;
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

	<form action="{{ route('itemgroup.update', $product) }}" method="POST" role="form">
		{{ csrf_field() }}
		{{ method_field('PATCH') }}

		<div class="row">
			<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<table class="table table-hover">
								<thead>
									<th class="text-center">{{ trans('globals.id') }}</th>
									<th class="text-left">{{ trans('globals.name') }}</th>
									<th class="text-left">{{ trans('globals.category') }}</th>
									<th class="text-center">{{ trans('globals.price') }}</th>
									<th class="text-center">{{ trans('products.stock') }}</th>
									<th class="text-center">{{ trans('products.low_stock') }}</th>
									<th class="text-center">{{ trans('globals.status') }}</th>
									<th class="text-center">{{ trans('globals.action') }}</th>
								</thead>
								<tbody>
								@foreach ($listing as $product)
								<tr>
									<td class="text-center">{{ $product->id }}</td>
									<td class="text-left">{{ str_limit($product->name, 30) }}</td>
									<td class="text-left">{{ $product->category->name }}</td>
									<td class="text-center">{{ $product->price }}</td>
									<td class="text-center">{{ $product->stock }}</td>
									<td class="text-center">{{ $product->low_stock }}</td>
									<td class="text-center">
										@if ($product->status)
											<span class="label label-success">{{ trans('globals.active') }}</span>
										@else
											<span class="label label-danger">{{ trans('globals.inactive') }}</span>
										@endif
									</td>
									<td class="text-center">
										<div class="checkbox">
											<label>
												<input
													name="associates[]"
													value="{{ $product->id }}"
													type="checkbox"
													@if($groupingIds->contains($product->id)) checked="true" @endif
												>
												&nbsp;{{ trans('globals.select') }}
											</label>
										</div>
									</td>
								</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				{!! $listing->appends(request()->all())->links() !!}
			</div>
		</div>

    	<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<a href="{{ route('items.index') }}" class="btn btn-danger">
							<i class="glyphicon glyphicon-remove"></i>&nbsp;
							{{ trans('globals.close_label') }}
						</a>
						<button type="submit" class="btn btn-success">
							<i class="glyphicon glyphicon-send"></i>&nbsp;
							{{ trans('globals.submit') }}
						</button>
					</div>
				</div>
			</div>
		</div>

	</form>
@endsection
