<li class="item">
    <div class="item--icon">
        <span class="glyphicon glyphicon-file {{ $page->is_active ? '' : 'page_not_active' }}"
              aria-hidden="true"></span>
    </div>
    <div class="item--name">
        <a href="/admin/pages/{{ $page->id }}/edit">
            {{ $page->name }}
        </a>
    </div>
    <div class="item--view">
        @if ($page->view)
            {{ $views[$page->view] }}
        @endif
    </div>
    <div class="item--url">
        <a href="{{ $page->full_url }}">{{ $page->full_url }}</a>
    </div>
    <div class="item--controls">
        @if ($page->real_level != 0)
            {!! Form::open(['action' => ['PagesController@move', $page->id, 'up'], 'method' => 'delete']) !!}
            <button type="submit" class="btn btn-xs btn-link">
                <i class="glyphicon glyphicon-arrow-up"></i>
            </button>
            {!! Form::close() !!}
            {!! Form::open(['action' => ['PagesController@move', $page->id,  'down'], 'method' => 'delete']) !!}
            <button type="submit" class="btn btn-xs btn-link">
                <i class="glyphicon glyphicon-arrow-down"></i>
            </button>
            {!! Form::close() !!}
        @endif
        <a href="/admin/pages/{{ $page->id }}/edit" class="btn btn-xs btn-link">
            <i class="glyphicon glyphicon-edit"></i>
        </a>
        {!! Form::open(['action' => ['PagesController@destroy', $page->id], 'method' => 'delete']) !!}
        <button type="submit" onclick="return confirm('Вы уверены?')" class="btn btn-xs btn-link red">
            <i class="glyphicon glyphicon-trash"></i>
        </button>
        {!! Form::close() !!}
    </div>
</li>
@if (sizeof($page->children))
    <ul>
        @each('partials.treepage', $page->children, 'page')
    </ul>
@endif