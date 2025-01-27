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
                         <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Monitoring</a>
                    </div>
               </li>
               <li>
                    <div class="flex items-center">
                         <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                         </svg>
                         <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Municipalities</a>
                    </div>
               </li>
          </ol>
     </nav>

     <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Tracking the progress of validator in every municipality.</h3>

     <div class="relative overflow-x-auto sm:rounded-lg p-1">

          <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 shadow-md">
               <thead class="text-xs text-gray-700 uppercase bg-blue-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                         <th scope="col" class="px-6 py-3" width="5%">
                              #
                         </th>
                         <th scope="col" class="px-6 py-3">
                              Municipality / City Name
                         </th>
                         <th scope="col" class="px-6 py-3" width="20%">
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
                              <a href="{{ route('system-admin-monitoring-validator-view', $municipality->id) }}" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                   View Validator Progress
                              </a>
                         </td>
                    </tr>
                    @endforeach
               </tbody>
          </table>
     </div>


</x-app-layout>