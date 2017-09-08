<div class="vertical-nav">

	<div class="navbar navbar-default" role="navigation">

		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<span class="visible-xs navbar-brand">{{ trans('user.summary') }}</span>
		</div>

		<div class="navbar-collapse collapse sidebar-navbar-collapse">

			<ul class="nav navbar-nav list-group" >
				<li class="list-group-item">
					<a href="{{ route('summary') }}">
						<i class="glyphicon glyphicon-stats"></i>&nbsp;
						{{ trans('user.summary') }}
					</a>
				</li>
				<li class="divider"></li>
				<li class="list-group-item">
					<a href="{{ route('user.index') }}">
						<i class="glyphicon glyphicon-user"></i>&nbsp;
						{{ trans('user.profile') }}
					</a>
				</li>
				<li class="divider"></li>
				<li class="list-group-item">
					<a href="{{ route('addressBook.index') }}">
						<i class="glyphicon glyphicon-map-marker"></i>&nbsp;
						{{ trans('user.address_book') }}
					</a>
				</li>

				@if (auth()->user()->isAdmin())

					<li class="divider"></li>
					<li class="list-group-item">
						<a href="{{ route('dashboard.home') }}">
							<i class="glyphicon glyphicon-dashboard"></i>&nbsp;
							{{ trans('globals.dashboard') }}
						</a>
					</li>
					<li class="divider"></li>
					<li class="list-group-item">
						<a href="{{ route('orders.pendingOrders') }}">
							<i class="glyphicon glyphicon-piggy-bank"></i>&nbsp;
							{{ trans('user.your_sales') }}
						</a>
					</li>

				@else

					<li class="divider"></li>
					<li class="list-group-item">
						<a href="{{ route('orders.show_orders') }}">
							<i class="glyphicon glyphicon-piggy-bank"></i>&nbsp;
							{{ trans('user.your_orders') }}
						</a>
					</li>

				@endif
			</ul>

		</div>

	</div>

</div>
