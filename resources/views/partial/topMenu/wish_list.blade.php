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
