<div class="col-xl-12 col-md-12">
    <div class="frontend-editor-data">
        {!! $paymentDetails !!}
    </div>
</div>
@foreach( json_decode($fieldOptions, true) as $key => $field)

    @if($field['type'] == 'file')
        <div class="col-xl-12 col-md-12">
            <div class="inputs">
                <div class="body-title">{{ $field['name'] }}</div>
                <div class="wrap-custom-file">
                    <input
                        type="file"
                        name="manual_data[{{$field['name']}}]"
                        id="{{ $key }}"
                        accept=".gif, .jpg, .png"
                        @if($field['validation'] == 'required') required @endif
                    />
                    <label for="{{ $key }}">
                        <img
                            class="upload-icon"
                            src="{{ asset('global/materials/upload.svg') }}"
                            alt=""
                        />
                        <span>{{ __('Select '). $field['name'] }}</span>
                    </label>
                </div>
            </div>
        </div>
    @elseif($field['type'] == 'textarea')
        <div class="col-xl-12 col-md-12">
            <div class="inputs">
                <label for="exampleFormControlInput1" class="form-label">{{ $field['name'] }}</label>
                <div class="input-group">
                    <textarea class="form-control-textarea" @if($field['validation'] == 'required') required
                              @endif placeholder="Send Money Note" name="manual_data[{{$field['name']}}]"></textarea>
                </div>
            </div>
        </div>
    @else
        <div class="col-xl-12 col-md-12">
            <div class="inputs">
                <label for="exampleFormControlInput1" class="form-label">{{ $field['name'] }}</label>
                <div class="input-group">
                    <input type="text" name="manual_data[{{$field['name']}}]"
                           @if($field['validation'] == 'required') required @endif class="form-control"
                           aria-label="Amount" id="amount" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
    @endif

@endforeach

