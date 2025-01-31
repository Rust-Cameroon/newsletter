@extends('backend.withdraw.index')
@section('title')
    {{ __('Withdraw Schedule') }}
@endsection
@section('withdraw_content')
    <div class="col-xl-7 col-md-12">
        <div class="site-card">
            <div class="site-card-header">
                <h3 class="title">{{ __('Withdraw Schedule') }}</h3>
            </div>
            <div class="site-card-body">
                <form action="{{ route('admin.withdraw.schedule.update') }}" method="post">
                    @csrf

                    <div class="site-input-groups row">
                        @forelse($schedules as $schedule)
                            <div class="col-sm-4 col-label pt-0">{{ $schedule->name }}</div>
                            <div class="col-sm-8">
                                <div class="form-switch ps-0">
                                    <div class="switch-field">
                                        <input
                                            type="radio"
                                            id="active-{{$schedule->id}}"
                                            name="{{$schedule->name}}"
                                            value="1"
                                            @if($schedule->status) checked @endif
                                        />
                                        <label for="active-{{$schedule->id}}">{{ __('Enable') }}</label>
                                        <input
                                            type="radio"
                                            id="disable-{{$schedule->id}}"
                                            name="{{$schedule->name}}"
                                            value="0"
                                            @if(!$schedule->status) checked @endif
                                        />
                                        <label for="disable-{{$schedule->id}}">{{ __('Disabled') }}</label>
                                    </div>
                                </div>
                            </div>
                        @empty
                        <div class="text-center">{{ __('No Data Found!') }}</div>
                        @endforelse

                    </div>

                    <div class="row">
                        <div class="offset-sm-4 col-sm-8">
                            <button
                                type="submit"
                                class="site-btn-sm primary-btn w-100">
                                {{ __('Save Changes') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
