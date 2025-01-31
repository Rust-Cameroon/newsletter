
@canany(['branch-edit','branch-delete'])
    @can('branch-edit')
    <a href="{{route('admin.branch.edit',$branch->id)}}" class="round-icon-btn primary-btn" data-bs-toggle="tooltip"
       title="Edit" data-bs-original-title="Edit"><i data-lucide="edit-3"></i></a>
    @endcan
    @can('branch-delete')
    <span type="button" id="deleteModal" data-id="{{$branch->id}}" data-name="{{$branch->name}}">
      <button class="round-icon-btn red-btn" data-bs-toggle="tooltip" title="Delete"
         data-bs-original-title="Delete">
         <i data-lucide="trash-2"></i></button>
   </span>
   @endcan

    <!-- Modal for Popup Box -->
    @include('backend.branch.include.__delete_popup')
    <!-- Modal for Popup Box End-->
@endcanany



