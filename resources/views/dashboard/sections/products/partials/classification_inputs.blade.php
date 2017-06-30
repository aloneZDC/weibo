<div class="panel panel-info">
	<div class="panel-heading"><i class="glyphicon glyphicon-menu-right"></i>&nbsp;{{ trans('products.classification') }}</div>
	<div class="panel-body">

		<div class="form-group">
			<label for="name">{{ trans('globals.category') }}:</label>
			<select name="category" class="form-control">
				@foreach ($categories as $category)
					<option value="{{ $category->id }}" @if (($item->category_id ?? old('category')) == $category->id) selected="selected" @endif >
						{{ is_null($category->category_id) ? '&bull;' : '&nbsp;&nbsp;&nbsp;-' }}
						&nbsp;
						{{ ucfirst($category->name) }}
					</option>
				@endforeach
			</select>
		</div>

		<div class="row">
			<div class="form-group col-lg-6">
				<label for="brand">{{ trans('globals.brand') }}:</label>
				<input type="text" class="form-control" name="brand" value="{{ $item->brand ?? old('brand') }}">
			</div>

			<div class="form-group col-lg-6">
				<label for="condition">{{ trans('products.condition_label') }}:</label>
				<select name="condition" class="form-control">
					@foreach ($conditions as $key => $condition)
						<option value="{{ $key }}" @if (($item->condition ?? old('condition')) == $key) selected="selected" @endif >
							{{ trans($condition) }}
						</option>
					@endforeach
				</select>
			</div>
		</div>

	</div>
</div>
