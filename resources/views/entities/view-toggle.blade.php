<div>
    <form action="{{ url("/preferences/change-view/" . $type) }}" method="POST" class="inline">
        {{ csrf_field() }}
        {{ method_field('patch') }}
        <input type="hidden" name="_return" value="{{ url()->current() }}">

        @php
            $viewModes = [
                'list' => [
                    'icon' => 'list',
                    'label' => 'common.list_view'
                ],
                'grid' => [
                    'icon' => 'grid',
                    'label' => 'common.grid_view'
                ],
                'tree' => [
                    'icon' => 'folder',
                    'label' => 'common.tree_view'
                ]
            ];

            $allowedViews = $allowedViews ?? ['grid', 'list', 'tree'];

            if (!in_array($view, $allowedViews)) {
                $view = $allowedViews[0];
            }

            // Find the current view in the allowed list and switch to the next
            $currentIndex = array_search($view, $allowedViews);
            $nextIndex = ($currentIndex + 1) % count($allowedViews);
            $nextView = $allowedViews[$nextIndex];
        @endphp

        <button type="submit" name="view" value="{{ $nextView }}" class="icon-list-item text-link">
            <span class="icon">@icon($viewModes[$nextView]['icon'])</span>
            <span>{{ trans($viewModes[$nextView]['label']) }}</span>
        </button>
    </form>
</div>