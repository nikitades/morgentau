<ul class="{{isset($classes) ? $classes : ''}}">
    @foreach ($elements as $name => $url)
        <li class="{{ ($url == $_SERVER['REQUEST_URI'] || $url.'/new' == $_SERVER['REQUEST_URI'] || preg_match('#'.$url.'\/(\d+)\/edit#', $_SERVER['REQUEST_URI'])) && $url != '' ? 'active' : '' }} {{ ($url == '' || $name == '') ? 'delimiter' : '' }}">
            @if ($url != '') <a href="{{ $url }}">{{ $name }}</a>@endif
        </li>
    @endforeach
</ul>