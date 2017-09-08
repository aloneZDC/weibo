<li class="dropdown">
	<a href="#" class="dropdown-toggle top-user-menu" data-toggle="dropdown" role="button" aria-expanded="false">
		<span
			class = "glyphicon glyphicon-user user-photo"
			style = "background-image:url('{{ auth()->user()->pic_url }}');"
		></span>
		{{ auth()->user()->nickname }}&nbsp;<span class="caret"></span>
	</a>

	<ul class="dropdown-menu" role="menu" >
		<li>
			<a href="{{ route('summary') }}">
				<i class="glyphicon glyphicon-stats"></i>&nbsp;
				{{ trans('user.summary') }}
			</a>
		</li>
		<li class="divider"></li>
		<li>
			<a href="{{ route('user.index') }}">
				<i class="glyphicon glyphicon-user"></i>&nbsp;
				{{ trans('user.profile') }}
			</a>
		</li>
		<li class="divider"></li>
		<li>
			<a href="{{ route('addressBook.index') }}">
				<i class="glyphicon glyphicon-map-marker"></i>&nbsp;
				{{ trans('user.address_book') }}
			</a>
		</li>

		@if (auth()->user()->isAdmin())

			<li class="divider"></li>
			<li>
				<a href="{{ route('dashboard.home') }}">
					<i class="glyphicon glyphicon-dashboard"></i>&nbsp;
					{{ trans('globals.dashboard') }}
				</a>
			</li>
			<li class="divider"></li>
			<li>
				<a href="{{ route('orders.pendingOrders') }}">
					<i class="glyphicon glyphicon-piggy-bank"></i>&nbsp;
					{{ trans('user.your_sales') }}
				</a>
			</li>

		@else

			<li class="divider"></li>
			<li>
				<a href="{{ route('orders.show_orders') }}">
					<i class="glyphicon glyphicon-piggy-bank"></i>&nbsp;
					{{ trans('user.your_orders') }}
				</a>
			</li>

		@endif

		<li class="divider"></li>
		<li>
			<form action="{{ route('logout') }}" method="POST">
				{{ csrf_field() }}
				<button type="submit" class="btn btn-default btn-block btn-sm">{{ trans('user.logout') }}</button>
			</form>
		</li>

	</ul>
</li>
