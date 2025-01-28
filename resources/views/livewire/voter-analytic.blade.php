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
                    <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Analytics</a>
                </div>
            </li>
        </ol>
    </nav>

    @if(auth()->user()->role == "Admin")

    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Voter Analytics Table: Barangay Breakdown</h3>
    <div class="p-4 mb-3 rounded-lg bg-gray-50 dark:bg-gray-800 border border-dashed border-green-600">
        <p class="text-sm text-gray-500 dark:text-gray-400 italic">The data provides a detailed breakdown of the total number of voters in each barangay, along with the percentage distribution of voters based on their classification. This includes the proportion of voters identified as allies, the percentage of those who are opponents, and the share of undecided voters. These percentages are calculated by comparing the number of voters in each category to the total number of voters within the same barangay, giving a clear view of the voter dynamics in each area.</p>
    </div>

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
                <input type="text" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-blue-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items" wire:model.live="search">
            </div>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 shadow-md">
            <thead class="text-xs text-gray-700 uppercase bg-blue-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Barangay Name
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Total Voter
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Allies
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Opponents
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Undecided
                    </th>


                    <th scope="col" class="px-6 py-3">
                        Ally Percentage
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Opponent Percentage
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Undecided Percentage
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($voterfactions as $voter)
                @if ($voter->opponent_percentage > $voter->ally_percentage)
                <tr class="bg-red-100 border-b dark:bg-gray-800 dark:border-gray-700 uppercase">
                    <td class="px-6 py-4">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white italic">
                        {{ $voter->name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $voter->total_voters }}
                    </td>

                    <td class="px-6 py-4 bg-red-100 italic">
                        {{ $voter->ally_count }}
                    </td>
                    <td class="px-6 py-4 bg-red-100 italic">
                        {{ $voter->opponent_count }}
                    </td>
                    <td class="px-6 py-4 bg-red-100 italic">
                        {{ $voter->undecided_count }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $voter->ally_percentage }}%
                    </td>
                    <td class="px-6 py-4">
                        {{ $voter->opponent_percentage }}%
                    </td>
                    <td class="px-6 py-4">
                        {{ $voter->undecided_percentage }}%
                    </td>
                </tr>

                @else

                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 uppercase">
                    <td class="px-6 py-4">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white italic">
                        {{ $voter->name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $voter->total_voters }}
                    </td>

                    <td class="px-6 py-4 bg-green-50 italic">
                        {{ $voter->ally_count }}
                    </td>
                    <td class="px-6 py-4 bg-red-50 italic">
                        {{ $voter->opponent_count }}
                    </td>
                    <td class="px-6 py-4 bg-gray-50 italic">
                        {{ $voter->undecided_count }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $voter->ally_percentage }}%
                    </td>
                    <td class="px-6 py-4">
                        {{ $voter->opponent_percentage }}%
                    </td>
                    <td class="px-6 py-4">
                        {{ $voter->undecided_percentage }}%
                    </td>
                </tr>

                @endif

                @endforeach
            </tbody>
        </table>
    </div>


    <!-- Super Admin Analytics-->
    @else

    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Voter Analytics Table: Municipality / City Breakdown</h3>
    <div class="p-4 mb-3 rounded-lg bg-gray-50 dark:bg-gray-800 border border-dashed border-green-600">
        <p class="text-sm text-gray-500 dark:text-gray-400 italic">The data provides a detailed breakdown of the total number of voters in each municipality / city, along with the percentage distribution of voters based on their classification. This includes the proportion of voters identified as allies, the percentage of those who are opponents, and the share of undecided voters. These percentages are calculated by comparing the number of voters in each category to the total number of voters within the same municipality / city, giving a clear view of the voter dynamics in each area.</p>
    </div>

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
                <input type="text" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-blue-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items" wire:model.live="search">
            </div>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 shadow-md">
            <thead class="text-xs text-gray-700 uppercase bg-blue-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Municipality / City Name
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Total Voter
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Allies
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Opponents
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Undecided
                    </th>


                    <th scope="col" class="px-6 py-3">
                        Ally Percentage
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Opponent Percentage
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Undecided Percentage
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($voterfactions as $voter)
                @if ($voter->opponent_percentage > ($voter->total_voters * 0.15))
                <tr class="bg-red-100 border-b dark:bg-gray-800 dark:border-gray-700 uppercase">
                    <td class="px-6 py-4">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white italic">
                        {{ $voter->name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $voter->total_voters }}
                    </td>
                    <td class="px-6 py-4 bg-red-100 italic">
                        {{ $voter->ally_count }}
                    </td>
                    <td class="px-6 py-4 bg-red-100 italic">
                        {{ $voter->opponent_count }}
                    </td>
                    <td class="px-6 py-4 bg-red-100 italic">
                        {{ $voter->undecided_count }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $voter->ally_percentage }}%
                    </td>
                    <td class="px-6 py-4">
                        {{ $voter->opponent_percentage }}%
                    </td>
                    <td class="px-6 py-4">
                        {{ $voter->undecided_percentage }}%
                    </td>
                </tr>
                @else
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 uppercase">
                    <td class="px-6 py-4">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white italic">
                        {{ $voter->name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $voter->total_voters }}
                    </td>
                    <td class="px-6 py-4 bg-green-50 italic">
                        {{ $voter->ally_count }}
                    </td>
                    <td class="px-6 py-4 bg-red-50 italic">
                        {{ $voter->opponent_count }}
                    </td>
                    <td class="px-6 py-4 bg-gray-50 italic">
                        {{ $voter->undecided_count }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $voter->ally_percentage }}%
                    </td>
                    <td class="px-6 py-4">
                        {{ $voter->opponent_percentage }}%
                    </td>
                    <td class="px-6 py-4">
                        {{ $voter->undecided_percentage }}%
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>

        </table>
    </div>

    @endif

</div>