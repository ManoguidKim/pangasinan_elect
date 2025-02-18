<div>
    <div class="relative overflow-x-auto sm:rounded-lg p-1">
        <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
            <div>

            </div>
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="text" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items" wire:model.live="search">
            </div>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 shadow-md">
            <thead class="text-xs text-gray-700 uppercase bg-blue-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" width="5%">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Municipality / City Name
                    </th>
                    <th scope="col" class="px-6 py-3" width="30%">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($municipalities as $municipality)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 uppercase">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white italic">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $municipality->name }}
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('system-admin-log-municipalities-show', $municipality->id) }}" class="inline-flex items-center text-gray-500 bg-yellow-100 border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            View Activity Logs {{ $municipality->name }}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>