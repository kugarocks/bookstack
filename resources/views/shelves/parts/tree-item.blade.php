<div class="entity-tree-item book-tree-item mb-l">
    <!-- 书籍节点 -->
    <div class="book-header flex-container-row items-center">
        <div class="flex icon">
            @icon('book')
        </div>
        <div class="flex fit-content">
            <a href="{{ $book->getUrl() }}" class="entity-title text-book bold">
                {{ $book->name }}
            </a>
            @if($book->description)
                <div class="text-muted text-small">
                    {{ Str::limit(strip_tags($book->description), 100) }}
                </div>
            @endif
        </div>
        <div class="flex"></div>
        <div class="entity-meta text-muted text-small">
            @if($book->updated_at)
                <span title="{{ $book->updated_at }}">{{ $book->updated_at->diffForHumans() }}</span>
            @endif
        </div>
    </div>

    <!-- 书籍内容（章节和页面） -->
    @if(isset($bookContents[$book->id]) && count($bookContents[$book->id]) > 0)
        <div class="book-contents ml-l mt-s">
            @foreach($bookContents[$book->id] as $bookChild)
                @if($bookChild->isA('chapter'))
                    <!-- 章节节点 -->
                    <div class="tree-item chapter-item">
                        <div class="flex-container-row items-center mb-xs">
                            <div class="flex icon">
                                @icon('chapter')
                            </div>
                            <div class="flex fit-content">
                                <a href="{{ $bookChild->getUrl() }}" class="entity-title text-chapter">
                                    {{ $bookChild->name }}
                                </a>
                                @if($bookChild->description)
                                    <div class="text-muted text-small">
                                        {{ Str::limit(strip_tags($bookChild->description), 80) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- 章节下的页面 -->
                        @if(isset($bookChild->visible_pages) && count($bookChild->visible_pages) > 0)
                            <div class="chapter-pages ml-l">
                                @foreach($bookChild->visible_pages as $page)
                                    <div class="tree-item page-item">
                                        <div class="flex-container-row items-center">
                                            <div class="flex icon">
                                                @icon('page')
                                            </div>
                                            <div class="flex fit-content">
                                                <a href="{{ $page->getUrl() }}" class="entity-title text-page">
                                                    {{ $page->name }}
                                                </a>
                                                @if($page->draft)
                                                    <span class="draft-indicator text-small text-muted">
                                                        ({{ trans('entities.pages_draft') }})
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <!-- 直接在书籍下的页面 -->
                    <div class="tree-item page-item">
                        <div class="flex-container-row items-center">
                            <div class="flex icon">
                                @icon('page')
                            </div>
                            <div class="flex fit-content">
                                <a href="{{ $bookChild->getUrl() }}" class="entity-title text-page">
                                    {{ $bookChild->name }}
                                </a>
                                @if($bookChild->draft)
                                    <span class="draft-indicator text-small text-muted">
                                        ({{ trans('entities.pages_draft') }})
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <!-- 空书籍 -->
        <div class="book-contents ml-l mt-s">
            <div class="text-muted text-small italic">
                {{ trans('entities.books_empty_contents') }}
            </div>
        </div>
    @endif
</div> 