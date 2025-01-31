@php
$landingContent =\App\Models\LandingContent::where('type','howitworks')->where('locale',app()->getLocale())->get();
@endphp
<!-- how it work card area start -->
<Section class="how-it-work-area position-relative section-space">
    <div class="container">
        <div class="timeline-grid">
            @foreach ($landingContent as $content)
            <div class="timeline-item">
                <div class="content">
                    <h3 class="title">{{ $content->title }}</h3>
                    <p class="description">{{ $content->description }}</p>
                </div>
                <div class="timeline-count">
                    <span class="number">{{ $loop->iteration }}</span>
                </div>
                <div class="timeline-thumb">
                    <img src="{{ asset($content->icon) }}" alt="img not found">
                </div>
            </div>
            @endforeach
        </div>
    </div>
</Section>
<!-- how it work  card area end -->
