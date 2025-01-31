@can('others-bank-edit')
<a href="{{route('admin.others-bank.edit',$id)}}" class="round-icon-btn primary-btn" data-bs-toggle="tooltip"
title="Edit Others Bank" data-bs-original-title="Edit Others Bank"><i data-lucide="edit-3"></i></a>
@endcan

@can('others-bank-delete')
<span type="button" id="deletePopUp" data-id="{{$id}}" data-name="{{$name}}">
<button class="round-icon-btn red-btn" data-bs-toggle="tooltip" title="Delete"
  data-bs-original-title="Delete">
  <i data-lucide="trash-2"></i>
</button>
@endcan