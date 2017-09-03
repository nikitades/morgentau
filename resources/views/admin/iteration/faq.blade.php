<ul class="list-group" data-entity="{{get_class($items->first())}}">
    @foreach($items as $item)
        <li class="list-group-item clearfix" data-entity-id="{{$item->id}}">
            <div class="item-content">
                <div class="admin-entry-item admin-entry-logo block">
                    @include('partials.fa', ['code' => 'fa-file'])
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
                    <a href="/admin/news/{{ $item->id }}/edit" class="btn btn-sm btn-link">
                        @include('partials.fa', ['code' => 'fa-edit'])
                    </a>
                    {!! Form::open(['action' => ['FaqController@destroy', $item->id], 'method' => 'delete']) !!}
                    <button type="submit" onclick="return confirm('Вы уверены?')" class="btn btn-sm btn-link red">
                        @include('partials.fa', ['code' => 'fa-trash-o'])
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </li>
    @endforeach
</ul>