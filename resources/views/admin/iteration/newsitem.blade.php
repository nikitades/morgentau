<ul class="list-group" data-entity="{{get_class($items->first())}}">
    @foreach($items as $item)
        <li class="list-group-item clearfix" data-entity-id="{{$item->id}}">
            <div class="item-content">
                <div class="admin-entry-item admin-entry-logo block">
                    <i class="fa fa-m fa-fw fa-file-text-o"></i>
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
                    <a href="/news/{{ $item->id }}/hot" class="btn btn-sm btn-link">
                        @include('partials.fa', ['code' => 'fa-star' . ($item->hot ? '' : '-o')])
                    </a>
                    <a href="/admin/news/{{ $item->id }}/edit" class="btn btn-sm btn-link">
                        @include('partials.fa', ['code' => 'fa-edit'])
                    </a>
                    <a href="/news/{{ $item->id }}/delete" onclick="return confirm('Вы уверены?')" class="btn btn-sm btn-link red">
                        @include('partials.fa', ['code' => 'fa-trash-o'])
                    </a>
                </div>
            </div>
        </li>
    @endforeach
</ul>