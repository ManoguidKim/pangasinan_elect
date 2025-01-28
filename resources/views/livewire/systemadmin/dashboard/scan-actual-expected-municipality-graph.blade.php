<div>
    <div class="w-full bg-white border border-dashed dark:bg-gray-800 p-4 md:p-6">
        <div class="flex justify-between mb-5">
            <div class="grid gap-4 grid-cols-2">
                <h3 class="text-md font-bold text-gray-600 dark:text-white mb-2">A marker graph showing actual vs. expected QR code scans.</h3>
            </div>
        </div>
        <div id="scan-bar-graph" data-chart="{{ json_encode($chartData) }}"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Scan
    var chartData = JSON.parse(document.getElementById('scan-bar-graph').getAttribute('data-chart'));

    var options3 = {
        series: [{
            name: 'Actual',
            data: chartData,
        }],
        chart: {
            height: 500,
            type: 'bar'
        },
        plotOptions: {
            bar: {
                horizontal: true,
            }
        },
        colors: ['#4052d6'],
        dataLabels: {
            formatter: function(val, opt) {
                const goals =
                    opt.w.config.series[opt.seriesIndex].data[opt.dataPointIndex]
                    .goals

                if (goals && goals.length) {
                    return `${val} / ${goals[0].value}`
                }
                return val
            }
        },
        legend: {
            show: true,
            showForSingleSeries: true,
            customLegendItems: ['Actual', 'Expected'],
            markers: {
                fillColors: ['#4052d6', '#775DD0']
            }
        }
    };

    var chart3 = new ApexCharts(document.querySelector("#scan-bar-graph"), options3);
    chart3.render();
</script>