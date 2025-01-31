@canany(['branch-staff-edit'])
    <a href="{{route('admin.branch-staff.edit',$staff->id)}}" class="round-icon-btn primary-btn" data-bs-toggle="tooltip"
       title="Edit" data-bs-original-title="Edit"><i data-lucide="edit-3"></i></a>
    <span type="button" id="deleteModal" data-id="{{$staff->id}}" data-name="{{$staff->name}}">
      <button class="round-icon-btn red-btn" data-bs-toggle="tooltip" title="Delete"
         data-bs-original-title="Delete">
         <i data-lucide="trash-2"></i></button>
   </span>

    <!-- Modal for Popup Box -->
    @include('backend.branch-staff.include.__delete_popup')
    <!-- Modal for Popup Box End-->
@endcanany



