@if(null != $avatar)
    <img class="avatar avatar-round" src="{{ asset($avatar)}}" alt="" height="40" width="40">
@else
    <span class="avatar-text">{{ $first_name[0] }}{{ $last_name[0] }}</span>
@endif
