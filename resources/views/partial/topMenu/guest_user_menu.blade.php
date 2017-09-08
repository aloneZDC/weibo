<li class="dropdown">
	<a href="#" class="dropdown-toggle top-user-menu" data-toggle="dropdown" role="button" aria-expanded="false">
		<i class="glyphicon glyphicon-user"></i>&nbsp;
		{{ trans('user.your_account') }}
		<span class="caret"></span>
	</a>

	<ul class="dropdown-menu" role="menu" >
		<li><a href="{{ route('login') }}">{{ trans('user.login') }}</a></li>
		<li class="divider"></li>
		<li><a href="{{ route('register') }}">{{ trans('user.register') }}</a></li>
	</ul>
</li>
