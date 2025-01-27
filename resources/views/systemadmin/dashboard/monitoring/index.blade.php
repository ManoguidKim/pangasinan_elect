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
                    <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Monitoring</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                    </svg>
                    <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Encoder</a>
                </div>
            </li>
        </ol>
    </nav>

    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Tracking the progress of municipality coding.</h3>
    <div class="p-4 mb-3 rounded-lg bg-green-50 dark:bg-gray-800 border border-dashed">
        <p class="text-sm text-gray-500 dark:text-gray-400 italic">The line graph below shows the daily progress of voter encoding per municipality, highlighting the number of voters recorded each day. It allows for comparisons between municipalities, showing variations in speed and efficiency. The graph helps identify trends, potential delays, and areas needing support, ensuring timely completion of the voter encoding process across all municipalities.</p>
    </div>

    <div class="space-y-6">
        @foreach ($chartData as $municipalityData)
        @php
        $chartId = 'chart-' . Str::slug($municipalityData['name']);
        @endphp
        <div class="bg-white p-4 rounded-lg shadow dark:bg-gray-800">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">
                {{ $municipalityData['name'] }}
            </h4>
            <div id="{{ $chartId }}"></div>
        </div>
        @endforeach
    </div>

</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Ensure chartData is parsed as a JavaScript array
        const chartData = @json($chartData);
        console.log(chartData);

        chartData.forEach((municipalityData) => {
            const chartId = `chart-${municipalityData.name.replace(/\s+/g, '-')}`;
            const chartElement = document.querySelector(`#${chartId.toLowerCase()}`);

            if (!chartElement) {
                console.error(`Chart container not found for: ${municipalityData.name}`);
                return;
            }

            const options = {
                series: [{
                    name: municipalityData.name,
                    data: municipalityData.data
                }],
                chart: {
                    type: 'line',
                    height: 200
                },
                xaxis: {
                    type: 'datetime',
                    labels: {
                        formatter: function(value) {
                            const date = new Date(value);
                            const options = {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric'
                            };
                            return date.toLocaleDateString('en-US', options);
                        }
                    }
                },
                title: {
                    text: "",
                    align: 'center'
                },
                colors: ['#008FFB']
            };

            const chart = new ApexCharts(chartElement, options);
            chart.render();
        });
    });
</script>