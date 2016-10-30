<ul class="list-group entity-sortable" data-entity="{{get_class($items->first())}}">
    @foreach($items as $item)
        <li class="list-group-item clearfix no-nesting" data-entity-id="{{$item->id}}">
            <div class="item-content">
                <div class="admin-entry-item admin-entry-logo block">
                    <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                </div>
                <div class="admin-entry-item admin-entry-content">
                    <a href="/admin/texts/{{ $item->id }}/edit" class="btn btn-xs btn-link">
                        <span>{{ $item->name }}</span>
                    </a>
                </div>
                <div class="admin-entry-item admin-entry-content">
                    <span>{{ $item->code }}</span>
                </div>
                <div class="admin-entry-item admin-entry-content">
                    <div class="text_content">
                        <pre>{{ (mb_strlen($item->text_content) > 45 ? (mb_substr($item->text_content, 0, 42).'...') : $item->text_content) }}</pre>
                    </div>
                </div>
                <div class="admin-entry-item admin-entry-controls">
                    <a href="javascript: void(0)" class="btn btn-xs btn-link dragger-handle" style="cursor: move;">
                        <i class="glyphicon glyphicon-sort"></i>
                    </a>
                    <a href="/admin/texts/{{ $item->id }}/edit" class="btn btn-xs btn-link">
                        <i class="glyphicon glyphicon-edit"></i>
                    </a>
                    {!! Form::open(['action' => ['TextsController@destroy', $item->id], 'method' => 'delete']) !!}
                    <button type="submit" onclick="return confirm('Вы уверены?')" class="btn btn-xs btn-link red">
                        <i class="glyphicon glyphicon-trash"></i>
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </li>
    @endforeach
</ul>