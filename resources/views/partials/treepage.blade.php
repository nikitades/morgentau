<li class="sortable-item clearfix list-group-item" data-entity-id="{{$page->id}}">
    <div class="item-content">
        <div class="item--icon" style="width: 36px;">
            <span class="glyphicon glyphicon-file {{ $page->is_active ? '' : 'page_not_active' }}"aria-hidden="true"></span>
        </div>
        <div class="item--name" style="width: 30%;">
            <a href="/admin/pages/{{ $page->id }}/edit">
                {{ $page->name }}
            </a>
        </div>
        <div class="item--view" style="width: 20%;">
            @if ($page->view)
                {{ $views[$page->view] }}
            @endif
        </div>
        <div class="item--url" style="width: 20%;">
            <a href="{{ $page->full_url }}">{{ $page->full_url }}</a>
        </div>
        <div class="item--controls text-right" style="float: right; width: 120px;">
            <a href="/admin/pages/{{ $page->id }}/edit" class="btn btn-xs btn-link">
                <i class="glyphicon glyphicon-edit"></i>
            </a>
            <div class="pull-right">
                {!! Form::open(['action' => ['PagesController@destroy', $page->id], 'method' => 'delete']) !!}
                <button type="submit" onclick="return confirm('Вы уверены?')" class="btn btn-xs btn-link red">
                    <i class="glyphicon glyphicon-trash"></i>
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