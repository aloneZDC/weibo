<div class="panel panel-info">
	<div class="panel-heading"><i class="glyphicon glyphicon-menu-right"></i>&nbsp;Pictures</div>
	<div class="panel-body">

		@for ($i=1; $i<=$MAX_PICS; $i++)
				@if (isset($item) && isset($item->features['images'][$i]))
					<div class="form-group">
						<label for="">{{ trans('products.picture') }} #{{ $i }}: </label>
						<div class="input-group">
							<span class="input-group-addon">
								<input type="checkbox" name="_pictures_delete[{{ $i }}]">&nbsp;<span class="label label-danger">{{ trans('globals.delete') }}</span>
								<input type="hidden" name="_pictures_current[{{ $i }}]" value="">
							</span>
							<input type="file" class="form-control" name="_pictures_file[{{ $i }}]">
							<div class="input-group-btn">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#image_{{ $i }}">
									<i class="glyphicon glyphicon-search"></i>
								</button>
							</div>

						</div>

						@include ('dashboard.partials.image', [
							'modalId' => $i,
							'image' => $item->features['images'][$i]
						])

					</div> {{-- form-group --}}
				@else
					<div class="form-group">
						<label for="">{{ trans('products.picture') }} #{{ $i }}: </label>
						<input type="file" class="form-control" name="pictures[{{ $i }}]">
					</div>
				@endif

		@endfor

	</div>
</div>
