<ul class="list-group" data-entity="{{get_class($items->first())}}">
    @foreach($items as $item)
        <li class="list-group-item clearfix" data-entity-id="{{$item->id}}">
            <div class="item-content">
                <div class="admin-entry-item admin-entry-logo block">
                    <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                </div>
                <div class="admin-entry-item admin-entry-content" style="margin: 0 15px;">
                <span>
                    {{ $item->name }}
                </span>
                </div>
                <div class="admin-entry-item admin-entry-content">
                    <a href="/admin/faq/{{ $item->id }}/edit">
                        {{ mb_strlen($item->message) > 50 ? mb_substr($item->message, 0, 47).'...' : $item->message }}
                    </a>
                </div>
                <div class="admin-entry-item admin-entry-controls">
                    <a href="/admin/news/{{ $item->id }}/edit" class="btn btn-xs btn-link">
                        <i class="glyphicon glyphicon-edit"></i>
                    </a>
                    {!! Form::open(['action' => ['FaqController@destroy', $item->id], 'method' => 'delete']) !!}
                    <button type="submit" onclick="return confirm('Вы уверены?')" class="btn btn-xs btn-link red">
                        <i class="glyphicon glyphicon-trash"></i>
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </li>
    @endforeach
</ul>