<div>
    <div class="w-full bg-white border border-dashed dark:bg-gray-800 p-4 md:p-6">
        <div class="flex justify-between mb-5">
            <div class="grid gap-4">
                <h3 class="text-md font-bold text-gray-600 dark:text-white mb-2">A chart showing Ally, Opponent, and Undecided voter counts per municipality.</h3>
            </div>
            <div>
                <a href="{{ route('system-admin-map-provice') }}" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    View Details in Map
                </a>

                <a href="{{ route('system-admin-barangay-voter-analytics') }}" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    View Analytics
                </a>
            </div>
        </div>
        <div id="faction-bar-graph"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Faction
    var options2 = {
        series: [{
            name: 'Ally',
            data: @json($allycounts) // Ally counts from the controller
        }, {
            name: 'Opponent',
            data: @json($opponentcounts) // Opponent counts from the controller
        }, {
            name: 'Undecided',
            data: @json($undecidedcounts) // Undecided counts from the controller
        }],
        chart: {
            type: 'bar',
            height: 400
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                borderRadius: 5,
                borderRadiusApplication: 'end'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: @json($municipalities), // Municipality names from the controller
        },
        yaxis: {
            title: {
                text: 'Voter Count'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + " people"
                }
            }
        },
        colors: ['#28a745', '#dc3545', '#ffc107'] // Colors for Ally, Opponent, Undecided
    };

    var chart2 = new ApexCharts(document.querySelector("#faction-bar-graph"), options2);
    chart2.render();
</script>