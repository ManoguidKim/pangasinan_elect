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
                    <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Reports</a>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid gap-4 mb-6 md:grid-cols-2">
        <div>
            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Barangay</label>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model="barangay">
                <option value="">Select Barangay</option>
                <option value="Alinggan">Alinggan</option>
                <option value="Amanperez">Amanperez</option>
                <option value="Amancosiling Norte">Amancosiling Norte</option>
                <option value="Amancosiling Sur">Amancosiling Sur</option>
                <option value="Ambayat I">Ambayat I</option>
                <option value="Ambayat II">Ambayat II</option>
                <option value="Apalen">Apalen</option>
                <option value="Asin">Asin</option>
                <option value="Ataynan">Ataynan</option>
                <option value="Bacnono">Bacnono</option>
                <option value="Balaybuaya">Balaybuaya</option>
                <option value="Banaban">Banaban</option>
                <option value="Bani">Bani</option>
                <option value="Batangcaoa">Batangcaoa</option>
                <option value="Beleng">Beleng</option>
                <option value="Bical Norte">Bical Norte</option>
                <option value="Bical Sur">Bical Sur</option>
                <option value="Bongato East">Bongato East</option>
                <option value="Bongato West">Bongato West</option>
                <option value="Buayaen">Buayaen</option>
                <option value="Buenlag 1st">Buenlag 1st</option>
                <option value="Buenlag 2nd">Buenlag 2nd</option>
                <option value="Cadre Site">Cadre Site</option>
                <option value="Carungay">Carungay</option>
                <option value="Caturay">Caturay</option>
                <option value="Darawey (Tangal)">Darawey (Tangal)</option>
                <option value="Duera">Duera</option>
                <option value="Dusoc">Dusoc</option>
                <option value="Hermoza">Hermoza</option>
                <option value="Idong">Idong</option>
                <option value="Inanlorenza">Inanlorenza</option>
                <option value="Inirangan">Inirangan</option>
                <option value="Iton">Iton</option>
                <option value="Langiran">Langiran</option>
                <option value="Ligue">Ligue</option>
                <option value="M. H. del Pilar">M. H. del Pilar</option>
                <option value="Macayocayo">Macayocayo</option>
                <option value="Magsaysay">Magsaysay</option>
                <option value="Maigpa">Maigpa</option>
                <option value="Malimpec">Malimpec</option>
                <option value="Malioer">Malioer</option>
                <option value="Managos">Managos</option>
                <option value="Manambong Norte">Manambong Norte</option>
                <option value="Manambong Parte">Manambong Parte</option>
                <option value="Manambong Sur">Manambong Sur</option>
                <option value="Mangayao">Mangayao</option>
                <option value="Nalsian Norte">Nalsian Norte</option>
                <option value="Nalsian Sur">Nalsian Sur</option>
                <option value="Pangdel">Pangdel</option>
                <option value="Pantol">Pantol</option>
                <option value="Paragos">Paragos</option>
                <option value="Poblacion Sur">Poblacion Sur</option>
                <option value="Pugo">Pugo</option>
                <option value="Reynado">Reynado</option>
                <option value="San Gabriel 1st">San Gabriel 1st</option>
                <option value="San Gabriel 2nd">San Gabriel 2nd</option>
                <option value="San Vicente">San Vicente</option>
                <option value="Sancagulis">Sancagulis</option>
                <option value="Sanlibo">Sanlibo</option>
                <option value="Sapang">Sapang</option>
                <option value="Tamaro">Tamaro</option>
                <option value="Tambac">Tambac</option>
                <option value="Tampog">Tampog</option>
                <option value="Tanolong">Tanolong</option>
                <option value="Tatarac">Tatarac</option>
                <option value="Telbang">Telbang</option>
                <option value="Tococ East">Tococ East</option>
                <option value="Tococ West">Tococ West</option>
                <option value="Warding">Warding</option>
                <option value="Wawa">Wawa</option>
                <option value="Zone I (Poblacion)">Zone I</option>
                <option value="Zone II (Poblacion)">Zone II</option>
                <option value="Zone III (Poblacion)">Zone III</option>
                <option value="Zone IV (Poblacion)">Zone IV</option>
                <option value="Zone V (Poblacion)">Zone V</option>
                <option value="Zone VI (Poblacion)">Zone VI</option>
                <option value="Zone VII (Poblacion)">Zone VII</option>
            </select>

            @error('barangay')
            <span class="text-red-400">Barangay required</span>
            @enderror
        </div>
        <div>
            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Report Type</label>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model="reportType" wire:click="initializeSubType">
                <option value="">Select Type</option>
                <option value="Active Voter">Active Voter</option>
                <option value="Active Voter of Organization">Active Voter of Organization</option>
                <option value="Active Voter of Barangay Staff">Active Voter of Barangay Staff</option>
            </select>

            @error('reportType')
            <span class="text-red-400">Report Type required</span>
            @enderror
        </div>
        <div>
            @if($reportSubType != Null)
            <label for="sub_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Report Sub-Type</label>
            <select id="sub_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live="reportSubTypeSelected">
                <option value="">Select Type</option>
                @foreach($reportSubType as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
            @else
            <label for="sub_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Report Sub-Type</label>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </select>
            @endif
        </div>
    </div>

    <button class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" wire:click="generatePreviewReport">
        View Report
    </button>

    @if($preview)
    <button class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 ml-2" wire:click.prevent="generateReport">
        Download Report
    </button>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                Preview of generated report
                <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Browse a list of Flowbite products designed to help you work and play, stay organized, get answers, keep in touch, grow your business, and more.</p>
            </caption>
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Voter Details
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Precint No.
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataSets as $data)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">
                        {{ $loop->iteration}}
                    </td>
                    <td class="flex items-center px-6 py-3 text-gray-900 whitespace-nowrap dark:text-white">
                        @if($data->image_path == "")
                        <img class="w-10 h-10 rounded-full" src="../../images/user.jpg" alt="Jese image">
                        @else
                        <img class="w-10 h-10 rounded-full" src="{{ asset('storage/' . $data->image_path) }}">
                        @endif
                        <div class="ps-3">
                            <div class="text-base font-semibold">{{ $data->fname . ' ' . $data->mname .  ' ' . $data->lname }}</div>
                            <div class="font-normal text-gray-500">{{ 'Gender : ' . $data->gender . ' - Date of birth : . ' . date('F d, Y', strtotime($data->dob)) }}</div>
                            <div class="font-normal text-red-400">{{ 'Address : ' . $data->barangay }}, Bayambang, Pangasinan</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        {{ $data->precinct_no }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $data->status }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

</div>