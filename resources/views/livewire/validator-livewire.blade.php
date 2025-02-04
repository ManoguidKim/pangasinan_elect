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
                    <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Voters</a>
                </div>
            </li>
        </ol>
    </nav>

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

    <div class="p-4 mb-3 rounded-lg bg-gray-50 dark:bg-gray-800">
        <p class="text-sm text-gray-500 dark:text-gray-400">
            The list of voters displayed below consists exclusively of individuals registered in the barangay that has been specifically assigned to you. This ensures that you are only viewing and managing voters within your designated area.</p>
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
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 shadow-md">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Voter Details
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($voters as $voter)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 uppercase">
                        <th scope="row" class="flex flex-col sm:flex-row px-6 py-3 text-gray-900 whitespace-nowrap dark:text-white">
                            @can('update', $voter)
                            <a href="{{ route('system-validator-capture-image', $voter->id) }}" class="flex-shrink-0">
                                @if($voter->image_path == "")
                                <img class="w-10 h-10 rounded-full" src="../../images/user.jpg" alt="Jese image">
                                @else
                                <img class="w-10 h-10 rounded-full" src="{{ asset('storage/' . $voter->image_path) }}">
                                @endif
                            </a>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <div class="text-base font-bold">{{ $voter->fname . ' ' . $voter->mname .  ' ' . $voter->lname }}</div>
                                <div class="font-bold text-gray-400">{{ 'Gender : ' . $voter->gender . ' - Date of birth : ' . date('F d, Y', strtotime($voter->dob)) }}</div>



                                @if($voter->remarks == "Ally")
                                <div class="font-bold text-green-400">{{ 'Marked as : ' . $voter->remarks }}</div>
                                @endif

                                @if($voter->remarks == "Opponent")
                                <div class="font-bold text-red-400">{{ 'Marked as : ' . $voter->remarks }}</div>
                                @endif

                                @if($voter->remarks == "Undecided")
                                <div class="font-bold text-gray-400">{{ 'Marked as : ' . $voter->remarks }}</div>
                                @endif

                                <div class="font-bold text-gray-400">{{ $voter->status }}</div>

                                <br>

                                <div class="flex flex-col sm:flex-row gap-4 p-4">
                                    <!-- Responsive Button: Full width on small screens, auto width on medium+ screens -->
                                    <a href="{{ route('system-admin-validator-edit', $voter->id) }}"
                                        class="w-full md:w-auto inline-flex items-center justify-center text-gray-500 bg-green-200 border border-green-200 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-4 py-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                        wire:confirm="Are you sure you want to edit {{ $voter->fname . ' ' . $voter->mname .  ' ' . $voter->lname }} information?">
                                        Edit Voter Details
                                    </a>

                                    <a href="{{ route('system-admin-validator-voter-assign-organization', $voter->id) }}"
                                        class="w-full md:w-auto inline-flex items-center justify-center text-gray-500 bg-yellow-200 border border-yellow-200 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-4 py-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                        wire:confirm="Are you sure you want to edit {{ $voter->fname . ' ' . $voter->mname .  ' ' . $voter->lname }} information?">
                                        Assign Organization
                                    </a>
                                </div>

                            </div>
                        </th>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>