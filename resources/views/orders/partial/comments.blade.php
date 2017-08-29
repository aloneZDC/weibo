@foreach ($order->comments as $comment)
	<div class="panel @if ($order->seller_id == $comment->data['sender_id']) panel-warning @else panel-success @endif ">

		<div class="panel-heading clearfix">
		    @if ($order->seller_id == $comment->data['sender_id'])

			    <span class="glyphicon glyphicon-briefcase"></span>&nbsp;
			    <strong>{{ trans('store.show_order_details_view.seller_comment_at') }}:</strong>&nbsp;
		        {{ $comment->created_at->diffForHumans() }}

		    @elseif ($order->user_id == $comment->data['sender_id'])

			    <span class="glyphicon glyphicon-user"></span>&nbsp;
			    <strong>{{ trans('store.show_order_details_view.user_comment_at') }}:</strong>&nbsp;
		        {{ $comment->created_at->diffForHumans() }}

		    @endif
		</div>

		<div class="panel-body">
		    <span class="text-left pull-left">
		        {{ $comment->data['message'] }}
		    </span>
		</div>
	</div>
@endforeach
