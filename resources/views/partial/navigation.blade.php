<div class="navbar-wrapper container">
	<nav class="navbar navbar-inverse navbar-static-top">

		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<div class="navbar-brand">
				@include ('partial.branding')
			</div>
		</div>

		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						<span class="glyphicon glyphicon-menu-right"></span>{{ trans('company.who_we_are') }}
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="{{ route('about') }}">{{ trans('company.about') }}</a></li>
						<li><a href="{{ route('about', ['section' => 'refunds']) }}">{{ trans('company.refunds') }}</a></li>
						<li><a href="{{ route('about', ['section' => 'terms']) }}">{{ trans('company.terms') }}</a></li>
					</ul>
				</li>

				@include ('user.partial.menu_top')

				@if (auth()->check())
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							<span class="fui fui-heart"></span>{{ trans('store.wish_list') }}
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="{{ route('orders.show_wish_list') }}">{{ trans('store.wish_list') }}</a></li>
							<li><a href="{{ route('orders.show_list_directory') }}">{{ trans('store.your_wish_lists') }}</a></li>
						</ul>
					</li>
				@endif

				@if (auth()->check() && auth()->user()->shoppingCart()->count())
					@include ('partial.shoppingCart')
				@endif

				@if (auth()->check())
					@include ('partial.notifications')
				@endif

				<li class="dropdown">
					<a href="{{ route('contact') }}">
						<span class="glyphicon glyphicon-envelope"></span>{{ trans('company.contact.title') }}
					</a>
				</li>

			</ul>
		</div>
	</nav>

	<nav ng-controller="CategoriesController">
		{!! Form::model(Request::all(),['url'=> route('products.index') , 'method'=>'GET', 'id'=>'searchForm']) !!}
		@if (isset($categories_menu))
		<div class="input-group">
			<span class="input-group-btn categories-search">
				<button  type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					<span ng-bind="catSelected.name || '{{ isset($categories_menu[Request::get('category')]['name']) ? $categories_menu[Request::get('category')]['name'] : trans('store.all_categories') }}'">
						{{ isset($categories_menu[Request::get('category')]['name']) ? $categories_menu[Request::get('category')]['name'] : trans('store.all_categories') }}
						</span> <span class="caret">
					</span>
				</button>
				<ul class="dropdown-menu" role="menu">
					@foreach($categories_menu as $categorie_menu)
						<li >
							<a href="javascript:void(0)"
							   ng-click="setCategorie({{ $categorie_menu['id'] }},'{{ $categorie_menu['name'] }}')" >
								{{ $categorie_menu['name'] }}
							</a>
						</li>
					@endforeach

				</ul>
			</span>
			<input type="hidden" name="category" value="[[refine() || '{{Request::get('category')}}']]"/>

			@include('partial.search_box',['angularController' => 'AutoCompleteCtrl', 'idSearch'=>'search'])

			<span class="input-group-btn">
				<button class="btn btn-default fui-search" type="submit"></button>
			</span>
		</div>
		@endif

		{!! Form::close() !!}
		</nav>
</div>
