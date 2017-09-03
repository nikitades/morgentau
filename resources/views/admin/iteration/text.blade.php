<ul class="list-group entity-sortable" data-entity="{{get_class($items->first())}}">
    @foreach($items as $item)
        <li class="list-group-item clearfix no-nesting" data-entity-id="{{$item->id}}">
            <div class="item-content">
                <div class="admin-entry-item admin-entry-logo block">
                    @include('partials.fa', ['code' => 'fa-file'])
                </div>
                <div class="admin-entry-item admin-entry-content" style="margin: 0 15px 0 0;">
                    <a href="/admin/texts/{{ $item->id }}/edit">
                        <span>{{ $item->name }}</span>
                    </a>
                </div>
                <div class="admin-entry-item admin-entry-content" style="margin: 0 15px 0 0;">
                    <span><code style="font-weight: bold;font-size: 12px;">{{ $item->code }}</code></span>
                </div>
                <div class="admin-entry-item admin-entry-content">
                    <div class="text_content">
                        <code style="font-size: 12px;">{{ (mb_strlen($item->text_content) > 45 ? (mb_substr($item->text_content, 0, 42).'...') : $item->text_content) }}</code>
                    </div>
                </div>
                <div class="admin-entry-item admin-entry-controls">
                    <a href="javascript: void(0)" class="btn btn-sm btn-link dragger-handle" style="cursor: move;">
                        @include('partials.fa', ['code' => 'fa-sort'])
                    </a>
                    <a href="/admin/texts/{{ $item->id }}/edit" class="btn btn-sm btn-link">
                        @include('partials.fa', ['code' => 'fa-edit'])
                    </a>
                    {!! Form::open(['action' => ['TextsController@destroy', $item->id], 'method' => 'delete']) !!}
                    <button type="submit" onclick="return confirm('Вы уверены?')" class="btn btn-sm btn-link red">
                        @include('partials.fa', ['code' => 'fa-trash-o'])
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </li>
    @endforeach
</ul>