<ul class="list-group entity-sortable" data-entity="{{get_class($items->first())}}">
    @foreach($items as $item)
        <li class="list-group-item clearfix" data-entity-id="{{$item->id}}">
            <div class="item-content">
                <div class="admin-entry-item admin-entry-logo block">
                    @include('partials.fa', ['code' => 'fa-file-o'])
                </div>
                <div class="admin-entry-item admin-entry-content" style="margin: 0 15px 0 0;">
                    <a href="/admin/settings/{{ $item->id }}/edit">
                        {{ $item->name }}
                    </a>
                </div>
                <div class="admin-entry-item admin-entry-content" style="margin: 0 15px 0 0;">
                        <code style="font-size: 12px;">{{ $item->code }}</code>
                </div>
                <div class="admin-entry-item admin-entry-controls">
                    <a href="javascript: void(0)" class="btn btn-sm btn-link dragger-handle" style="cursor: move;">
                        @include('partials.fa', ['code' => 'fa-sort'])
                    </a>
                    <a href="/admin/settings/{{ $item->id }}/edit" class="btn btn-sm btn-default btn-outline-primary">
                        @include('partials.fa', ['code' => 'fa-edit'])
                    </a>
                    {!! Form::open(['action' => ['SettingsController@destroy', $item->id], 'method' => 'delete']) !!}
                    <button type="submit" onclick="return confirm('Вы уверены?')" class="btn btn-sm btn-link red">
                        @include('partials.fa', ['code' => 'fa-trash-o'])
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </li>
    @endforeach
</ul>