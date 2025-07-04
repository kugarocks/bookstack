@extends('layouts.base')

@push('body-class', 'tri-layout ')
@section('content-components', 'tri-layout')

@section('content')

    <div class="tri-layout-mobile-tabs print-hidden">
        @if(request()->is('books/*/page/*'))
            <div class="grid third no-break no-gap">
                <button type="button"
                        refs="tri-layout@tab"
                        data-tab="info"
                        aria-label="{{ trans('common.tab_info_label') }}"
                        class="tri-layout-mobile-tab px-m py-s text-link">
                    {{ trans('common.tab_info') }}
                </button>
                <button type="button"
                        refs="tri-layout@tab"
                        data-tab="nav"
                        aria-label="Navigation"
                        class="tri-layout-mobile-tab px-m py-s text-link">
                    Nav
                </button>
                <button type="button"
                        refs="tri-layout@tab"
                        data-tab="content"
                        aria-label="{{ trans('common.tab_content_label') }}"
                        aria-selected="true"
                        class="tri-layout-mobile-tab px-m py-s text-link active">
                    {{ trans('common.tab_content') }}
                </button>
            </div>
        @else
            <div class="grid half no-break no-gap">
                <button type="button"
                        refs="tri-layout@tab"
                        data-tab="info"
                        aria-label="{{ trans('common.tab_info_label') }}"
                        class="tri-layout-mobile-tab px-m py-s text-link">
                    {{ trans('common.tab_info') }}
                </button>
                <button type="button"
                        refs="tri-layout@tab"
                        data-tab="content"
                        aria-label="{{ trans('common.tab_content_label') }}"
                        aria-selected="true"
                        class="tri-layout-mobile-tab px-m py-s text-link active">
                    {{ trans('common.tab_content') }}
                </button>
            </div>
        @endif
    </div>

    <div refs="tri-layout@container" class="tri-layout-container" @yield('container-attrs') >

        <div class="tri-layout-sides print-hidden">
            <div class="tri-layout-sides-content">
                <div class="tri-layout-right print-hidden">
                    <aside class="tri-layout-right-contents">
                        @yield('right')
                    </aside>
                </div>

                <div class="tri-layout-left print-hidden" id="sidebar">
                    <aside class="tri-layout-left-contents">
                        @yield('left')
                        <div class="desktop-nav-content">
                            @yield('nav')
                        </div>
                    </aside>
                </div>

                <div class="tri-layout-nav print-hidden" id="navigation">
                    <aside class="tri-layout-nav-contents">
                        @yield('nav')
                    </aside>
                </div>
            </div>
        </div>

        <div class="@yield('body-wrap-classes') tri-layout-middle">
            <div id="main-content" class="tri-layout-middle-contents">
                @yield('body')
            </div>
        </div>
    </div>

@stop
