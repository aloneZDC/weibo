<div class="panel panel-info">
	<div class="panel-heading"><i class="glyphicon glyphicon-menu-right"></i>&nbsp;Pictures</div>
	<div class="panel-body">

		@if (isset($item))

			@foreach ($item->pictures as $picture)
				<div class="input-group">
					<span class="input-group-addon">
						<input type="radio" name="default_picture" value="{{ $picture->id }}" @if ($picture->default) checked="true" @endif >
						<span class="label label-primary">{{ trans('globals.default') }}</span>
					</span>
					<span class="input-group-addon" style="border-right: none">
						<input type="checkbox" name="pictures[deleting][{{ $picture->id }}]">&nbsp;
						<span class="label label-danger">{{ trans('globals.delete') }}</span>
					</span>
					<input type="file" class="form-control" name="pictures[storing][{{ $picture->id }}]">
					<div class="input-group-btn">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#image_{{ $picture->id }}">
							<i class="glyphicon glyphicon-search"></i>
						</button>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						@include ('dashboard.partials.image', [
							'modalId' => $picture->id,
							'image' => $picture->path
						])&nbsp;
					</div>
				</div>
			@endforeach

		@endif

		@for ($i = 0; $i < $MAX_PICS; $i++)
			<div class="form-group">
				<input type="file" class="form-control" name="pictures[storing][]">
			</div>
		@endfor

	</div>

	<div class="panel-footer">
		<small class="text-danger">
			<i class="glyphicon glyphicon-warning-sign"></i>&nbsp;
			{{ trans('products.pictures_warning') }}
		</small>
	</div>
</div>
