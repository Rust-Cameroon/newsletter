<h3 class="title mb-4">
    {{ __('DPS Details') }}
</h3>

<div class="row">
    <div class="col-xl-6">
        <h5 class="fs-6 mb-2">
            {{ __('User Information') }}
        </h5>
        <ul class="list-group mb-4">
            <li class="list-group-item">
                {{ __('Username') }}:
                <strong>{{ $dps->user->username }}</strong>
            </li>
            <li class="list-group-item">
                {{ __('Name') }}:
                <strong>{{ $dps->user->full_name }}</strong>
            </li>
            <li class="list-group-item">
                {{ __('Country') }}:
                <strong>{{ $dps->user->country }}</strong>
            </li>
            <li class="list-group-item">
                {{ __('Phone') }}:
                <strong>{{ $dps->user->phone }}</strong>
            </li>
            <li class="list-group-item">
                {{ __('Balance') }}:
                <strong class="green-color">{{$dps->user->balance.' '.setting('currency_symbol', 'global') }}</strong>
            </li>
            <li class="list-group-item">
                {{ __('Status') }}:
                <strong>
                    {{ $dps->status->value}}
                </strong>
            </li>
        </ul>
    </div>
    <div class="col-xl-6">
        <h5 class="fs-6 mb-2">
            {{ __('Plan Information') }}
        </h5>
        <ul class="list-group mb-4">
            <li class="list-group-item">
                {{ __('Name') }}:
                <strong>{{ $dps->plan->name }}</strong>
            </li>
            <li class="list-group-item">
                {{ __('Interval') }}:
                <strong>{{ $dps->plan->interval }} {{ __('Days') }}</strong>
            </li>
            <li class="list-group-item">
                {{ __('Total Installment') }}:
                <strong>{{ $dps->plan->total_installment }} {{ __('Times') }}</strong>
            </li>
            <li class="list-group-item">
                {{ __('Per Installment') }}:
                <strong>{{ $dps->plan->per_installment.''.setting('currency_symbol', 'global') }}</strong>
            </li>
            <li class="list-group-item">
                {{ __('Total Deposit') }}:
                <strong>{{ $dps->plan->total_deposit.''.setting('currency_symbol', 'global') }}</strong>
            </li>
            <li class="list-group-item">
                {{ __('Mature Amount') }}:
                <strong>{{ $dps->plan->total_mature_amount.''.setting('currency_symbol', 'global') }}</strong>
            </li>
        </ul>
    </div>
</div>
