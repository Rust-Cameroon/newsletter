@can('view-dps-details')
<span type="button" id="action">
    <a href="{{ route('admin.dps.details', $id) }}" class="round-icon-btn red-btn" data-bs-toggle="tooltip" title="View Details" data-bs-original-title="View Details">
        <i data-lucide="eye"></i>
    </a>
</span>
@endcan

