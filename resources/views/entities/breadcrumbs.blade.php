<nav class="breadcrumbs text-center" aria-label="{{ trans('common.breadcrumb') }}">
    <?php $breadcrumbCount = 0; ?>
    <?php $previousUrl = null; ?>

    {{-- Show top level books item --}}
    @if (count($crumbs) > 0 && ($crumbs[0] ?? null) instanceof  \BookStack\Entities\Models\Book)
        <a href="{{  url('/books')  }}" class="text-book icon-list-item outline-hover">
            <span>@icon('books')</span>
            <span>{{ trans('entities.books') }}</span>
        </a>
        <?php $breadcrumbCount++; ?>
        <?php $previousUrl = url('/books'); ?>
    @endif

    {{-- Show top level shelves item --}}
    @if (count($crumbs) > 0 && ($crumbs[0] ?? null) instanceof  \BookStack\Entities\Models\Bookshelf)
        <a href="{{  url('/shelves')  }}" class="text-bookshelf icon-list-item outline-hover">
            <span>@icon('bookshelf')</span>
            <span>{{ trans('entities.shelves') }}</span>
        </a>
        <?php $breadcrumbCount++; ?>
        <?php $previousUrl = url('/shelves'); ?>
    @endif

    @foreach($crumbs as $key => $crumb)
        <?php $isEntity = ($crumb instanceof \BookStack\Entities\Models\Entity); ?>

        @if (is_null($crumb))
            @continue
        @endif
        @if ($breadcrumbCount !== 0 && !$isEntity && $previousUrl)
            <div components="dropdown dropdown-search"
                 option:dropdown-search:url="/search/entity-selector?types=bookshelf"
                 option:dropdown-search:local-search-selector=".entity-list-item"
                 class="dropdown-search">
                <div class="dropdown-search-toggle-breadcrumb" refs="dropdown@toggle"
                     aria-haspopup="true" aria-expanded="false" tabindex="0">
                    <div class="separator">@icon('chevron-right')</div>
                </div>
                <div refs="dropdown@menu" class="dropdown-search-dropdown card" role="menu">
                    <div class="dropdown-search-search">
                        @icon('search')
                        <input refs="dropdown-search@searchInput"
                               aria-label="{{ trans('common.search') }}"
                               autocomplete="off"
                               placeholder="{{ trans('common.search') }}"
                               type="text">
                    </div>
                    <div refs="dropdown-search@loading">
                        @include('common.loading-icon')
                    </div>
                    <div refs="dropdown-search@listContainer" class="dropdown-search-list px-m" tabindex="-1"></div>
                </div>
            </div>
        @endif

        @if (is_string($crumb))
            <a href="{{  url($key)  }}">
                {{ $crumb }}
            </a>
            <?php $previousUrl = url($key); ?>
        @elseif (is_array($crumb))
            <a href="{{  url($key)  }}" class="icon-list-item outline-hover {{ $crumb['class'] ?? '' }}">
                <span>@icon($crumb['icon'])</span>
                <span>{{ $crumb['text'] }}</span>
            </a>
            <?php $previousUrl = url($key); ?>
        @elseif($isEntity && userCan('view', $crumb))
            @if($breadcrumbCount > 0)
                @include('entities.breadcrumb-listing', ['entity' => $crumb])
            @endif
            <a href="{{ $crumb->getUrl() }}" class="text-{{$crumb->getType()}} icon-list-item outline-hover">
                <span>@icon($crumb->getType())</span>
                <span>
                    {{ $crumb->getShortName() }}
                </span>
            </a>
            <?php $previousUrl = $crumb->getUrl(); ?>
        @endif
        <?php $breadcrumbCount++; ?>
    @endforeach
</nav>