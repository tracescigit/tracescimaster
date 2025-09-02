<a href="{{ url('lang/en') }}">
	<img title="English" class="mr-1  border ml-3 {{str_replace('_', '-', app()->getLocale())=='en'?'':'opacity-60'}}" src="{{ asset('dist/images/flags/ln_en.gif') }}" alt="">
</a>

<a href="{{ url('lang/fr') }}">
	<img title="Français" class="mx-1 border {{str_replace('_', '-', app()->getLocale())=='fr'?'':'opacity-60'}}" src="{{ asset('dist/images/flags/ln_fr.gif') }}" alt="">
</a>