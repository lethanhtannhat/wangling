@php
    $sort = request('sort');
    $order = request('order', 'asc');
    $nextOrder = ($sort === $col && $order === 'asc') ? 'desc' : 'asc';
    $icon = 'bi-arrow-down-up text-muted opacity-25';

    if ($sort === $col) {
        $icon = $order === 'asc' ? 'bi-sort-up-alt text-primary' : 'bi-sort-down-alt text-primary';
    }

    $url = request()->fullUrlWithQuery(['sort' => $col, 'order' => $nextOrder]);
@endphp

<a href="{{ $url }}" class="text-decoration-none text-dark d-flex align-items-center gap-1">
    {{ $label }} <i class="bi {{ $icon }}"></i>
</a>