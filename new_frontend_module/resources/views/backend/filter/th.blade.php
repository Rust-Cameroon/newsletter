
@php
$sort_dir = request('sort_dir') == 'asc' ? 'desc' : 'asc';
$sort_icon = $field == request('sort_field') && request('sort_dir') == 'asc' ? 'arrow-down-a-z' : 'arrow-down-z-a';
@endphp



<th>
    <a href="{{ request()->fullUrlWithQuery([
        'sort_field' => $field,
        'sort_dir' => $sort_dir
    ]) }}">
        {{ __($label) }}
        <i data-lucide="{{ $sort_icon }}"></i>
    </a>
</th>
