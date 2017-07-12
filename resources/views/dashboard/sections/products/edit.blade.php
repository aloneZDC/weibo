@extends('dashboard.layouts.panel')

@section('sectionTitle', trans('products.edit'))

@section('content')

		<form action="{{ route('items.update', ['item' => $item->id]) }}" method="POST" role="form" enctype="multipart/form-data">
			<div class="row">
				<div class="col-lg-6">
					{{ csrf_field() }}
					{{ method_field('PATCH') }}
					@include ('dashboard.sections.products.partials.detail_inputs')
					@include ('dashboard.sections.products.partials.classification_inputs')
					@include ('dashboard.sections.products.partials.stock_inputs')
				</div>
				<div class="col-lg-6">
					@include ('dashboard.sections.products.partials.features_inputs')
					@include ('dashboard.sections.products.partials.pictures_inputs')
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<hr>
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

		</form>

@endsection
