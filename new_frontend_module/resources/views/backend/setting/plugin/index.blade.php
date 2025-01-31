@extends('backend.setting.index')
@section('setting-title')
    {{ __('Plugin Settings') }}
@endsection
@section('title')
    {{ __('Plugin Settings') }}
@endsection
@section('setting-content')
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="site-card">
            <div class="site-card-header">
                <h3 class="title">{{ $title }}</h3>
                @if($isLink)
                    <div class="card-header-links">
                        <a href="{{ route('admin.settings.notification.tune') }}" class="card-header-link new-referral"
                           type="button" data-type="investment">
                            <i data-lucide="volume-1"></i>{{ __('Set Tune') }}</a>
                    </div>

                @endif

            </div>
            <div class="site-card-body">
                <p class="paragraph">
                    <i data-lucide="info"></i>{{ __('You can') }}
                    <strong>{{ __('Enable or Disable') }}</strong> {{ __('any of the plugin') }}
                </p>
                @foreach($plugins as $plugin)
                    <div class="single-gateway">
                        <div class="gateway-name">
                            <div class="gateway-icon">
                                <img
                                    src="{{ asset($plugin->icon) }}" alt=""/>
                            </div>
                            <div class="gateway-title">
                                <h4>{{ $plugin->name }}</h4>
                                <p>{{ $plugin->description }}</p>
                            </div>
                        </div>
                        <div class="gateway-right">
                            <div class="gateway-status">
                                @if($plugin->status)
                                    <div class="site-badge success">{{ __('Activated') }}</div>
                                @else
                                    <div class="site-badge pending">{{ __('DeActivated') }}</div>
                                @endif
                            </div>
                            <div class="gateway-edit">
                                <a type="button" class="editPlugin" data-id="{{$plugin->id}}"><i
                                        data-lucide="settings-2"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <!-- Modal for Edit Plugin -->
    <div
        class="modal fade"
        id="editPlugin"
        tabindex="-1"
        aria-labelledby="editPluginModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content site-table-modal">
                <div class="modal-body popup-body">
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                    <div class="popup-body-text edit-plugin-section">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Edit Plugin-->
@endsection
@section('script')

    <script>
        $('.editPlugin').on('click', function (e) {
            "use strict"
            var id = $(this).data('id');
            $('.edit-plugin-section').empty();

            var url = '{{ route("admin.settings.plugin.data",":id") }}';
            url = url.replace(':id', id);
            $.get(url, function ($data) {
                $('.edit-plugin-section').append($data)
                // Lucide Icons Activation
                lucide.createIcons();

                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

                $('#editPlugin').modal('show');
            })

        })
    </script>

@endsection
