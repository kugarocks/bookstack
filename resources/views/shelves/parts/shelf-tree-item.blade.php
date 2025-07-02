<li class="shelf-item">
    <div class="shelf-header">
        @icon('bookshelf')
        <a href="{{ $shelf->getUrl() }}" class="entity-title text-bookshelf">
            {{ $shelf->name }}
        </a>
        @if(count($books) > 0)
            <span class="book-count">({{ count($books) }})</span>
        @endif
    </div>
    @if(count($books) > 0)
        <ul class="shelf-books">
            @foreach($books as $book)
                <li class="book-item">
                    @icon('book')
                    <a href="{{ $book->getUrl() }}" class="entity-title text-book">
                        {{ $book->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</li> 