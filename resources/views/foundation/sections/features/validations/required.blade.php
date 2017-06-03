<div class="form-group">
	<label for="name">{{ trans('globals.required') }}: </label>
	<select name="validation_rules[required]" class="form-control">
		<option value="1" @if (old('required') == trans('globals.yes') || $validation_rules->contains($rule)) selected="selected" @endif >{{ trans('globals.yes') }}</option>
		<option value="0" @if (old('required') == trans('globals.no') || ! $validation_rules->contains($rule)) selected="selected" @endif >{{ trans('globals.no') }}</option>
	</select>
</div>
