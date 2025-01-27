<x-app-layout>
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                    </svg>
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                    </svg>
                    <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Dashboard</a>
                </div>
            </li>
        </ol>
    </nav>

    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">A chart displaying the counts of Ally, Opponent, and Undecided voters for each municipality.</h3>
    <div class="p-4 mb-3 rounded-lg bg-gray-50 dark:bg-gray-800 border border-dashed">
        <p class="text-sm text-gray-500 dark:text-gray-400 italic">This chart displays the distribution of "Ally," "Opponent," and "Undecided" voters across municipalities. Each municipality is shown on the x-axis, with three color-coded bars representing the voter counts for each category. The y-axis shows the total number of voters in each group, offering a clear comparison of voter preferences in each municipality.</p>
    </div>

    <!-- Bar Graph -->

    <div id="chart"></div>


</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {
        series: [{
            name: 'Ally',
            data: @json($ally_counts_datasets) // Ally counts from the controller
        }, {
            name: 'Opponent',
            data: @json($opponent_counts_datasets) // Opponent counts from the controller
        }, {
            name: 'Undecided',
            data: @json($undecided_counts_datasets) // Undecided counts from the controller
        }],
        chart: {
            type: 'bar',
            height: 600
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
            categories: @json($municipalities_datasets), // Municipality names from the controller
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

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>