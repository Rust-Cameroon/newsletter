<div class="hv-item">
    <div class="hv-item-parent">
        <div class="person">
            @if(null != $levelUser->avatar)
                <img src="{{ asset($levelUser->avatar)}}">
            @else
                <div class="f-name-l-name">{{ $levelUser->first_name[0] }}{{ $levelUser->last_name[0] }}</div>
            @endif
            <p class="name">
                @if($me)
                    {{ __("It's Me") }}( {{ $levelUser->full_name }} )
                @else
                    <b>
                        {{ $levelUser->full_name }}
                    </b>
                @endif

            </p>
        </div>
    </div>



    @if($depth && $level >= $depth && $levelUser->referrals->count() > 0)

        <div class="hv-item-children">

            @foreach($levelUser->referrals as $levelUser)
                <div class="hv-item-child">
                    <!-- Key component -->
                    @include('frontend::referral.include.__tree',['levelUser' => $levelUser,'level' => $level,'depth' => $depth + 1,'me' => false])
                </div>
            @endforeach

        </div>

    @endif


</div>


