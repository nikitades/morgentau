<li class="sortable-item clearfix list-group-item" data-entity-id="{{$page->id}}">
    <div class="item-content">
        <div class="item--icon" style="width: 36px;">
            @include('partials.fa', ['code' => 'fa-file-o ' . ($page->is_active ? '' : 'page_not_active')])
        </div>
        <div class="item--name" style="max-width: 150px; text-overflow:  ellipsis; margin: 0 15px 0 0;">
            <a href="/admin/pages/{{ $page->id }}/edit">
                {{ $page->name }}
            </a>
        </div>
        <div class="item--view" style="margin: 0 15px;">
            @if ($page->view)
                <span style="font-size: 12px;">Шаблон: <code>{{ $views[$page->view] }}</code></span>
            @endif
        </div>
        <div class="item--url" style="margin: 0 15px;">
            <code style="font-size: 12px;"><a href="{{ $page->full_url }}">{{ $page->full_url }}</a></code>
        </div>
        <div class="item--controls text-right" style="float: right; width: 120px;">
            <a href="javascript: void(0)" class="btn btn-sm btn-link dragger-handle" style="cursor: move;">
                @include('partials.fa', ['code' => 'fa-sort'])
            </a>
            <a href="/admin/pages/{{ $page->id }}/edit" class="btn btn-sm btn-default btn-outline-primary">
                @include('partials.fa', ['code' => 'fa-edit'])
            </a>
            <div class="pull-right">
                {!! Form::open(['action' => ['PagesController@destroy', $page->id], 'method' => 'delete']) !!}
                <button type="submit" onclick="return confirm('Вы уверены?')" class="btn btn-sm btn-link red">
                    @include('partials.fa', ['code' => 'fa-trash-o'])
                </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @if (sizeof($page->children))
        <ul class="secondary list-group sortable-item-nest">
            @each('partials.treepage', $page->children, 'page')
        </ul>
    @endif
</li>