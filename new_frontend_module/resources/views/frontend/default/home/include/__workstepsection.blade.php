@php
    $landingContent =\App\Models\LandingContent::where('type','workstepsection')->where('locale',app()->getLocale())->get();
@endphp

<!-- Work step area start -->
<section class="work-step-area section-space">
    <div class="container">
        <div class="work-step-grid">
            @foreach ($landingContent as $content)
            <div class="item">
                <div class="icon">
                    <span>
                        <img src="{{ asset($content->icon) }}" alt="step icon not found">
                    </span>
                </div>
                <div class="content">
                    <h3 class="title">{{ $content->title }}</h3>
                </div>
                <div class="arrow-line">
                    <svg width="175" height="21" viewBox="0 0 175 21" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M168.143 16.8367L172.878 7.85717L163.899 3.12235" stroke="#747373"
                            stroke-opacity="0.5" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path class="line-dash-path"
                            d="M0.999425 12.2663C11.4911 4.49184 43.4295 -6.39242 87.2493 12.2663C102.374 17.2521 139.922 26.7624 171.553 8.03699"
                            stroke="#747373" stroke-opacity="0.5" stroke-width="2.5" stroke-dasharray="5 5" />
                    </svg>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Work step area end -->
