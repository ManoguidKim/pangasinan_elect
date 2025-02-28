<div>
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

    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Dashboard</h3>
    <!-- <div class="p-4 mb-3 rounded-lg bg-gray-50 dark:bg-gray-800 border border-dashed">
        <p class="text-sm text-gray-500 dark:text-gray-400 italic">This is the dashboard where you can view visual representations of various data, including the total number of active voters, the number of voters per barangay, scanned QR codes, and bar graphs displaying voter distribution across barangays. It also provides insights into the gender distribution of active voters, showing the number of males and females, as well as the age brackets of the voters.</p>
    </div> -->


    <!-- Card Data -->
    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="w-full">
            <div class="max-full p-6 bg-blue-100 border border-dashed border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 flex items-center">
                <div class="flex-1">
                    <a href="#">
                        <h6 class="mb-2 text-2xl font-semibold tracking-tight text-gray-600 dark:text-white uppercase">Total Active Voters</h6>
                    </a>
                    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400"></p>
                    <a href="{{ route('system-admin-active-voters') }}" class="inline-flex font-medium items-center text-blue-600 hover:underline">
                        Click to view details
                    </a>
                </div>
                <h6 class="mb-2 text-4xl font-semibold tracking-tight text-gray-600 dark:text-white">{{ number_format($activeVoter) }}</h6>
            </div>
        </div>

        <div class="w-full">
            <div class="max-full p-6 bg-green-100 border border-dashed border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 flex items-center">
                <div class="flex-1">
                    <a href="#">
                        <h6 class="mb-2 text-2xl font-semibold tracking-tight text-gray-600 dark:text-white uppercase">Total Ally</h6>
                    </a>
                    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400"></p>
                    <a href="{{ route('system-admin-active-voters') }}" class="inline-flex font-medium items-center text-blue-600 hover:underline">
                        Click to view details
                    </a>
                </div>
                <h6 class="mb-2 text-4xl font-semibold tracking-tight text-gray-600 dark:text-white">{{ number_format($voterTaggedAlly) }}</h6>
            </div>
        </div>

        <div class="w-full">
            <div class="max-full p-6 bg-yellow-100 border border-dashed border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 flex items-center">
                <div class="flex-1">
                    <a href="#">
                        <h6 class="mb-2 text-2xl font-semibold tracking-tight text-gray-600 dark:text-white uppercase">Scanned QR Percentage</h6>
                    </a>
                    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400"></p>
                    <a href="{{ route('system-admin-qr-scanlogs-graph') }}" class="inline-flex font-medium items-center text-blue-600 hover:underline">
                        Click to view details
                    </a>
                </div>
                <h6 class="mb-2 text-4xl font-semibold tracking-tight text-gray-600 dark:text-white">{{ $scannedVoter->scan_percentage }}%</h6>

            </div>
        </div>
    </div>


    <!-- Bar Graph -->
    <div class="w-full bg-white border border-dashed rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 mb-4">
        <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center me-3">
                    <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                        <path d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z" />
                        <path d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z" />
                    </svg>
                </div>
                <div>
                    <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-1">{{ number_format($activeVoter) }}</h5>
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Barangay active voters graph</p>
                </div>
            </div>

            <!-- Make buttons close to each other -->
            <div class="flex gap-2">
                <a href="{{ route('system-admin-reports-barangays-voter-report') }}" target="_blank"
                    class="inline-flex items-center text-gray-500 bg-green-200 border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    Print Data Report
                </a>

                <a href="{{ route('system-admin-barangay-voter-analytics') }}"
                    class="inline-flex items-center text-gray-500 bg-blue-200 border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    View Analytic
                </a>
            </div>
        </div>
        <div id="column-chart"></div>
    </div>



    <!-- Pie Charts -->
    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="w-full">

            <div class="w-full bg-white border border-dashed rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 mb-4">
                <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center me-3">
                            <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                                <path d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z" />
                                <path d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-1">Gender</h5>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Current voters categorized by gender</p>
                        </div>

                    </div>
                </div>
                <div class="py-6" id="pie-chart-gender"></div>
            </div>
        </div>

        <div class="w-full">

            <div class="w-full bg-white border border-dashed rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 mb-4">
                <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center me-3">
                            <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                                <path d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z" />
                                <path d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-1">Voter Classification</h5>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Faction distribution of active voters</p>
                        </div>

                    </div>
                </div>
                <div class="py-6" id="pie-chart-faction"></div>
            </div>
        </div>


        <div class="w-full">

            <div class="w-full bg-white border border-dashed rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 mb-4">
                <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center me-3">
                            <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                                <path d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z" />
                                <path d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-1">Validator Updates</h5>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Monitoring the validator's progress as a percentage of completion.</p>
                        </div>

                    </div>
                </div>
                <div class="py-6" id="validator-chart"></div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    const allyData = <?php echo json_encode($allyVoterCounts); ?>;
    const opponentData = <?php echo json_encode($opponentVoterCounts); ?>;
    const undecidedData = <?php echo json_encode($undecidedVoterCounts); ?>;
    const totalData = <?php echo json_encode($totalVoterCounts); ?>;
    const barangays = <?php echo json_encode($barangays); ?>;

    const options = {
        colors: ["#5981b9", "#e36b3b", "#878a8e"],
        series: [{
                name: "Ally",
                data: allyData
            },
            {
                name: "Opponent",
                data: opponentData
            },
            {
                name: "Undecided",
                data: undecidedData
            }
        ],
        labels: barangays,
        chart: {
            type: "bar",
            height: "420",
            stacked: true,
            fontFamily: "Inter, sans-serif",
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "70%",
                borderRadiusApplication: "end",
                borderRadius: 0
            }
        },
        tooltip: {
            shared: true,
            intersect: false,
            style: {
                fontFamily: "Inter, sans-serif"
            }
        },
        states: {
            hover: {
                filter: {
                    type: "darken",
                    value: 1
                }
            }
        },
        stroke: {
            show: true,
            width: 0,
            colors: ["transparent"]
        },
        grid: {
            show: true,
            strokeDashArray: 4,
            padding: {
                left: 2,
                right: 2,
                top: -14
            }
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            show: true
        },
        xaxis: {
            categories: barangays,
            floating: false,
            labels: {
                show: true,
                style: {
                    fontFamily: "Inter, sans-serif"
                }
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        yaxis: {
            show: true
        },
        fill: {
            opacity: 1
        }
    };

    document.addEventListener("DOMContentLoaded", function() {
        const chart = new ApexCharts(document.getElementById("column-chart"), options);
        chart.render();
    });




    // Voter Faction Bracket Graph
    const getChartOptionsFaction = () => {

        return {
            series: [<?php echo $voterFactionBracket->ally_count ?>, <?php echo $voterFactionBracket->opponent_count ?>, <?php echo $voterFactionBracket->undecided_count ?>],
            colors: ["#58d68d", "#e74c3c", "#5d6d7e"],
            chart: {
                height: 360,
                width: "100%",
                type: "donut",
            },
            stroke: {
                colors: ["transparent"],
                lineCap: "",
            },
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontFamily: "Inter, sans-serif",
                                offsetY: 20,
                            },
                            total: {
                                showAlways: true,
                                show: true,
                                label: "Voter(s)",
                                fontFamily: "Inter, sans-serif",
                                formatter: function(w) {
                                    const sum = w.globals.seriesTotals.reduce((a, b) => {
                                        return a + b
                                    }, 0)
                                    return sum.toLocaleString('en-US');
                                },
                            },
                            value: {
                                show: true,
                                fontFamily: "Inter, sans-serif",
                                offsetY: -20,
                                formatter: function(value) {
                                    return value.toLocaleString('en-US');
                                },
                            },
                        },
                        size: "80%",
                    },
                },
            },
            grid: {
                padding: {
                    top: -2,
                },
            },
            labels: ["Allies", "Opponents", "Undecided"],
            dataLabels: {
                enabled: false,
            },
            legend: {
                position: "bottom",
                fontFamily: "Inter, sans-serif",
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return value.toLocaleString('en-US');
                    },
                },
            },
            xaxis: {
                labels: {
                    formatter: function(value) {
                        return value.toLocaleString('en-US');
                    },
                },
                axisTicks: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                },
            },
        }
    }

    if (document.getElementById("pie-chart-faction") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("pie-chart-faction"), getChartOptionsFaction());
        chart.render();
    }




    // Gender Bracket Graph
    const getChartOptionsGender = () => {
        return {
            series: [<?php echo $voterGenderBracket->male_count ?>, <?php echo $voterGenderBracket->female_count ?>],
            colors: ["#1C64F2", "#9061F9"],
            chart: {
                height: 360,
                width: "100%",
                type: "donut",
            },
            stroke: {
                colors: ["transparent"],
                lineCap: "",
            },
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontFamily: "Inter, sans-serif",
                                offsetY: 20,
                            },
                            total: {
                                showAlways: true,
                                show: true,
                                label: "Voter(s)",
                                fontFamily: "Inter, sans-serif",
                                formatter: function(w) {
                                    const sum = w.globals.seriesTotals.reduce((a, b) => {
                                        return a + b
                                    }, 0)
                                    return sum.toLocaleString('en-US');
                                },
                            },
                            value: {
                                show: true,
                                fontFamily: "Inter, sans-serif",
                                offsetY: -20,
                                formatter: function(value) {
                                    return value.toLocaleString('en-US');
                                },
                            },
                        },
                        size: "80%",
                    },
                },
            },
            grid: {
                padding: {
                    top: -2,
                },
            },
            labels: ["Male", "Female"],
            dataLabels: {
                enabled: false,
            },
            legend: {
                position: "bottom",
                fontFamily: "Inter, sans-serif",
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return value.toLocaleString('en-US');
                    },
                },
            },
            xaxis: {
                labels: {
                    formatter: function(value) {
                        return value.toLocaleString('en-US');
                    },
                },
                axisTicks: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                },
            },
        }
    }

    if (document.getElementById("pie-chart-gender") && typeof ApexCharts !== 'undefined') {
        const chartGender = new ApexCharts(document.getElementById("pie-chart-gender"), getChartOptionsGender());
        chartGender.render();
    }



    // Validator update monitoring

    const getValidatorUpdateOption = () => {
        return {
            series: [<?php echo $updates->update_percentage ?>],
            chart: {
                height: 350,
                type: 'radialBar',
                offsetY: -10
            },
            plotOptions: {
                radialBar: {
                    startAngle: -135,
                    endAngle: 135,
                    dataLabels: {
                        name: {
                            fontSize: '16px',
                            color: undefined,
                            offsetY: 120
                        },
                        value: {
                            offsetY: 76,
                            fontSize: '22px',
                            color: undefined,
                            formatter: function(val) {
                                return val + "%";
                            }
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    shadeIntensity: 0.15,
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 65, 91]
                },
            },
            stroke: {
                dashArray: 4
            },
            labels: ['Updates'],
        }
    }

    if (document.getElementById("validator-chart") && typeof ApexCharts !== 'undefined') {
        const chartValidator = new ApexCharts(document.getElementById("validator-chart"), getValidatorUpdateOption());
        chartValidator.render();
    }
</script>