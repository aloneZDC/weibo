<div class="panel panel-info">
	<div class="panel-heading"><i class="glyphicon glyphicon-menu-right"></i>&nbsp;{{ trans('products.stock') }}</div>
	<div class="panel-body">

		<div class="row">
			<div class="form-group col-lg-6">
				<label for="stock">{{ trans('products.stock') }}:</label>
				<input type="text" class="form-control" name="stock" value="{{ $item->stock ?? old('stock') }}">
			</div>
			<div class="form-group col-lg-6">
				<label for="low_stock">{{ trans('products.low_stock') }}:</label>
				<input type="text" class="form-control" name="low_stock" value="{{ $item->low_stock ?? old('low_stock') }}">
			</div>
		</div>

	</div>
</div>
