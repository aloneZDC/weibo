<li class="dropdown" ng-controller="PushNotificationsController">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
		<span class="badge badge-notifications ng-hide" ng-cloak ng-show="unread.length > 0">[[ unread.length ]]</span>
		<span class="fui fui-chat"></span>{{ trans('globals.notifications') }}
		<span class="visible-xs-inline">
			<span class="caret"></span>
		</span>
	</a>

	<ul class="dropdown-menu" role="menu" ng-if="hasNotifications">
		<li ng-repeat="notification in unread" style="background-color: #fafafa">
			<a href="[[notification.path]]?notif_id=[[notification.id]]">[[ notification.label ]]</a>
		</li>
		<li ng-repeat="notification in read">
			<a href="[[notification.path]]?notif_id=[[notification.id]]">[[ notification.label ]]</a>
		</li>
		<li role="separator" class="divider"></li>
		<li>
			<a href="{{ route('notifications.index') }}" class="btn btn-default">{{ trans('globals.all') }}</a>
		</li>
	</ul>

</li>
