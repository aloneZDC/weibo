<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
		<span class="glyphicon glyphicon-menu-right"></span>{{ trans('company.who_we_are') }}
		<span class="caret"></span>
	</a>
	<ul class="dropdown-menu" role="menu">
		<li><a href="{{ route('about') }}">{{ trans('company.about') }}</a></li>
		<li><a href="{{ route('about', ['section' => 'refunds']) }}">{{ trans('company.refunds') }}</a></li>
		<li><a href="{{ route('about', ['section' => 'terms']) }}">{{ trans('company.terms') }}</a></li>
		<li><a href="{{ route('contact') }}">{{ trans('company.contact.title') }}</a></li>
	</ul>
</li>
