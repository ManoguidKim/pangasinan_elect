<x-app-layout>

    @if(session()->has('message'))
    <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>
        <span class="sr-only">Info</span>
        <div>
            <span class="font-medium">{{ session('message') }}!</span>
        </div>
    </div>
    @endif

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
                    <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Report</a>
                </div>
            </li>
        </ol>
    </nav>

    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Printing voters per barangay</h3>
    <div class="p-4 mb-3 rounded-lg bg-gray-50 dark:bg-gray-800 border border-dashed">
        <p class="text-sm text-gray-500 dark:text-gray-400">Refers to the number of registered voters in each barangay, which is the smallest administrative division in the Philippines. This data helps electoral authorities manage and organize elections efficiently by allocating resources, setting up polling stations, and ensuring voter accessibility. The number of voters in each barangay varies, depending on the population size and voter registration in that area. It is a key factor in ensuring fair and orderly elections at the local level.</p>
    </div>

    <form action="{{ route('system-admin-generate-reports') }}" method="post" target="_blank">
        @csrf
        <div class="grid gap-4 mb-6 md:grid-cols-4">
            <div>
                <label for="first_name" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Barangay</label>
                <select name="barangay" class="bg-gray-50 border border-blue-300 boder-dashed text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">Select Barangay</option>
                    @foreach ($barangays as $barangay)
                    <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="last_name" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Type</label>
                <select name="type" id="type" class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">Select Type</option>
                    <option value="Active Voter">Active Voter</option>
                    <option value="Active Voter of Organization">Active Voter of Organization</option>
                    <option value="Active Voter of Barangay Staff">Active Voter of Barangay Staff</option>
                </select>
            </div>
            <div>
                <label for="sub_type" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Sub-Type</label>
                <select name="sub_type" id="sub_type" class="bg-gray-50 border border-blue-300 boder-dashed text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">Select Sub-Type</option>
                </select>
            </div>
        </div>

        <button type="submit" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
            Generate Report
        </button>
    </form>
</x-app-layout>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $('#type').on('change', function() {
        let type = this.value;

        if (!type) {
            // If no Type is selected, clear the Sub-Type dropdown and return
            $('#sub_type').html('<option value="">Select Sub-Type</option>');
            return;
        }

        if (type == 'Active Voter of Organization' || type == 'Active Voter of Barangay Staff') {
            $.ajax({
                url: '{{ route("system-admin-dynamic-subtype") }}',
                type: "POST",
                data: {
                    type: type,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    // Check if the result contains the expected 'subtype' data
                    if (result && result.subtype && Array.isArray(result.subtype)) {
                        // Clear the existing options
                        $('#sub_type').html('<option value="">Select Sub-Type</option>');

                        // Populate the Sub-Type dropdown with new options
                        $.each(result.subtype, function(key, value) {
                            $("#sub_type").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    } else {
                        // alert("No sub-types available for the selected type.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error: " + error);
                    alert("An error occurred while fetching sub-types.");
                }
            });
        } else {
            $('#sub_type').html('<option value="">Select Sub-Type</option>');
        }
    });
</script>