@php
    $gateways_list = \App\Models\Gateway::where('status',true)->pluck('logo','name')->chunk(6);
@endphp

<!-- Brand area start -->
<div class="section brand-area section-space include-bg" data-background="{{ asset('/') }}/front/images/bg/brand-bg.png">
    <div class="container">
        <div class="row">
            <div data-aos="fade-up" data-aos-duration="1500" class="brand-main-wrapper">
                @foreach ($gateways_list as $gateways)
                <div class="brand-grid">
                    @foreach($gateways as $name => $logo)
                    <div class="brand-item">
                        <div class="thumb">
                            <img src="{{ asset($logo) }}" alt="thumb not found">
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Brand area end -->
