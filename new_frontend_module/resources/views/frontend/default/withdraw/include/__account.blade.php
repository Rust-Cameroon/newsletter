<div class="col-xl-6 col-md-12">
    <div class="inputs">
        <label for="" class="input-label"
        >{{ __('Method Name:') }}<span class="required"
            >*</span
            ></label
        >
        <div class="input-group">
            <input type="text" class="form-control" name="method_name" value="{{ $withdrawMethod->name .'-'. $withdrawMethod->currency}}" />
        </div>
    </div>
</div>



@foreach( json_decode($withdrawMethod->fields, true) as $key => $field)

    @if($field['type'] == 'file')

        <input type="hidden" name="credentials[{{ $field['name']}}][type]" value="{{ $field['type'] }}">
        <input type="hidden" name="credentials[{{ $field['name']}}][validation]" value="{{ $field['validation'] }}">

        <div class="col-xl-6 col-md-12">
            <div class="body-title">{{ $field['name'] }}</div>
            <div class="wrap-custom-file">
                <input
                    type="file"
                    name="credentials[{{ $field['name'] }}][value]"
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
    @elseif($field['type'] == 'textarea')
        <input type="hidden" name="credentials[{{ $field['name']}}][type]" value="{{ $field['type'] }}">
        <input type="hidden" name="credentials[{{ $field['name']}}][validation]" value="{{ $field['validation'] }}">

        <div class="col-xl-6 col-md-12">
            <label for="exampleFormControlInput1" class="form-label">{{ $field['name'] }}</label>
            <div class="input-group">
                <textarea class="form-control-textarea" @if($field['validation'] == 'required') required
                          @endif placeholder="Send Money Note" name="credentials[{{$field['name']}}][value]"></textarea>
            </div>
        </div>

    @else
        <input type="hidden" name="credentials[{{ $field['name']}}][type]" value="{{ $field['type'] }}">
        <input type="hidden" name="credentials[{{ $field['name']}}][validation]" value="{{ $field['validation'] }}">

        <div class="col-xl-6 col-md-12">

            <div class="inputs">
                <label for="" class="input-label"
                >{{ ucwords( str_replace('_',' ',$field['name']) ) }}<span class="required"
                    >*</span
                    ></label
                >
                <div class="input-group">
                    <input type="text" class="form-control" name="credentials[{{ $field['name']}}][value]" @if($field['validation'] == 'required') required @endif/>
                </div>
            </div>
        </div>
    @endif

@endforeach


