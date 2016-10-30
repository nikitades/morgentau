<ul class="list-group" data-entity="{{get_class($items->first())}}">
    @foreach($items as $item)
        <li class="list-group-item clearfix" data-entity-id="{{$item->id}}">
            <div class="item-content">
                <div class="admin-entry-item admin-entry-logo block">
                    <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                </div>
                <div class="admin-entry-item admin-entry-content" style="margin: 0 15px;">
                <span style="font-size: 12px;">
                    {{ App\Date::fullDate($item->date) }}
                </span>
                </div>
                <div class="admin-entry-item admin-entry-content">
                    <a href="/admin/news/{{ $item->id }}/edit">
                        {{ $item->title }}
                    </a>
                </div>
                <div class="admin-entry-item admin-entry-controls">
                    <a href="/news/{{ $item->id }}/hot" class="btn btn-xs btn-link">
                        <i class="glyphicon glyphicon-star{{ $item->hot ? '' : '-empty' }}"></i>
                    </a>
                    <a href="/admin/news/{{ $item->id }}/edit" class="btn btn-xs btn-link">
                        <i class="glyphicon glyphicon-edit"></i>
                    </a>
                    <a href="/news/{{ $item->id }}/delete" onclick="return confirm('Вы уверены?')" class="btn btn-xs btn-link red">
                        <i class="glyphicon glyphicon-trash"></i>
                    </a>
                </div>
            </div>
        </li>
    @endforeach
</ul>