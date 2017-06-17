@extends('dashboard.layouts.panel')

@section('sectionTitle', trans('globals.products'))

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<a href="{{ route('products_dashboard.create') }}" class="btn btn-success">
				{{ trans('product.create') }}
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
					<th class="text-left">Category</th>
{{-- 					<th class="text-center">Created By</th>
					<th class="text-left">Updated By</th> --}}
					<th class="text-center">Price</th>
					<th class="text-center">Stock</th>
					<th class="text-center">Low Stock</th>
					<th class="text-center">Status</th>
					<th class="text-center">{{ trans('globals.created_at') }}</th>
					<th class="text-center">{{ trans('globals.updated_at') }}</th>
					<th class="text-center">Actions</th>
				</thead>
				<tbody>
					@foreach ($products as $product)
						<tr>
							<td class="text-center">{{ $product->id }}</td>
							<td class="text-left">{{ str_limit($product->name, 30) }}</td>
							<td class="text-left">{{ $product->category->name }}</td>
{{-- 							<td class="text-center">{{ $product->creator->full_name }}</td>
							<td class="text-center">{{ $product->updater->full_name }}</td> --}}
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
							<td class="text-center">{{ $product->created_at->diffForHumans() }}</td>
							<td class="text-center">{{ $product->updated_at->diffForHumans() }}</td>
							<td class="text-center">
								<a href="#" class="btn btn-primary btn-sm">
									<i class="glyphicon glyphicon-edit"></i>
								</a>
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
        	{!! $products->render() !!}
        </div>
    </div>

@endsection
