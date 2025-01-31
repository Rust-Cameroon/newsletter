@extends('backend.setting.index')
@section('setting-title')
    {{ __('Site Settings') }}
@endsection
@section('title')
    {{ __('Site Settings') }}
@endsection
@section('setting-content')

    @foreach(config('setting') as $section => $fields)

        @includeIf('backend.setting.site_setting.include.__'. $section)

    @endforeach
@endsection
@push('single-script')
    <script>
    (function($) {
        'use strict';

        var timezoneData = JSON.parse(@json(getJsonData('timeZone')));
        const convertedData = timezoneData.map(item => ({
            id: item.name,
            text: `${item.description} (${item.name})`
        }));

        $('.site-timezone').select2({
            data: convertedData
        });

        // Account Deactivation Functionality
        function toggleElementsVisibility() {
            var inactiveAccountDisabledValue = $('input[name="inactive_account_disabled"]:checked').val();

            // Check the value and show/hide elements accordingly
            if (inactiveAccountDisabledValue == 1) {
                $('#inactive_days_sec').show();
                $('#inactive_account_fees_sec').show();
                toggleFeesAmountVisibility();
            } else {
                $('#inactive_days_sec').hide();
                $('#inactive_account_fees_sec').hide();
                $("#fees_amount_sec").hide();
            }
        }

        function toggleFeesAmountVisibility()
        {
            var inactive_account_fees = $('input[name="inactive_account_fees"]:checked').val();

            if (inactive_account_fees == 1) {
                $('#fees_amount_sec').show();
            } else {
                $('#fees_amount_sec').hide();
            }
        }

        // Initial toggle on page load
        toggleElementsVisibility();
        toggleFeesAmountVisibility();

        $('input[name="inactive_account_disabled"]').on('change', function () {
            toggleElementsVisibility();
        });

        $('input[name="inactive_account_fees"]').on('change', function () {
            toggleFeesAmountVisibility();
        });
    })(jQuery);
    </script>
@endpush
