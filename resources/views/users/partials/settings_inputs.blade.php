<div class="row">
	<div class="col-lg-12">
		<div class="col-md-4 col-lg-4 ">
			<label for="old_password">{{ trans('user.old_password') }}</label>
			<div class="input-group">
				<div class="input-group-addon input-sm"><i class="glyphicon glyphicon-lock"></i></div>
				<input type="old_password" class="form-control input-sm" name="old_password">
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="col-md-4 col-lg-4 ">
			<label for="password">{{ trans('user.password') }}</label>
			<div class="input-group">
				<div class="input-group-addon input-sm"><i class="glyphicon glyphicon-lock"></i></div>
				<input type="text" class="form-control input-sm" name="password" value="">
			</div>
		</div>
		<div class="col-md-4 col-lg-4 ">
			<label for="password_confirmation">{{ trans('user.password_confirmation') }}</label>
			<div class="input-group">
				<div class="input-group-addon input-sm"><i class="glyphicon glyphicon-lock"></i></div>
				<input type="text" class="form-control input-sm" name="password_confirmation" value="">
			</div>
		</div>
	</div>
</div>

<hr>

<div class="row">
	<div class="col-lg-12">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="hidden" name="referral" id="referral" value="account">

		<button type="submit" class="btn btn-sm btn-success pull-right">
			<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;
			{{ trans('user.update_profile') }}
		</button>
	</div>
</div>

<div class="row">&nbsp;</div>
