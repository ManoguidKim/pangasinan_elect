<div>
    <div class="w-full bg-white border border-dashed dark:bg-gray-800 p-4 md:p-6">
        <div class="flex justify-between mb-5">
            <div class="grid gap-4 grid-cols-2">
                <h3 class="text-md font-bold text-gray-600 dark:text-white mb-2">Bar Graph Showing Total Voters for Each Municipality</h3>
            </div>
            <div>
                <a href="{{ route('system-admin-barangay-voter-analytics') }}" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    View Details
                </a>
            </div>
        </div>
        <div id="voter-bar-graph"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    const options = {
        colors: ['#4052d6'], // Use generated random colors for each bar
        series: [{
            name: "Active Voter",
            data: <?php echo json_encode($votercounts) ?>,
        }],
        labels: <?php echo json_encode($municipalities) ?>,
        chart: {
            type: "bar",
            height: "400px",
            fontFamily: "Inter, sans-serif",
            toolbar: {
                show: false,
            },
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "70%",
                borderRadiusApplication: "end",
                borderRadius: 8,
            },
        },
        tooltip: {
            shared: true,
            intersect: false,
            style: {
                fontFamily: "Inter, sans-serif",
            },
        },
        states: {
            hover: {
                filter: {
                    type: "darken",
                    value: 1,
                },
            },
        },
        stroke: {
            show: true,
            width: 0,
            colors: ["transparent"],
        },
        grid: {
            show: true,
            strokeDashArray: 4,
            padding: {
                left: 2,
                right: 2,
                top: -14
            },
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        xaxis: {
            categories: <?php echo json_encode($municipalities) ?>,
            floating: false,
            labels: {
                show: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                }
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
        },
        yaxis: {
            show: true, // Optionally show the y-axis
        },
        fill: {
            opacity: 1,
        },
    };

    if (document.getElementById("voter-bar-graph") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("voter-bar-graph"), options);
        chart.render();
    }
</script>