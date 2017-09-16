<div class="row">
	<div class="col-lg-12">
		<div class="col-md-4 col-lg-4 ">
			<label for="facebook">{{ trans('user.facebook') }}</label>
			<div class="input-group">
				<div class="input-group-addon input-sm fui-facebook"></div>
				<input type="facebook" class="form-control input-sm" name="facebook" value="{{ auth()->user()->facebook }}">
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="col-md-4 col-lg-4 ">
			<label for="twitter">{{ trans('user.twitter') }}</label>
			<div class="input-group">
				<div class="input-group-addon input-sm fui-twitter"></div>
				<input type="twitter" class="form-control input-sm" name="twitter" value="{{ auth()->user()->twitter }}">
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="col-md-4 col-lg-4 ">
			<label for="website">{{ trans('user.website') }}</label>
			<div class="input-group">
				<div class="input-group-addon input-sm"><i class="glyphicon glyphicon-globe"></i></div>
				<input type="website" class="form-control input-sm" name="website" value="{{ auth()->user()->website }}">
			</div>
		</div>
	</div>
</div>

<hr>

<div class="row">
	<div class="col-lg-12">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="hidden" name="referral" id="referral" value="social">

		<button type="submit" class="btn btn-sm btn-success pull-right">
			<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;
			{{ trans('user.update_profile') }}
		</button>
	</div>
</div>

<div class="row">&nbsp;</div>
