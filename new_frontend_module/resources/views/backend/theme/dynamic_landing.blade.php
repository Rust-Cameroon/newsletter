@extends('backend.theme.index')
@section('theme-title')
    {{ __('Dynamic Landing Theme') }}
@endsection
@section('theme-content')
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="site-card">
            <div class="site-card-header">
                <h3 class="title">{{ __('Dynamic Landing Theme') }}</h3>
                <form action="{{ route('admin.theme.dynamic-landing-update') }}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card-header-links">
                        <div class="card-header-links new-referral">
                            <div class="input-group joint-input">
                                <input type="file" placeholder="hfh" name="theme_file" class="form-control" required/>
                                <button type="submit" class="input-group-text"><i data-lucide="upload-cloud"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="site-card-body">
                <p class="paragraph">
                    <i data-lucide="info"></i>{{ __('You can upload your own HTML template here as a website Home page and other pages. You need to add ') }}
                    <strong> @@lasset('landing asset')</strong> {{  __(' for any assets support on the theme') }}
                </p>
                @foreach($landingThemes as $theme)
                    <div class="single-gateway">
                        <div class="gateway-name">
                            <div class="gateway-icon">
                                <i data-lucide="feather"></i>
                            </div>
                            <div class="gateway-title">
                                <h4>{{ $theme->name }}</h4>
                            </div>
                        </div>
                        <div class="gateway-right">
                            <div class="gateway-status">
                                <div class="switch-field mb-0">
                                    <input
                                        type="radio"
                                        id="theme-status{{ $theme->id }}"
                                        class="theme-status"
                                        name="status{{ $theme->id }}"
                                        value="1"
                                        data-id="{{ $theme->id }}"
                                        @if($theme->status) checked @endif
                                    />
                                    <label for="theme-status{{ $theme->id }}">{{ __('Active') }}</label>
                                    <input
                                        type="radio"
                                        id="theme-status-no{{ $theme->id }}"
                                        name="status{{ $theme->id }}"
                                        class="theme-status"
                                        value="0"
                                        data-id="{{ $theme->id }}"
                                        @if(!$theme->status) checked @endif

                                    />
                                    <label for="theme-status-no{{ $theme->id }}">{{ __('DeActive') }}</label>
                                </div>

                            </div>
                            <div class="gateway-edit">
                                <button type="button" data-id="{{ $theme->id }}"
                                        data-name="{{ $theme->name }}"
                                        class="round-icon-btn red-btn deleteLandingTheme">
                                    <i data-lucide="trash-2"></i> {{ __('Delete') }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <!-- Modal for Delete Theme Lending -->
    <div
        class="modal fade"
        id="deleteLandingTheme"
        tabindex="-1"
        aria-labelledby="deleteLandingThemeModalLabel"
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
                    <div class="popup-body-text centered">
                        <form method="post" id="themeLandingDeleteForm">
                            @csrf
                            <div class="info-icon">
                                <i data-lucide="alert-triangle"></i>
                            </div>
                            <div class="title">
                                <h4>{{ __('Are you sure?') }}</h4>
                            </div>
                            <p>
                                {{ __('You want to Delete') }} <strong
                                    class="name"></strong> {{ __('landing Theme?') }}
                            </p>
                            <div class="action-btns">
                                <button type="submit" class="site-btn-sm primary-btn me-2">
                                    <i data-lucide="check"></i>
                                    {{ __(' Confirm') }}
                                </button>
                                <a href="" class="site-btn-sm red-btn" type="button"
                                   class="btn-close"
                                   data-bs-dismiss="modal"
                                   aria-label="Close">
                                    <i data-lucide="x"></i>
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Delete Plugin-->
@endsection
@section('script')

    <script>
        $('.theme-status').on('click', function (e) {
            "use strict"
            var id = $(this).data('id');
            var status = parseInt($(this).val());
            var url = '{{ route("admin.theme.status-update") }}';
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    var oldStatus = data.old_status
                    for (var i = 0; i < oldStatus.length; i++) {
                        $('#theme-status' + oldStatus[i]).prop('checked', false);
                        $('#theme-status-no' + oldStatus[i]).prop('checked', true);

                    }
                    tNotify('success', data.message);
                }
            });


        })


        $('.deleteLandingTheme').on('click', function (e) {
            "use strict";
            e.preventDefault();
            var id = $(this).data('id');
            var name = $(this).data('name');

            var url = '{{ route("admin.theme.dynamic-landing-delete", ":id") }}';
            url = url.replace(':id', id);
            $('#themeLandingDeleteForm').attr('action', url)

            $('.name').html(name);
            $('#deleteLandingTheme').modal('show');
        })

    </script>

@endsection
