@extends('dashboard.layouts.panel')

@section('sectionTitle', trans('globals.products'))

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<a href="{{ route('items.create') }}" class="btn btn-success">
				{{ trans('products.create') }}
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
					<th class="text-left">{{ trans('globals.category') }}</th>
					<th class="text-center">{{ trans('globals.price') }}</th>
					<th class="text-center">{{ trans('products.stock') }}</th>
					<th class="text-center">{{ trans('products.low_stock') }}</th>
					<th class="text-center">{{ trans('globals.status') }}</th>
					<th class="text-center">{{ trans('globals.created_at') }}</th>
					<th class="text-center">{{ trans('globals.updated_at') }}</th>
					<th class="text-center">{{ trans('globals.action') }}</th>
				</thead>
				<tbody>
					@foreach ($products as $product)
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
							<td class="text-center">{{ $product->created_at->diffForHumans() }}</td>
							<td class="text-center">{{ $product->updated_at->diffForHumans() }}</td>
							<td class="text-center">
								<a href="{{ route('items.edit', $product) }}" class="btn btn-primary btn-sm">
									<i class="glyphicon glyphicon-edit"></i>
								</a>
								<a href="{{ route('itemgroup.edit', $product) }}" class="btn btn-warning btn-sm">
									<i class="glyphicon glyphicon-inbox"></i>
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
