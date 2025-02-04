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
                    <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Create</a>
                </div>
            </li>
        </ol>
    </nav>

    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Create new voter</h3>
    <div class="p-4 mb-3 rounded-lg bg-blue-50 dark:bg-gray-800 border border-dashed">
        <p class="text-sm text-gray-500 dark:text-gray-400">A new voter is someone recently registered or eligible to vote, such as those reaching legal voting age, newly naturalized citizens, or individuals updating their registration after moving. They provide personal information and proof of identity to join the voter list and participate in elections.</p>
    </div>

    <form action="{{ route('system-admin-voters-create-add') }}" method="post">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div class="w-full">

                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">First Name</label>
                <input type="text" name="fname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2" placeholder="Enter First Name" value="{{ old('fname') }}">
                @error('fname')
                <span class="text-red-400">{{ $message }}</span>
                @enderror

                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Middle Name</label>
                <input type="text" name="mname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2" placeholder="Enter Middle Name" value="{{ old('mname') }}">
                @error('mname')
                <span class="text-red-400">{{ $message }}</span>
                @enderror

                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Last Name</label>
                <input type="text" name="lname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2" placeholder="Enter Last Name" value="{{ old('lname') }}">
                @error('lname')
                <span class="text-red-400">{{ $message }}</span>
                @enderror

                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Suffix</label>
                <input type="text" name="suffix" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2" placeholder="Enter Suffix" value="{{ old('suffix') }}">
                @error('suffix')
                <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <div class="fw-full">
                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Date of Birth</label>
                <input type="date" name="dob" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2" value="{{ old('dob') }}">
                @error('dob')
                <span class="text-red-400">{{ $message }}</span>
                @enderror

                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Gender</label>
                <select name="gender" class="mb-2 bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter First Name">
                    <option value="">Select Gender</option>
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
                @error('gender')
                <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <div class="fw-full">

                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Barangay</label>
                <select name="barangay" class="bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2" placeholder="Enter First Name" wire:model="barangay">

                    <option value="">Select Barangay</option>
                    @foreach ($barangays as $barangay)
                    <option value="{{ $barangay->id }}" {{ old('barangay') == $barangay->id ? 'selected' : '' }}>{{ $barangay->name }}</option>
                    @endforeach
                </select>
                @error('barangay')
                <span class="text-red-400">{{ $message }}</span>
                @enderror

                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Precinct No.</label>
                <input type="text" name="precinct_no" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2" placeholder="Enter Precinct No." value="{{ old('precinct_no') }}">

                @error('precinct_no')
                <span class="text-red-400">{{ $message }}</span>
                @enderror

                <label class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Mark voter as</label>
                <select name="remarks" class="mb-2 bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter First Name">
                    <option value="">Select Remakrs</option>
                    <option value="Ally" {{ old('remarks') == 'Ally' ? 'selected' : '' }}>Ally</option>
                    <option value="Opponent" {{ old('remarks') == 'Opponent' ? 'selected' : '' }}>Opponent</option>
                    <option value="Undecided" {{ old('remarks') == 'Undecided' ? 'selected' : '' }}>Undecided</option>
                </select>
                @error('remarks')
                <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <button type="submit" class="inline-flex items-center text-gray-500 bg-green-200 border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
            Add new voter
        </button>

        <a href="{{ route('system-admin-voters') }}" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 ml-2">
            Back to previous page
        </a>
    </form>

</x-app-layout>