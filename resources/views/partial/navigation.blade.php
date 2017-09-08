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

				@if (auth()->check())
					@include ('partial.topMenu.signed_user_menu')
					@include ('partial.topMenu.wish_list')
					@include ('partial.topMenu.notifications')
					@include ('partial.topMenu.shopping_cart')
				@else
					@include ('partial.topMenu.guest_user_menu')
				@endif

				@include ('partial.topMenu.about')

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
