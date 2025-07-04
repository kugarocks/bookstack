@extends('layouts.tri')

@section('body')
    <div class="mb-s print-hidden">
        @include('entities.breadcrumbs', ['crumbs' => [
            '/shelves' => [
                'text' => trans('entities.shelves'),
                'icon' => 'bookshelf',
                'class' => 'text-bookshelf',
            ],
            '/books' => [
                'text' => trans('entities.books'),
                'icon' => 'books',
                'class' => 'text-book',
            ]
        ]])
    </div>

    @include('shelves.parts.list', ['shelves' => $shelves, 'view' => $view, 'listOptions' => $listOptions])
@stop

@section('right')

    <div class="actions mb-xl">
        <h5>{{ trans('common.actions') }}</h5>
        <div class="icon-list text-link">
            @if(userCan('bookshelf-create-all'))
                <a href="{{ url("/create-shelf") }}" data-shortcut="new" class="icon-list-item">
                    <span>@icon('add')</span>
                    <span>{{ trans('entities.shelves_new_action') }}</span>
                </a>
            @endif

            @include('entities.view-toggle', ['view' => $view, 'type' => 'bookshelves'])

            <a href="{{ url('/tags') }}" class="icon-list-item">
                <span>@icon('tag')</span>
                <span>{{ trans('entities.tags_view_tags') }}</span>
            </a>
        </div>
    </div>

@stop

@section('left')
    @if($recents)
        <div id="recents" class="mb-xl">
            <h5>{{ trans('entities.recently_viewed') }}</h5>
            @include('entities.list', ['entities' => $recents, 'style' => 'compact'])
        </div>
    @endif

    <div id="popular" class="mb-xl">
        <h5>{{ trans('entities.shelves_popular') }}</h5>
        @if(count($popular) > 0)
            @include('entities.list', ['entities' => $popular, 'style' => 'compact'])
        @else
            <p class="text-muted pb-l mb-none">{{ trans('entities.shelves_popular_empty') }}</p>
        @endif
    </div>

    <div id="new" class="mb-xl">
        <h5>{{ trans('entities.shelves_new') }}</h5>
        @if(count($new) > 0)
            @include('entities.list', ['entities' => $new, 'style' => 'compact'])
        @else
            <p class="text-muted pb-l mb-none">{{ trans('entities.shelves_new_empty') }}</p>
        @endif
    </div>
@stop