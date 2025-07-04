@extends('layouts.tri')

@push('social-meta')
    <meta property="og:description" content="{{ Str::limit($shelf->description, 100, '...') }}">
    @if($shelf->cover)
        <meta property="og:image" content="{{ $shelf->getBookCover() }}">
    @endif
@endpush

@include('entities.body-tag-classes', ['entity' => $shelf])

@section('body')

    <div class="mb-s print-hidden">
        @include('entities.breadcrumbs', ['crumbs' => [
            $shelf,
        ]])
    </div>

    <main class="card content-wrap mt-m">

        <div class="flex-container-row v-center">
            <h1 class="flex break-text text-limit-lines-1">{{ $shelf->name }}</h1>
            <div class="flex fit-content text-m-right my-m ml-m">
                @include('common.sort', $listOptions->getSortControlData())
            </div>
        </div>

        <div class="book-content">
            <div class="text-muted break-text">{!! $shelf->descriptionHtml() !!}</div>
            @if(count($sortedVisibleShelfBooks) > 0)
                @if($view === 'list')
                    <div class="entity-list">
                        @foreach($sortedVisibleShelfBooks as $book)
                            @include('books.parts.list-item', ['book' => $book])
                        @endforeach
                    </div>
                @else
                    <div class="grid third">
                        @foreach($sortedVisibleShelfBooks as $book)
                            @include('entities.grid-item', ['entity' => $book])
                        @endforeach
                    </div>
                @endif
            @else
                <div class="mt-xl">
                    <hr>
                    <p class="text-muted italic mt-xl mb-m">{{ trans('entities.shelves_empty_contents') }}</p>
                    <div class="icon-list inline block">
                        @if(userCan('book-create-all') && userCan('bookshelf-update', $shelf))
                            <a href="{{ $shelf->getUrl('/create-book') }}" class="icon-list-item text-book">
                                <span class="icon">@icon('add')</span>
                                <span>{{ trans('entities.books_create') }}</span>
                            </a>
                        @endif
                        @if(userCan('bookshelf-update', $shelf))
                            <a href="{{ $shelf->getUrl('/edit') }}" class="icon-list-item text-bookshelf">
                                <span class="icon">@icon('edit')</span>
                                <span>{{ trans('entities.shelves_edit_and_assign') }}</span>
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </main>

@stop

@section('left')

    @if($shelf->tags->count() > 0)
        <div id="tags" class="mb-xl">
            @include('entities.tag-list', ['entity' => $shelf])
        </div>
    @endif

    <div id="details" class="mb-xl">
        <h5>{{ trans('common.details') }}</h5>
        <div class="blended-links">
            @include('entities.meta', ['entity' => $shelf, 'watchOptions' => null])
            @if($shelf->hasPermissions())
                <div class="active-restriction">
                    @if(userCan('restrictions-manage', $shelf))
                        <a href="{{ $shelf->getUrl('/permissions') }}" class="entity-meta-item">
                            @icon('lock')
                            <div>{{ trans('entities.shelves_permissions_active') }}</div>
                        </a>
                    @else
                        <div class="entity-meta-item">
                            @icon('lock')
                            <div>{{ trans('entities.shelves_permissions_active') }}</div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    @if(count($activity) > 0)
        <div id="recent-activity" class="mb-xl">
            <h5>{{ trans('entities.recent_activity') }}</h5>
            @include('common.activity-list', ['activity' => $activity])
        </div>
    @endif
@stop

@section('right')
    <div class="actions mb-xl">
        <h5>{{ trans('common.actions') }}</h5>
        <div class="icon-list text-link">

            @if(userCan('book-create-all') && userCan('bookshelf-update', $shelf))
                <a href="{{ $shelf->getUrl('/create-book') }}" data-shortcut="new" class="icon-list-item">
                    <span class="icon">@icon('add')</span>
                    <span>{{ trans('entities.books_new_action') }}</span>
                </a>
            @endif

            @include('entities.view-toggle', ['view' => $view, 'type' => 'bookshelf'])

            <hr class="primary-background">

            @if(userCan('bookshelf-update', $shelf))
                <a href="{{ $shelf->getUrl('/edit') }}" data-shortcut="edit" class="icon-list-item">
                    <span>@icon('edit')</span>
                    <span>{{ trans('common.edit') }}</span>
                </a>
            @endif

            @if(userCan('restrictions-manage', $shelf))
                <a href="{{ $shelf->getUrl('/permissions') }}" data-shortcut="permissions" class="icon-list-item">
                    <span>@icon('lock')</span>
                    <span>{{ trans('entities.permissions') }}</span>
                </a>
            @endif

            @if(userCan('bookshelf-delete', $shelf))
                <a href="{{ $shelf->getUrl('/delete') }}" data-shortcut="delete" class="icon-list-item">
                    <span>@icon('delete')</span>
                    <span>{{ trans('common.delete') }}</span>
                </a>
            @endif

            @if(!user()->isGuest())
                <hr class="primary-background">
                @include('entities.favourite-action', ['entity' => $shelf])
            @endif

        </div>
    </div>
@stop




