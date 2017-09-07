<a href="{{ route('home') }}" class="navbar-brand">
	@if ($company['logo'])
		<span class="navbar-brand-text">
			<img src="{{ $company['logo'] }}" alt="{{ $company['name'] }}">
		</span>
	@else
		<span class="navbar-brand-text">{{ $company['name'] }}</span>
	@endif

	@if (isset($company['slogan']))
		<span class="navbar-brand-slogan">{{ $company['slogan'] }}</span>
	@endif
</a>
