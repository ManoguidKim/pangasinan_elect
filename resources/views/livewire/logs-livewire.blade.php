<div>
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
                    <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Activity Logs</a>
                </div>
            </li>
        </ol>
    </nav>

    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">System Activity Logs</h3>
    <div class="p-4 mb-3 rounded-lg bg-blue-50 dark:bg-gray-800">
        <p class="text-sm text-gray-500 dark:text-gray-400">System activity logs are an essential component of a software system, providing a detailed and organized record of various actions and events that occur within the system. These logs capture a wide range of activities, from user interactions to system-level operations, helping administrators and developers monitor, troubleshoot, and audit the system effectively.</p>
    </div>

    <div class="relative overflow-x-auto sm:rounded-lg p-1">
        <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">

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
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action / Description
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Model
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Subject ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Causer Details
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Properties
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Date Created
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Date Updated
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-2">{{ $loop->iteration }}</td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $log->description }}</th>
                    <td class="px-6 py-4">{{ $log->subject_type }}</td>
                    <td class="px-6 py-4">{{ $log->subject_id }}</td>
                    <td class="px-6 py-4">{{ $log->name }} <br> ({{ $log->role }})</td>
                    <td class="px-6 py-4">
                        @if ($log->event == 'deleted')
                        <strong class="text-red-400">Old Values:</strong>
                        <ul>
                            @foreach ($log->properties['old'] as $key => $value)
                            <li>{{ $key }} : {{ is_array($value) ? json_encode($value) : $value }}</li>
                            @endforeach
                        </ul>

                        @elseif ($log->event == 'created')
                        <strong class="text-green-400">New Values (Attributes):</strong>
                        <ul>
                            @foreach ($log->properties['attributes'] as $key => $value)
                            <li>{{ $key }} : {{ is_array($value) ? json_encode($value) : $value }}</li>
                            @endforeach
                        </ul>

                        @else
                        @if (isset($log->properties['old']))
                        <strong class="text-indigo-400">Old Values:</strong>
                        <ul>
                            @foreach ($log->properties['old'] as $key => $value)
                            <li>{{ $key }} : {{ is_array($value) ? json_encode($value) : $value }}</li>
                            @endforeach
                        </ul>
                        @else
                        <p>No Old Values</p>
                        @endif

                        @if (isset($log->properties['attributes']))
                        <strong class="text-indigo-800">New Values (Attributes):</strong>
                        <ul>
                            @foreach ($log->properties['attributes'] as $key => $value)
                            <li>{{ $key }} : {{ is_array($value) ? json_encode($value) : $value }}</li>
                            @endforeach
                        </ul>
                        @else
                        <p>No New Values</p>
                        @endif
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ date('F d, Y', strtotime($log->created_at)) }}</td>
                    <td class="px-6 py-4">{{ date('F d, Y', strtotime($log->updated_at)) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>