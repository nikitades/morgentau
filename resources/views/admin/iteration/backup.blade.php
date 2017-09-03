<ul class="list-group" data-entity="{{get_class($items->first())}}">
    @foreach($items as $item)
        <li class="list-group-item clearfix" data-entity-id="{{$item->id}}">
            <div class="item-content">
                <div class="admin-entry-item admin-entry-logo block" style="width: 3%; min-width: 35px;">
                    @include('partials.fa', ['code' => 'fa-file'])
                </div>
                <div class="admin-entry-item admin-entry-content" style="width: 20%;">
                <span style="font-size: 12px;">
                    {{ App\Date::fullDate($item->created_at) }}, {{ date('H:i:s', strtotime($item->created_at)) }}
                </span>
                </div>
                <div class="admin-entry-item admin-entry-content" style="width: 15%;">
                    <span><i>Размер: </i>{{ number_format($item->size / 1024 / 1024, 2, '.', ' ') }} Мб</span>
                </div>
                <div class="admin-entry-item admin-entry-content">
                <span>
                    {{ $item->hrType() }}
                </span>
                </div>
                <div class="admin-entry-item admin-entry-controls">
                    <a href="/backups/{{ $item->id }}/restore" onclick="if (confirm('Вы уверены?')) {$('.preloader').fadeIn(); } else {return false;}" class="btn btn-sm btn-link">
                        @include('partials.fa', ['code' => 'fa-repeat'])
                    </a>
                    <a href="/backups/{{ $item->id }}/delete" onclick="return confirm('Вы уверены?')" class="btn btn-sm btn-link red">
                        @include('partials.fa', ['code' => 'fa-trash-o'])
                    </a>
                </div>
            </div>
        </li>
    @endforeach
</ul>
<div class="col-sm-12 no-padding">
    <a href="/backups/all" onclick="if (confirm('Вы уверены?')) {$('.preloader').fadeIn(); } else {return false;}" class="btn btn-md btn-success">
        @include('partials.fa', ['code' => 'fa-save'])
        Полный слепок
    </a>
    <a href="/backups/base" onclick="if (confirm('Вы уверены?')) {$('.preloader').fadeIn(); } else {return false;}" class="btn btn-md btn-success">
        @include('partials.fa', ['code' => 'fa-save'])
        Только база
    </a>
    <a href="/backups/files" onclick="if (confirm('Вы уверены?')) {$('.preloader').fadeIn(); } else {return false;}" class="btn btn-md btn-success">
        @include('partials.fa', ['code' => 'fa-save'])
        Только файлы сайта
    </a>
</div>