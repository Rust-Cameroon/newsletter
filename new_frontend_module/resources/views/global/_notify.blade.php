
@if(session('notify'))
@php
    $notification = session('notify');
    $icon = $notification['type'] == 'success' ? 'check' : 'alert-triangle';
@endphp
<div class="admin-toaster">
    <div class="icon {{ $notification['type'] }}"><i data-lucide="{{ $icon }}"></i></div>
    <div class="contents">
      <h4>{{ ucfirst($notification['title']) }}</h4>
      <p>{{ $notification['message'] }}</p>
    </div>
    <button class="close" id="notify-dismiss"><i data-lucide="x"></i></button>
</div>
@endif
