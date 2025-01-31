@can('customer-mail-send')
    <span type="button"
          data-id="{{$user->id}}"
          data-name="{{ $user->first_name.' '. $user->last_name }}"
          class="send-mail"
    ><button class="round-icon-btn blue-btn" data-bs-toggle="tooltip" title="Send Email"
             data-bs-original-title="Send Email"><i data-lucide="mail"></i></button></span>
@endcan
@canany(['customer-basic-manage','customer-balance-add-or-subtract','customer-change-password','all-type-status'])
    <a href="{{route('admin.user.edit',$user->id)}}" class="round-icon-btn primary-btn" data-bs-toggle="tooltip"
       title="Edit User" data-bs-original-title="Edit User"><i data-lucide="edit-3"></i></a>
    <span type="button" id="deleteModal" data-id="{{$user->id}}" data-name="{{$user->name}}">
        <button class="round-icon-btn red-btn" data-bs-toggle="tooltip" title="Delete User"
            data-bs-original-title="Delete User">
            <i data-lucide="trash-2"></i></button>
    </span>

    <!-- Modal for Popup Box -->
    @include('backend.user.include.__delete_popup')
    <!-- Modal for Popup Box End-->
@endcanany



