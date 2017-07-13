<div class="panel panel-info">
	<div class="panel-heading"><i class="glyphicon glyphicon-menu-right"></i>&nbsp;{{ trans('globals.details') }}</div>
	<div class="panel-body">

		<div class="form-group">
			<label for="name">{{ trans('globals.name') }}:</label>
			<input type="text" class="form-control" name="name" value="{{ $item->name ?? old('name') }}">
		</div>

		<div class="form-group">
			<label for="description">{{ trans('globals.description') }}:</label>
			<textarea class="form-control" name="description" id="" cols="30" rows="2">{{ $item->description ?? old('description') }}</textarea>
		</div>

		<div class="row">
			<div class="form-group col-lg-6">
				<label for="cost">{{ trans('globals.cost') }}:</label>
				<input type="text" class="form-control" name="cost" value="{{ $item->cost_in_dollars ?? old('cost') }}">
			</div>
			<div class="form-group col-lg-6">
				<label for="price">{{ trans('globals.price') }}:</label>
				<input type="text" class="form-control" name="price" value="{{ $item->price_in_dollars ?? old('price') }}">
			</div>
		</div>

		<div class="form-group">
			<label for="name">{{ trans('globals.status') }}:</label>
			<select name="status" class="form-control">
				<option value="1" @if (isset($item) && $item->status) selected="selected" @endif>{{ trans('globals.active') }}</option>
				<option value="0" @if (isset($item) && ! $item->status) selected="selected" @endif>{{ trans('globals.inactive') }}</option>
			</select>
		</div>

	</div>
</div>
