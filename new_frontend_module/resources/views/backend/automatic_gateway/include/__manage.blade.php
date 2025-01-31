<div
    class="modal fade"
    id="manage-{{$gateway->id}}"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize">{{$gateway->gateway_code . __(' Credential Edit')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form action="{{ route('admin.gateway.update',$gateway->id) }}"
                          class="row" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-12">
                                    <div class="site-input-groups mb-0">
                                        <label class="box-input-label" for="">{{ __('Upload Logo:') }}</label>
                                        <div class="wrap-custom-file">
                                            <input type="file" name="logo" id="schema-icon" accept=".gif, .jpg, .png"/>
                                            <label for="schema-icon" class="file-ok" style="background-image: url({{ asset($gateway->logo) }})">
                                                <img class="upload-icon" src="{{ asset('global/materials/upload.svg') }}" alt=""/>
                                                <span>{{ __('Update Logo') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12">
                            <div class="site-input-groups mb-0">
                                <label class="box-input-label" for="">{{ __('Name:') }}</label>
                                <input type="text" class="box-input" name="name" value="{{ $gateway->name }}"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12">
                            <div class="site-input-groups mb-0">
                                <label class="box-input-label" for="">{{ __('Code Name:') }}</label>
                                <input type="text" class="box-input" disabled value="{{$gateway->gateway_code}}"/>
                            </div>
                        </div>

                        @foreach(json_decode($gateway->credentials) as $key => $value)
                            <div class="col-xl-12">
                                <div class="site-input-groups mb-0">
                                    <label class="box-input-label" for="">{{ ucwords(str_replace( '_', ' ', $key)) }} :</label>
                                    <input type="text" name="credentials[{{ $key }}] " class="box-input" value="{{ $value }}"/>
                                </div>
                            </div>
                        @endforeach


                        <div class="col-xl-12">
                            <div class="site-input-groups mb-0">
                                <label class="box-input-label"
                                    for="">{{ __('Status:') }}</label>
                                <div class="switch-field same-type">
                                    <input
                                        type="radio"
                                        id="status-enable-{{$gateway->id}}"
                                        name="status"
                                        value="1"
                                        @if($gateway->status) checked @endif
                                    />
                                    <label
                                        for="status-enable-{{$gateway->id}}">{{ __('Active') }}</label>
                                    <input
                                        type="radio"
                                        id="status-disable-{{$gateway->id}}"
                                        name="status"
                                        value="0"
                                        @if(!$gateway->status) checked @endif
                                    />
                                    <label
                                        for="status-disable-{{$gateway->id}}">{{ __('Deactivate') }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <button type="submit" class="site-btn primary-btn w-100">
                                {{ __('Save Changes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
