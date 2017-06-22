<div class="panel panel-info">
	<div class="panel-heading"><i class="glyphicon glyphicon-menu-right"></i>&nbsp;Pictures</div>
	<div class="panel-body">

		@for ($i=1; $i<=$MAX_PICS; $i++)
			<div class="form-group">
				<label for="">{{ trans('products.picture') }} #{{ $i }}: </label>
				<input type="file" class="form-control" name="pictures[{{ $i }}]">
			</div>
		@endfor


	</div>
</div>
