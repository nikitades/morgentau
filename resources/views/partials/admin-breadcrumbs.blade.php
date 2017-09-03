<ol class="breadcrumb">
    @if (empty($breadcrumbs))
        <? $breadcrumbs = [['segment' => 'admin', 'name' => 'Административная панель']] ?>
    @else
        <? array_unshift($breadcrumbs, ['segment' => 'admin', 'name' => 'Административная панель']) ?>
    @endif
    <? $url = '' ?>
    @foreach($breadcrumbs as $item)
        <li class="breadcrumb-item {{$loop->last ? 'active' : ''}}">
            <? $url .= '/' . $item['segment']; ?>
            @if ($loop->last)
                <span>{{$item['name']}}</span>
            @else
                <a href="{{$url}}">{{$item['name']}}</a>
            @endif
        </li>
    @endforeach
</ol>