<div class="form-group">
	<label for="name">{{ trans('globals.required') }}: </label>
	<select name="required" class="form-control">
		<option value="1" @if ($validation_rules->contains($rule)) selected="selected" @endif >{{ trans('globals.yes') }}</option>
		<option value="0" @if (! $validation_rules->contains($rule)) selected="selected" @endif >{{ trans('globals.no') }}</option>
	</select>
</div>
