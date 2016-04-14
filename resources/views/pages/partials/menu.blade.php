<ul class="clearfix">
    @foreach ($menu as $page)
        <li class="shadowed {{ $page->url == $_SERVER['REQUEST_URI'] ? 'sel' : '' }}" style="width: {{ 100 / sizeof($menu) }}%;">
            <a href="{{ $page->url != $_SERVER['REQUEST_URI'] ? $page->url : 'javascript: void(0)' }}">{{ $page->name }}</a>
        </li>
    @endforeach
</ul>