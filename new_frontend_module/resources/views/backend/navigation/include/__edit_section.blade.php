<form action="{{ route('admin.navigation.menu.update') }}" method="post">
    @csrf
    <input type="hidden" name="id" id="manuId" value="{{ $navigation->id }}">
    <h3 class="title mb-4">{{ __('Update Menu Item') }}</h3>
    <div class="site-input-groups">
        <label for="" class="box-input-label">{{ __('Menu Name:') }}</label>
        <input type="text" name="name" class="box-input mb-0 name" placeholder="Menu Name"
               value="{{ $navigation->name }}" required=""/>
    </div>
    <div class="site-input-groups">
        <label for="" class="box-input-label">{{ __('Page:') }}</label>
        <select name="select_page" class="form-select edit-page-select">
            <option value="">--{{ __('Select One') }}--</option>
            @foreach($pages as $page)
                <option
                    @selected( $page->id == $navigation->page_id ) value="{{ $page->id }}">{{ $page->title }}</option>
            @endforeach
            <option value="custom" @selected( $navigation->page_id == null ) >{{ __('Custom Url') }}</option>

        </select>
    </div>
    <div class="site-input-groups edit-custom-url-input @if($navigation->page_id) hidden @endif">
        <label for="" class="box-input-label">{{ __('Custom URL:') }}</label>
        <input type="text" name="custom_url" class="box-input mb-0 custom-url" placeholder="Custom URL"
               value="{{ $navigation->url }}"/>
    </div>

    <div class="site-input-groups">
        <label for="" class="box-input-label">{{ __('Display In:') }}</label>
        <select name="type" class="form-select type">
            <option
                value="header" @selected( $navigation->type == \App\Enums\NavigationType::Header->value )>{{ __('Header') }}</option>
            <option
                value="footer" @selected( $navigation->type == \App\Enums\NavigationType::Footer->value )>{{ __('Footer') }}</option>
            <option
                value="both" @selected( $navigation->type == \App\Enums\NavigationType::Both->value )>{{ __('Header and Footer Both') }}</option>
        </select>
    </div>

    <div class="site-input-groups">
        <label class="box-input-label" for="">{{ __('Status:') }}</label>
        <div class="switch-field">
            <input type="radio" id="active{{$navigation->id}}" name="status" @checked( $navigation->status) value="1">
            <label for="active{{$navigation->id}}">{{ __('Active') }}</label>
            <input type="radio" id="disabled{{$navigation->id}}" name="status"
                   @checked(!$navigation->status ) value="0">
            <label for="disabled{{$navigation->id}}">{{ __('Disabled') }}</label>
        </div>
    </div>

    <div class="action-btns">
        <button type="submit" class="site-btn-sm primary-btn me-2">
            <i data-lucide="check"></i>
            {{ __('Update Menu') }}
        </button>
        <a href="#" class="site-btn-sm red-btn" data-bs-dismiss="modal">
            <i data-lucide="x"></i>
            {{ __('Close') }}
        </a>
    </div>
</form>
