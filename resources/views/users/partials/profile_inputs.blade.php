

<div class="row">
	<div class="col-lg-12">
		<div class="pull-left">
			<div class="user-photo"><img src="{{ auth()->user()->image ?? '/images/no-avatar.png' }}"></div>
		</div>
		<h5>{{ ucwords(auth()->user()->fullName) }}</h5>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="col-md-4 col-lg-4 ">
			<label for="first_name">{{ trans('user.first_name') }}</label>
			<div class="input-group">
				<div class="input-group-addon input-sm"><span class="fa fa-align-justify"></span></div>
				<input type="text" class="form-control input-sm" name="first_name" value="{{ auth()->user()->first_name }}">
			</div>
		</div>
		<div class="col-md-4 col-lg-4 ">
			<label for="last_name">{{ trans('user.last_name') }}</label>
			<div class="input-group">
				<div class="input-group-addon input-sm"><span class="fa fa-align-justify"></span></div>
				<input type="text" class="form-control input-sm" name="last_name" value="{{ auth()->user()->last_name }}">
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="col-md-4 col-lg-4 ">
			<label for="birthday">{{ trans('user.birth_date') }}</label>
			<div class="input-group">
				<div class="input-group-addon input-sm"><span class="fa fa-align-justify"></span></div>
				<input type="date" class="form-control input-sm" name="birthday" value="{{ auth()->user()->birthday ?? \Carbon\Carbon::now() }}">
			</div>
		</div>
		<div class="col-md-4 col-lg-4 ">
			<label for="gender">{{ trans('user.gender') }}</label>
			<select name="gender" id="gender" class="form-control input-sm">
				<option value="female" @if (auth()->user()->gender == 'female') selected="selected" @endif >female</option>
				<option value="male" @if (auth()->user()->gender == 'male') selected="selected" @endif >male</option>
			</select>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="col-md-4 col-lg-4 ">
			<label for="nickname">{{ trans('user.nickname') }}</label>
			<div class="input-group">
				<div class="input-group-addon input-sm"><span class="fa fa-align-justify"></span></div>
				<input type="text" class="form-control input-sm" name="nickname" value="{{ auth()->user()->nickname ?? \Carbon\Carbon::now() }}">
			</div>
		</div>
		<div class="col-md-4 col-lg-4 ">
			<label for="email">{{ trans('user.email') }}</label>
			<div class="input-group">
				<div class="input-group-addon input-sm"><span class="fa fa-align-justify"></span></div>
				<input type="email" class="form-control input-sm" name="email" value="{{ auth()->user()->email }}">
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="col-md-4 col-lg-4 ">
			<label for="avatar">{{ trans('user.avatar') }}</label>
			<input type="file" class="form-control input-sm" name="pictures[storing]">
		</div>
	</div>
</div>

<hr>

<div class="row">
	<div class="col-lg-12">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="hidden" name="referral" id="referral" value="profile">

		<button type="submit" class="btn btn-sm btn-success pull-right">
			<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;
			{{ trans('user.update_profile') }}
		</button>
	</div>
</div>

<div class="row">&nbsp;</div>
