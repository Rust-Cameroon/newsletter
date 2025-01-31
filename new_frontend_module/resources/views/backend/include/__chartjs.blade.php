<script>
    (function ($) {
        'use strict';

        //site chart
        let chart;

        $('input[name="site_daterange"]').daterangepicker({
            opens: 'left'
        }, function(start,end) {

            $.get('{{ route('admin.dashboard') }}?type=site', {
                start_date: start.format('YYYY-MM-DD'),
                end_date: end.format('YYYY-MM-DD')
            }, function (chartData) {
                chart.destroy();
                siteStatisticsChart(chartData);
            });
        });

        function siteStatisticsChart(chartData){

            var date_label =  Object.keys(chartData['date_label']);
            var deposit_data = Object.values(chartData['deposit_statistics']);
            var withdraw_data = Object.values(chartData['withdraw_statistics']);
            var total_dps = Object.values(chartData['total_dps']);
            var total_fdr = Object.values(chartData['total_fdr']);
            var total_loan = Object.values(chartData['total_loan']);
            var total_bill = Object.values(chartData['total_bill']);
            var symbol = chartData['symbol'];

            // Bar Chart
            var data = {
                labels: date_label,
                datasets: [
                    {
                        label: 'Total Deposit '+symbol+sumArrayValues(deposit_data),
                        data: deposit_data,
                        backgroundColor: '#ef476f',
                        borderColor: '#ffffff',
                        borderWidth: 0,
                        borderRadius: 90,
                        tension: 0.1
                    },
                    {
                        label: 'Total DPS '+symbol+sumArrayValues(total_dps),
                        data: total_dps,
                        backgroundColor: '#2F3E46',
                        borderColor: '#ffffff',
                        borderWidth: 0,
                        borderRadius: 90,
                        tension: 0.1
                    },
                    {
                        label: 'Total FDR '+symbol+sumArrayValues(total_fdr),
                        data: total_fdr,
                        backgroundColor: '#619B8A',
                        borderColor: '#ffffff',
                        borderWidth: 0,
                        borderRadius: 90,
                        tension: 0.1
                    },
                    {
                        label: 'Total Loan '+symbol+sumArrayValues(total_loan),
                        data: total_loan,
                        backgroundColor: '#6F2DBD',
                        borderColor: '#ffffff',
                        borderWidth: 0,
                        borderRadius: 90,
                        tension: 0.1
                    },
                    {
                        label: 'Total Bill '+symbol+sumArrayValues(total_bill),
                        data: total_bill,
                        backgroundColor: '#41658A',
                        borderColor: '#ffffff',
                        borderWidth: 0,
                        borderRadius: 90,
                        tension: 0.1
                    },
                    {
                        label: 'Total Withdraw '+symbol+sumArrayValues(withdraw_data),
                        data:  withdraw_data,
                        backgroundColor: '#718355',
                        borderColor: '#ffffff',
                        borderWidth: 0,
                        borderRadius: 90,
                        tension: 0.1
                    },
                ]
            };
            // render init block


            var ctx = document.getElementById('statisticsChart');
            var configuration = {
                type: 'bar',
                data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return (context.dataset.label.split(symbol)[0]).split(' ')[1] + ': ' +symbol+ context.formattedValue;
                                }
                            }
                        }
                    }
                }
            }

            if (chart) {
                chart.destroy();
                chart = new Chart(ctx, configuration);
            } else {
                chart = new Chart(ctx, configuration);
            }
        }

        var chartData = {
            'date_label':@json($data['date_label']),
            'deposit_statistics':@json($data['deposit_statistics']),
            'withdraw_statistics':@json($data['withdraw_statistics']),
            'total_dps':@json($data['dps_statistics']),
            'total_fdr':@json($data['fdr_statistics']),
            'total_loan':@json($data['loan_statistics']),
            'total_bill':@json($data['bill_statistics']),
            'symbol': @json($data['symbol']),
        };


        siteStatisticsChart(chartData);

        // Fund Transfer Chart
        var fund_transfer_log = @json($data['fund_transfer_statistics']);
        var fund_transfer_data = Object.values(fund_transfer_log);
        var fund_transfer_label = Object.keys(fund_transfer_log);

        var data = {
            labels: fund_transfer_label,
            datasets: [{
                data: fund_transfer_data,
                backgroundColor: [
                    '#5e3fc9',
                    '#2a9d8f',
                ],
                borderColor: [
                    '#ffffff',
                    '#ffffff',
                ],
                borderWidth: 3,
                borderRadius: 12,
                barPercentage: 0.3,
                hoverBackgroundColor: '#003566',
            }]
        };
        // render init block
        new Chart(
            document.getElementById('fundTransferChart'),
            {
                type: 'doughnut',
                data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            }
        );

        // Country Chart
        var country = @json($data['country']);
        var country_data = Object.values(country);
        var country_label = Object.keys(country);
        var data = {
            labels: country_label,
            datasets: [{
                label: 'Country',
                data: country_data,
                backgroundColor: [
                    '#5e3fc9',
                    '#2a9d8f',
                    '#ef476f',
                    '#718355',
                    '#ee6c4d',
                    '#6d597a',
                    '#003566',
                    "#b91d47",
                    "#00aba9",
                    "#2b5797",
                    "#e8c3b9",
                    "#1e7145"
                ],
                borderColor: [
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff'
                ],
                borderWidth: 3,
                borderRadius: 12,
                barPercentage: 0.3,
                hoverBackgroundColor: '#003566',
            }]
        };
        // render init block
        new Chart(
            document.getElementById('countryChart'),
            {
                type: 'doughnut',
                data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            }
        );

        // Browser Chart
        var browser = @json($data['browser']);
        var browser_data = Object.values(browser);
        var browser_label = Object.keys(browser);
        var data = {
            labels: browser_label,
            datasets: [{
                label: 'Browser',
                data: browser_data,
                backgroundColor: [
                    '#5e3fc9',
                    '#2a9d8f',
                    '#ef476f',
                    '#718355',
                    '#ee6c4d',
                    '#6d597a',
                    '#003566',
                    "#b91d47",
                    "#00aba9",
                    "#2b5797",
                    "#e8c3b9",
                    "#1e7145"
                ],
                borderColor: [
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff'
                ],
                borderWidth: 2,
                borderRadius: 12,
                barPercentage: 0.3,
                hoverBackgroundColor: '#003566',
            }]
        };
        // render init block
        new Chart(
            document.getElementById('browserChart'),
            {
                type: 'polarArea',
                data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            }
        );

        // OS Chart
        var platform = @json($data['platform']);
        var platform_data = Object.values(platform);
        var platform_label = Object.keys(platform);
        var data = {
            labels: platform_label,
            datasets: [{
                label: 'OS',
                data: platform_data,
                backgroundColor: [
                    '#5e3fc9',
                    '#718355',
                    '#ef476f',
                    '#ee6c4d',
                    "#b91d47",
                    "#2b5797",
                    "#e8c3b9",
                    "#1e7145",
                    '#2a9d8f',
                ],
                borderColor: [
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff'
                ],
                borderWidth: 3,
                borderRadius: 12,
                barPercentage: 0.3,
                hoverBackgroundColor: '#003566',
            }]
        };
        // render init block
        new Chart(
            document.getElementById('osChart'),
            {
                type: 'pie',
                data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            }
        );

    })(jQuery);
</script>
