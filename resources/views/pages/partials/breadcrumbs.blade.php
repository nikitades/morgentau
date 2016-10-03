<div class="buffer-50">
    @forelse($page->getAncestry() as $page)
        @if ($page->last)
            <p class="btn btn-link last-breadcrumb">{{ $page->name }}</p>
        @else
            <a href="{{ $page->full_url }}" class="btn btn-link {{ $page->last ? 'last' : '' }}">{{ $page->name }}</a>{{ $page->last ? '' : ' >> ' }}
        @endif
    @empty
        <p>no bc's!</p>
    @endforelse
</div>