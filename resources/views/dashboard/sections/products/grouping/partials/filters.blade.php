
@foreach($filters as $key => $value)
	<div class="btn-group">
		<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			{{ ucfirst($key) }} <span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
			@foreach($value as $item_key => $item)
				@if ($key == 'category')
						<li>
							<a href="{{ route('itemgroup.edit', $product) }}?{{ $getQueryString }}category={{ urlencode($item['id'].'|'.$item['name']) }}">
								({{ $item['qty'] }}) {{ ucfirst($item['name']) }}
							</a>
						</li>
					@else
						<li>
							<a href="{{ route('itemgroup.edit', $product) }}?{{ $getQueryString . $key }}={{ urlencode($item_key) }}">
								({{ $item }}) {{ ucfirst($item_key) }}
							</a>
						</li>
				@endif
			@endforeach
		</ul>
	</div>
@endforeach
