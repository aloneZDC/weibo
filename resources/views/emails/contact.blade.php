@extends('emails.template')

@section('content')

	<div style="padding-bottom: 10px;  margin: 20px 0 23px;">
		<div style="margin-bottom: 23px; font-size: 19.5px; line-height: inherit; color: #212121; border: 0;">
			<strong>{{ trans('company.contact.greetings_from') }},</strong>&nbsp;{{ $data->get('name') }}
		</div>
	</div>

	<div>
		<p><strong>{{ trans('company.contact.sent_from') }}:</strong></p>
		<p><a href="mailto:{{ $data->get('email') }}">{{ $data->get('email') }}</a></p>
		<p><strong>Body:</strong></p>
		<p>{{ $data->get('message') }}</p>
	</div>

@endsection
