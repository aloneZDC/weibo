@if (count($features) > 0)
	<div class="panel panel-info">
		<div class="panel-heading"><i class="glyphicon glyphicon-menu-right"></i>&nbsp;{{ trans('products.features') }}</div>
		<div class="panel-body">

			@foreach ($features as $feature)
				<div class="form-group col-lg-6">
					<label for="{{ $feature->name }}">{{ ucfirst($feature->name) }}:</label>
					@if (isset($item))
						<input type="{{ $feature->type }}" class="form-control" name="features[{{ $feature->name }}]" value="{{ old('features.'.$feature->name) ?? $item->features[$feature->name] }}">
					@else
						<input type="{{ $feature->type }}" class="form-control" name="features[{{ $feature->name }}]" value="{{ old('features.'.$feature->name) }}">
					@endif
				</div>
			@endforeach

		</div>
	</div>
@endif
