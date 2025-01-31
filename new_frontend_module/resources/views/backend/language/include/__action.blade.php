<a href="{{ route('admin.language-keyword',$locale) }}" class="round-icon-btn blue-btn" data-bs-toggle="tooltip"
   title="" data-bs-original-title="Change Value"><i data-lucide="languages"></i></a>

    <a href="{{ route('admin.language.edit',$id) }}" class="round-icon-btn primary-btn" data-bs-toggle="tooltip"
       title="" data-bs-original-title="Edit Language"><i data-lucide="edit-3"></i></a>
@if($locale != 'en' && !$is_default)
    <span type="button" id="deleteLanguageModal" data-id="{{$id}}" data-name="{{$name}}">
    <button class="round-icon-btn red-btn" data-bs-toggle="tooltip" title="Delete Language"
            data-bs-original-title="Delete Language">
        <i data-lucide="trash-2"></i></button>
</span>
@endif
