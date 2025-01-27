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
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                    </svg>
                    <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Voter Factions</a>
                </div>
            </li>
        </ol>
    </nav>

    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Faction information for each barangay.</h3>
    <div class="p-4 mb-3 rounded-lg bg-gray-50 dark:bg-gray-800 border border-dashed border-green-600">
        <p class="text-sm text-gray-500 dark:text-gray-400">This is a detailed visual presentation of data for each barangay, highlighting key information such as the number of allies, opponents, and undecided individuals within each area. The visualization allows for a clear comparison of the political landscape in each barangay, providing insights into the current support, opposition, and neutral stances of the residents.</p>
    </div>



    <div class="grid grid-cols-3 gap-4 mb-4">
        <div class="w-full">
            <a href="#" class="block w-full p-6 bg-green-50 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                <h5 class="mb-2 text-md font-bold tracking-tight text-gray-500 dark:text-white">Tagged Ally as of {{ date('F Y') }}</h5>
                <p class="font-bold text-2xl text-gray-700 dark:text-gray-400">= {{ number_format($voterTaggedAlly) }}</p>
            </a>
        </div>

        <div class="w-full">
            <a href="#" class="block w-full p-6 bg-red-50 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-md font-bold tracking-tight text-gray-500 dark:text-white">Tagged Opponent as of {{ date('F Y') }}</h5>
                <p class="font-bold text-2xl text-gray-700 dark:text-gray-400">= {{ number_format($voterTaggedOpponent) }}</p>
            </a>
        </div>

        <div class="w-full">
            <a href="#" class="block w-full p-6 bg-gray-50 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-md font-bold tracking-tight text-gray-500 dark:text-white">Tagged Undecided as of {{ date('F Y') }}</h5>
                <p class="font-bold text-2xl text-gray-700 dark:text-gray-400">= {{ number_format($voterTaggedUndecided) }}</p>
            </a>
        </div>
    </div>

    <div class="relative overflow-x-auto sm:rounded-lg">
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
                <input type="text" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-blue-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items" wire:model.live="search">
            </div>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-gray-300">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Barangay
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tagged Ally
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tagged Opponent
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tagged Undecided
                    </th>
                    <!-- <th scope="col" class="px-6 py-3">
                        Action
                    </th> -->
                </tr>
            </thead>
            <tbody>
                @foreach ($voterfactions as $voter)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 uppercase  border-gray-300">
                    <td class="px-6 py-4">
                        {{ $loop->iteration }}
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $voter->name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $voter->ally_count }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $voter->opponent_count }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $voter->undecided_count }}
                    </td>
                    <!-- <td class="px-6 py-4">
                        <button id="dropdownDividerButton{{ $loop->iteration }}" data-dropdown-toggle="dropdownDivider{{ $loop->iteration }}" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">{{ $loop->iteration }} : Select Action <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>

                        <div id="dropdownDivider{{ $loop->iteration }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDividerButton{{ $loop->iteration }}">
                                <li>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Comming Soon</a>
                                </li>
                            </ul>
                        </div>
                    </td> -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>