@if (auth()->user()->shoppingCart()->count())
    <li class="dropdown">
    	<a href="#cart" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
    		<span class="badge badge-cart">{{ auth()->user()->shoppingCart()->count() }} </span>
    		<span class="glyphicon glyphicon-shopping-cart"></span>{{ trans('store.cart') }}
    		<span class="caret"></span>
    	</a>

        <ul class="dropdown-menu cart" role="menu">
            @foreach (auth()->user()->shoppingCart()->take(10) as $orderDetail)
                <li>
                    <a href="{{ route('products.show', $orderDetail->product) }}" >
                        <img src="{{ $orderDetail->product->default_picture }}" alt="{{ $orderDetail->product->name }}" width="32" height="32" style="float: left; margin-right: 2px"/>
                        {{ $orderDetail->product->name }} - {{ trans('store.quantity') }}: {{ $orderDetail->quantity }}
                    </a>
                </li>
            @endforeach
            <li role="separator" class="divider"></li>
            <li><a class="btn btn-default" href="{{ route('orders.show_cart') }}" role="button">{{ trans('store.view_cart') }}</a></li>
        </ul>
    </li>
@endif
