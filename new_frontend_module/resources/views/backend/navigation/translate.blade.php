@extends('backend.navigation.index')
@section('navigation_content')
    <div class="col-xl-12">
        <div class="d-flex align-items-start back-nav-tab">
            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                @foreach($languages as $language)
                    <button class="nav-link {{ $loop->index == 0 ?'active' : '' }}" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#{{$language->locale}}" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">{{ $language->name }}</button>
                @endforeach
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                @foreach($localeContent as $key => $value)

                <div class="tab-pane fade {{ $loop->index == 0 ?'show active' : '' }}"  id="{{$key}}" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="site-card">
                                <div class="site-card-header">
                                    <h3 class="title">@lang('Update For') {{  $navigation->name }}</h3>
                                </div>
                                <div class="site-card-body">
                                    <form action="{{ route('admin.navigation.translate.now') }}" method="post">
                                        @csrf

                                        <input type="hidden" name="id" value="{{ $navigation->id }}">
                                        <input type="hidden" name="locale" value="{{ $key }}">

                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Menu Name:') }}</label>
                                            <input type="text" name="name" value="{{ $value  }}" class="box-input mb-0" placeholder="Menu Name" required=""/>
                                        </div>

                                        <div class="action-btns">
                                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                                <i data-lucide="check"></i>
                                                {{ __('Update Translate') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

