@extends('dashboard.layouts.panel')

@section('sectionTitle', 'products list')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<a href="#" class="btn btn-success">
				{{ trans('features.create') }}
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
					<th class="text-center">
						Filterable&nbsp;
						<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal">
  							<i class="glyphicon glyphicon-question-sign"></i>
						</button>
					</th>
					<th class="text-center">{{ trans('globals.status') }}</th>
					<th class="text-center">{{ trans('globals.created_at') }}</th>
					<th class="text-center">{{ trans('globals.updated_at') }}</th>
					<th class="text-center">{{ str_plural(trans('globals.action')) }}</th>
				</thead>
				<tbody>
					@foreach ($products as $product)
						<tr>
							<td class="text-center">1</td>
							<td class="text-left">2</td>
							<td class="text-center">3</td>
							<td class="text-left">4</td>
							<td class="text-center">5</td>
							<td class="text-center">6</td>
							<td class="text-center">7</td>
							<td class="text-center">8</td>
							<td class="text-center">9</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection
