@extends('layouts.master', [
	'panel' => ['center' => ['width' => '12']]
])

@section('title')@parent - {{ trans('company.contact.title') }} @stop

@include('partial.message')

@section('content')
	@parent

	@section('center_content')

		<div class="page-header">
            <h5>{{ trans('company.contact.title') }}</h5>
        </div>

        <div class="row">
        	<div class="col-md-12">
				<address>
					<p><strong>{{ ucfirst($company['name']) }}</strong></p>
					<p>{{ $company['address'] }}</p>
					<p>{{ $company['city'] }}, {{ $company['state'] }} {{ $company['zip_code'] }}</p>
					<p>
						<abbr title="Phone">{{ trans('address.phone')}}:</abbr> {{ $company['phone_number'] }}
						@if (trim($company['cell_phone']) != '')
							/ {{ $company['cell_phone'] }}
						@endif
					</p>
				</address>
			</div>
		</div>

        <div class="row">
        	<div class="col-md-12">
				<iframe
					width = "100%"
					height = "300"
					frameborder = "0" style = "border:0; float:left;"
					src = "https://www.google.com/maps/embed/v1/place?key={{ env('GOOGLE_MAP_KEY') }}
					&q = {{ $company['address'] }},{{ $company['city'] }}+{{ $company['state'] }}"
				>
				</iframe>
        	</div>
        </div>

        <div class="row">
        	<div class="col-md-12">

				<div class="panel panel-primary">
					<div class="panel-heading">{{ trans('company.contact.form_heading') }}.</div>
					<div class="panel-body">
						<form action="{{ route('contact.store') }}" method="POST">
							{{ csrf_field() }}
							<div class="form-group">
								<label for="name">{{ trans('company.contact.label_name') }}:</label>
								<input type="text" class="form-control" name="name" required value="{{ old('name') }}">
							</div>
							<div class="form-group">
								<label for="name">{{ trans('company.contact.label_email') }}:</label>
								<input type="email" class="form-control" name="email" required value="{{ old('email') }}">
							</div>
							<div class="form-group">
								<label for="name">{{ trans('company.contact.label_message') }}:</label>
								<textarea name="message" cols="30" rows="3" class="form-control" required>{{ old('message') }}</textarea>
							</div>
							<div class="form-group">
								<button class="btn btn-primary" type="submit">{{ trans('globals.submit') }}</button>
							</div>
		        		</form>
					</div>
				</div>

        	</div>
        </div>

	@endsection
@endsection
