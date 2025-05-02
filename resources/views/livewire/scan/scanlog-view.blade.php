<div>
    <div class="relative overflow-x-auto sm:rounded-lg">
        <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
            <div>

            </div>
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for voter name" wire:model.live="search">
            </div>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Voter Details
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Scanner Personnel
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Scan Log
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Event Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($scanlogs as $log)
                <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="ps-3">
                            <div class="text-base font-semibold">Name: {{ $log->fname . ' ' . $log->mname . ' ' . $log->mname }}</div>
                            <div class="font-normal text-gray-500">Barangay: {{ $log->barangay_name }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        {{ $log->user_name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ date('F, d Y ----- h:i A', strtotime($log->created_at)) }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $log->event_name }}
                    </td>
                    <td class="px-6 py-4">
                        <button class="inline-flex items-center text-gray-500 bg-white border border-red-400 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" wire:click="deleteLog({{ $log->id }})" wire:confirm="Are you sure you want to delete logs?">
                            Delete
                        </button>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>