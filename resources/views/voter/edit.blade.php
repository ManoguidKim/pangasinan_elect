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
                    <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Voter Management</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                    </svg>
                    <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Edit</a>
                </div>
            </li>
        </ol>
    </nav>

    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Updating Voter Information</h3>
    <div class="p-4 mb-3 rounded-lg bg-blue-50 dark:bg-gray-800 border border-dashed">
        <p class="text-sm text-gray-500 dark:text-gray-400">Updating voter details is an essential process that ensures the accuracy and integrity of voter records in the electoral system. It allows voters to modify their personal information or correct errors in their registration, ensuring they remain eligible and can participate in elections</p>
    </div>

    <form action="{{ route('system-admin-voters-update', ['voter' => $voterDetails->id]) }}" method="post">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div class="w-full">

                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">First Name</label>
                <input type="text" name="fname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2" value="{{ $voterDetails->fname }}">
                @error('fname')
                <span class="text-red-400">First name required</span>
                @enderror

                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Middle Name</label>
                <input type="text" name="mname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2" value="{{ $voterDetails->mname }}">
                @error('mname')
                <span class="text-red-400">Middle name required</span>
                @enderror

                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Last Name</label>
                <input type="text" name="lname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2" value="{{ $voterDetails->lname }}">
                @error('lname')
                <span class="text-red-400">Last name required</span>
                @enderror

                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Suffix</label>
                <input type="text" name="suffix" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2" value="{{ $voterDetails->suffix }}">
                @error('suffix')
                <span class="text-red-400">Suffix required</span>
                @enderror
            </div>

            <div class="fw-full">
                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Date of Birth</label>
                <input type="date" name="dob" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2" value="{{ $voterDetails->dob }}">
                @error('dob')
                <span class="text-red-400">Date of birth required</span>
                @enderror

                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Gender</label>
                <select name="gender" class="mb-2 bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter First Name">
                    <option value="{{ $voterDetails->gender }}">{{ $voterDetails->gender }}</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                @error('gender')
                <span class="text-red-400">Gender required</span>
                @enderror
            </div>

            <div class="fw-full">

                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Barangay</label>
                <select name="barangay" class="bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2" placeholder="Enter First Name" wire:model="barangay">

                    <option value="{{ $voterBarangayDetails->id }}">{{ $voterBarangayDetails->name }}</option>
                    @foreach ($barangays as $barangay)
                    <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                    @endforeach
                </select>
                @error('barangay')
                <span class="text-red-400">Barangay required</span>
                @enderror

                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Precinct No.</label>
                <input type="text" name="precinct_no" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2" placeholder="Enter Precinct No." value="{{ $voterDetails->precinct_no }}">

                @error('precinct_no')
                <span class="text-red-400">Precint No.</span>
                @enderror

                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Mark voter as</label>
                <select name="remarks" class=" bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model="remarks">
                    <option value="{{ $voterDetails->remarks }}">{{ $voterDetails->remarks }}</option>
                    <option value="Ally">Ally</option>
                    <option value="Opponent">Opponent</option>
                    <option value="Undecided">Undecided</option>
                </select>
                @error('remarks')
                <span class="text-red-400">Remark required</span>
                @enderror
            </div>
        </div>

        <button type="submit" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
            Update voter details
        </button>

        <a href="{{ route('system-admin-voters') }}" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 ml-2">
            Back to previous page
        </a>
    </form>

</x-app-layout>