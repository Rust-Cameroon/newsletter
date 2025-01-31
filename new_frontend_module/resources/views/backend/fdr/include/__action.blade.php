@can('view-fdr-details')
<span type="button" id="action">
    <a href="{{ route('admin.fdr.details', $id) }}" class="round-icon-btn red-btn" data-bs-toggle="tooltip" title="View Details" data-bs-original-title="View Details">
        <i data-lucide="eye"></i>
    </a>
</span>
@endcan

