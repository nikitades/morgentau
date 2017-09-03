<ul class="navbar-nav navbar-sidenav">
    @foreach ($elements as $data)
        <li class="nav-item {{ ($data['url'] == $_SERVER['REQUEST_URI'] || $data['url'].'/new' == $_SERVER['REQUEST_URI'] || preg_match('#'.$data['url'].'\/(\d+)\/edit#', $_SERVER['REQUEST_URI'])) && $data['url'] != '' ? 'active' : '' }}"
            data-toggle="tooltip"
            data-placement="right"
            title="{{$data['title']}}">
            <a class="nav-link" href="{{$data['url']}}">
                <i class="fa fa-fw {{$data['icon']}}"></i>
                <span class="nav-link-text">
                    {{$data['title']}}
                </span>
            </a>
        </li>
    @endforeach
</ul>