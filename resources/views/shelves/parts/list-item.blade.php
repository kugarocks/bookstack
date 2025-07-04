<div class="shelf-item">
    <a href="{{ $shelf->getUrl() }}" class="shelf-header">
        <div class="shelf-title">
            @icon('bookshelf')
            <span class="entity-title text-bookshelf">
                {{ $shelf->name }}
            </span>
        </div>
        @if(count($shelf->visibleBooks) > 0)
            <span class="book-count">{{ count($shelf->visibleBooks) }} {{ trans('entities.books') }}</span>
        @endif
    </a>
    
    @if($shelf->getExcerpt())
        <div class="shelf-description">
            <p class="text-muted">{{ $shelf->getExcerpt() }}</p>
        </div>
    @endif
    
    @if(count($shelf->visibleBooks) > 0)
        <div class="shelf-books">
            @foreach($shelf->visibleBooks as $book)
                <a href="{{ $book->getUrl('?shelf=' . $shelf->id) }}" class="book-item">
                    @icon('book')
                    <span class="entity-title text-book">
                        {{ $book->name }}
                    </span>
                </a>
            @endforeach
        </div>
    @endif
</div>