<div class="header">
    @php
        $height = setting('site_logo_height','global') == 'auto' ? 'auto' : setting('site_logo_height','global').'px';
        $width = setting('site_logo_width','global') == 'auto' ? 'auto' : setting('site_logo_width','global').'px';
    @endphp

    <div class="logo">
        <a href="{{ route('admin.dashboard') }}">
            <img
                class="logo-unfold"
                style="height:{{ $height }};width:{{ $width }}"
                src="{{asset(setting('site_logo','global'))}}"
                alt="{{ setting('site_title','global') }}"
            />
            <img
                class="logo-fold"
                src="{{asset(setting('site_favicon','global'))}}"
                alt="{{ setting('site_title','global') }}"
            />
        </a>
    </div>
    <div class="nav-wrap">
        <div class="nav-left">
            <button class="sidebar-toggle"><i data-lucide="align-justify"></i></button>
        </div>
        <div class="nav-right">
            @if(setting('language_switcher'))
            <div class="single-nav-right admin-language-switch">
                <select name="language" class="form-select"
                        onchange="window.location.href=this.options[this.selectedIndex].value;">
                    @foreach(\App\Models\Language::where('status',true)->get() as $lang)
                        <option
                            value="{{ route('language-update',['name'=> $lang->locale]) }}" @selected( app()->getLocale() == $lang->locale )>{{$lang->name}}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="single-nav-right admin-notifications">
                @php
                    $notifications = App\Models\Notification::with('user')->where('for','admin')->latest()->take(10)->get();
                    $totalUnread = App\Models\Notification::with('user')->where('for','admin')->where('read', 0)->count();
                    $totalCount = App\Models\Notification::with('user')->where('for','admin')->get()->count();
                @endphp
                @include('global.__notification_data',['notifications'=>$notifications,'totalUnread'=>$totalUnread,'totalCount'=>$totalCount])
            </div>


            <div class="single-nav-right">
                <a href="{{ route('home') }}" target="_blank" class="item" data-bs-toggle="tooltip" title=""
                   data-bs-placement="left" data-bs-original-title="Visit Landing Page">
                    <i data-lucide="globe"></i>
                </a>
            </div>
            <div class="single-nav-right">
                <button type="button" class="item" data-bs-toggle="dropdown" aria-expanded="false">
                    <i data-lucide="user"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a href="{{ route('admin.profile') }}" class="dropdown-item"><i
                                data-lucide="user"></i>{{ __('Profile') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.password-change') }}" class="dropdown-item">
                            <i data-lucide="lock"></i>{{ __('Change Password') }}
                        </a>
                    </li>
                    <li class="logout">

                        <a href="{{ url('admin/logout') }}" class="dropdown-item" type="button"
                           onclick="event.preventDefault(); localStorage.clear();  $('#logout-form').submit();">
                            <i data-lucide="log-out"></i> {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
