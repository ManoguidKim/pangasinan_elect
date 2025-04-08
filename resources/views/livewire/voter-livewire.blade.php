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
                    <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Voter Management</a>
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

    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">List of all voter</h3>
    <div class="p-4 mb-3 rounded-lg bg-gray-50 dark:bg-gray-800">
        <p class="text-sm text-gray-500 dark:text-gray-400">This is an extensive list of all registered voters, providing detailed information such as each voter's full name, date of birth, gender, barangay, precinct number, and current status. This data offers a comprehensive overview of the voter demographics and registration status, allowing for a deeper understanding of the electorate.</p>
    </div>

    <div class="relative overflow-x-auto sm:rounded-lg p-1">
        <div class="flex flex-col sm:flex-row flex-wrap space-y-4 sm:space-y-0 sm:space-x-4 items-center justify-between pb-4">
            <div>
                <!-- <a href="{{ route('system-admin-voters-create') }}" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    Add new voter 1
                </a> -->
                <button wire:click="openAddModal" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    Add new voter
                </button>
            </div>

            <label for="table-search" class="sr-only">Search</label>
            <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0">
                <div class="relative">
                    <select class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live="searchBarangay">
                        <option value="">Select Barangay</option>
                        @foreach ($barangays as $barangay)
                        <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" id="table-search-2" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items" wire:model.live="search">
                </div>
            </div>
        </div>

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 shadow-md">
            <thead class="text-xs text-gray-700 uppercase bg-blue-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Voter's Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Precinct No.
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Remarks
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Is Guiconsulta
                    </th>
                    <th scope="col" class="px-6 py-3" width="15%">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($voters as $voter)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 uppercase">
                    <td class="px-6 py-4 font-bold text-gray-400">
                        {{ $loop->iteration }}
                    </td>

                    <th scope="row" class="flex items-center px-6 py-3 text-gray-900 whitespace-nowrap dark:text-white">
                        @if($voter->image_path == "")
                        <img class="w-10 h-10 rounded-full" src="../../images/user.jpg" alt="Jese image">
                        @else
                        <img class="w-10 h-10 rounded-full" src="{{ asset('storage/' . $voter->image_path) }}">
                        @endif
                        <div class="ps-3">
                            <div class="text-base font-semibold">{{ $voter->fname . ' ' . $voter->mname .  ' ' . $voter->lname . ' ' . $voter->suffix }}</div>
                            <div class="font-normal text-gray-500 italic">{{ 'Gender : ' . $voter->gender . ' - Date of birth : . ' . date('F d, Y', strtotime($voter->dob)) }}</div>
                            <div class="font-normal text-sm text-red-400 italic">{{ 'Barangay : ' . $voter->name }}</div>
                        </div>
                    </th>

                    <td class="px-6 py-3">
                        {{ $voter->precinct_no }}
                    </td>

                    <td class="px-6 py-3 font-bold text-gray-400">{{ $voter->status }}</td>
                    <td class="px-6 py-3 font-bold text-gray-400">{{ $voter->remarks }}</td>
                    <td class="px-6 py-3 font-bold text-gray-400">{{ $voter->is_guiconsulta }}</td>

                    <td class="px-6 py-3" width="40%">

                        @can('update', $voter)
                        <button wire:click="openEditModal({{ $voter->id }})" class="inline-flex items-center text-gray-500 bg-white border border-green-400 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            Edit
                        </button>
                        @endcan

                        @can('delete', $voter)
                        <button wire:click="delete({{ $voter->id }})" class="inline-flex items-center text-gray-500 bg-white border border-red-400 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" wire:click="deleteVoter({{ $voter->id }})" wire:confirm="Are you sure you want to delete?">
                            Delete
                        </button>
                        @endcan

                        <button wire:click="openDesignationModal({{ $voter->id }})" class="inline-flex items-center text-gray-500 bg-white border border-yellow-400 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            Assign Designation
                        </button>

                        <button wire:click="openOrganizationModal({{ $voter->id }})" class="inline-flex items-center text-gray-500 bg-white border border-yellow-400 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            Assign Organization
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>


    <!-- Add Modal -->
    @if($isModalOpen && empty($editId))
    <div id="static-modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 flex justify-center items-center bg-black bg-gray-800/20">
        <div class="relative w-full max-w-7xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200 bg-blue-50">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Add Voter
                    </h3>
                    <button wire:click="closeModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>

                <div class="p-1 md:p-5 space-y-1">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" wire:model="addFname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-3" placeholder="Enter First Name">
                            @error('addFname') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <label class="block text-sm font-medium text-gray-700">Middle Name</label>
                            <input type="text" wire:model="addMname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500  mb-3" placeholder="Enter Middle Name">
                            @error('addMname') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <label class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" wire:model="addLname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500  mb-3" placeholder="Enter Last Name">
                            @error('addLname') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <label class="block text-sm font-medium text-gray-700">Suffix</label>
                            <input type="text" wire:model="addSuffix" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter Suffix">
                            @error('addSuffix') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Suffix</label>
                            <input type="date" wire:model="addDob" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-3">
                            @error('addDob') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <label class="block text-sm font-medium text-gray-700">Gender</label>
                            <select wire:model="addGender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Choose Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            @error('addGender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Barangay</label>
                            <select wire:model="addBarangay" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-3">
                                <option value="">Choose Barangay</option>
                                @foreach ($barangays as $barangay)
                                <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                @endforeach
                            </select>
                            @error('addBarangay') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <label class="block text-sm font-medium text-gray-700">Precinct No</label>
                            <input type="text" wire:model="addPrecinct" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-3" placeholder="Enter Precinct No. Name">
                            @error('addPrecinct') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <label class="block text-sm font-medium text-gray-700">Mark voter as:</label>
                            <select wire:model="addRemarks" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-3">
                                <option value="">Choose Remarks</option>
                                <option value="Ally">Ally</option>
                                <option value="Opponent">Opponent</option>
                                <option value="Undecided">Undecided</option>
                            </select>
                            @error('addRemarks') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <label class="block text-sm font-medium text-gray-700">Is Guiconsulta?:</label>
                            <select wire:model="addGuiconsulta" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Is guiconsulta?</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            @error('addGuiconsulta') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                </div>

                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button wire:click="save" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Save
                    </button>
                    <button wire:click="closeModal" class="py-2.5 px-5 ml-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    @else

    @if($isModalOpen && !empty($editId))

    <div id="static-modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 flex justify-center items-center bg-black bg-gray-800/20">
        <div class="relative w-full max-w-7xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200 bg-blue-50">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit Voter
                    </h3>
                    <button wire:click="closeModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>

                <div class="p-1 md:p-5 space-y-1">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" wire:model="editFname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-3" placeholder="Enter First Name">
                            @error('editFname') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <label class="block text-sm font-medium text-gray-700">Middle Name</label>
                            <input type="text" wire:model="editMname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500  mb-3" placeholder="Enter Middle Name">
                            @error('editMname') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <label class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" wire:model="editLname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500  mb-3" placeholder="Enter Last Name">
                            @error('editLname') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <label class="block text-sm font-medium text-gray-700">Suffix</label>
                            <input type="text" wire:model="editSuffix" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter Suffix">
                            @error('editSuffix') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                            <input type="date" wire:model="editDob" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-3">
                            @error('editDob') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <label class="block text-sm font-medium text-gray-700">Gender</label>
                            <select wire:model="editGender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Choose Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            @error('editGender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Barangay</label>
                            <select wire:model="editBarangay" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-3">
                                <option value="{{ $voterBarangayDetails->id }}">{{ $voterBarangayDetails->name }}</option>
                                @foreach ($barangays as $barangay)
                                <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                @endforeach
                            </select>
                            @error('editBarangay') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <label class="block text-sm font-medium text-gray-700">Precinct No</label>
                            <input type="text" wire:model="editPrecinct" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-3" placeholder="Enter Precinct No. Name">
                            @error('editPrecinct') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <label class="block text-sm font-medium text-gray-700">Mark voter as:</label>
                            <select wire:model="editRemarks" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-3">
                                <option value="{{ $editRemarks }}">{{ $editRemarks }}</option>
                                <option value="Ally">Ally</option>
                                <option value="Opponent">Opponent</option>
                                <option value="Undecided">Undecided</option>
                            </select>
                            @error('editRemarks') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <label class="block text-sm font-medium text-gray-700">Is Guiconsulta?:</label>
                            <select wire:model="editGuiconsulta" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-3">
                                <option value="">Is guiconsulta?</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            @error('editGuiconsulta') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select wire:model="editStatus" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="{{ $editStatus }}">{{ $editStatus }}</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            @error('editStatus') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                </div>

                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button wire:click="save" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Save
                    </button>
                    <button wire:click="closeModal" class="py-2.5 px-5 ml-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    @endif

    @endif


    <!-- Organization Modal -->
    @if($isOrganizationModalOpen)

    <div id="static-modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 flex justify-center items-center bg-black bg-gray-800/20">
        <div class="relative w-full max-w-3xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200 bg-blue-50">
                    <h2 class="text-xl font-bold leading-none tracking-tight text-gray-500 md:text-3xl dark:text-white">Assingning Organization to {{ $voterorganization_votername }}</h2>
                    <button wire:click="closeModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>

                <div class="p-1 md:p-5 space-y-1">


                    <form wire:submit.prevent="createVoterOrganization">
                        <div class="grid grid-cols-3 gap-4 mb-4">

                            <div class="w-full">
                                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Organization</label>
                                <select class="mb-2 bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model="selectedorganization">

                                    <option value="">Select Organization</option>
                                    @foreach ($organizations as $org)
                                    <option value="{{ $org->id }}">{{ $org->name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedorganization')
                                <span class="text-red-400"> {{ $message }} </span>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Action</label>
                                <button type="submit" class="inline-flex items-center text-gray-500 bg-white border border-green-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                    Assign Organization
                                </button>
                            </div>
                        </div>
                    </form>


                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Organization
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($voterorganizations as $org)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $loop->iteration }}
                                    </th>
                                    <th scope="row" class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $org->name }}
                                    </th>
                                    <td class="px-4 py-4 text-right">
                                        <button class=" inline-flex items-center text-gray-500 bg-white border border-red-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" wire:click="deleteVoterOrganization({{ $org->id }})" wire:confirm="Are you sure you want to delete?">
                                            {{ $loop->iteration }} : Delete
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif


    @if($isDesignationModalOpen)

    <div id="static-modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 flex justify-center items-center bg-black bg-gray-800/20">
        <div class="relative w-full max-w-3xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200 bg-blue-50">
                    <h2 class="text-xl font-bold leading-none tracking-tight text-gray-500 md:text-3xl dark:text-white">Assingning Designation to {{ $voterdesignation_votername }}</h2>
                    <button wire:click="closeModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>

                <div class="p-1 md:p-5 space-y-1">
                    <form wire:submit.prevent="createVoterDesignation">
                        <div class="grid grid-cols-3 gap-4 mb-4">

                            <div class="w-full">
                                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Designation</label>
                                <select class="mb-2 bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model="selecteddesignation">
                                    <option value="">Select Designation</option>
                                    @foreach ($designations as $des)
                                    <option value="{{ $des->id }}">{{ $des->name }}</option>
                                    @endforeach
                                </select>
                                @error('selecteddesignation')
                                <span class="text-red-400"> {{ $message }} </span>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Action</label>
                                <button type="submit" class="inline-flex items-center text-gray-500 bg-white border border-green-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                    Assign Designation
                                </button>
                            </div>
                        </div>
                    </form>


                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Organization
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($voterdesignations as $des)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $loop->iteration }}
                                    </th>
                                    <th scope="row" class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $des->name }}
                                    </th>
                                    <td class="px-4 py-4 text-right">
                                        <button class=" inline-flex items-center text-gray-500 bg-white border border-red-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" wire:click="deleteVoterDesignation({{ $des->id }})" wire:confirm="Are you sure you want to delete?">
                                            {{ $loop->iteration }} : Delete
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif

</div>