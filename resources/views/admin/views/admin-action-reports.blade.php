<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submitted Reports') }}
        </h2>
    </x-slot>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-8 text-gray-900">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Admin Actions History Reports</h3>
                <p class="text-gray-600 mb-6">Here you can view the Admin's actions history reports.</p>

                <!-- Filter Options -->
                {{-- <div class="mb-6 flex gap-4 bg-gray-50 p-4 rounded-lg">
                    <input type="text" 
                            placeholder="Search by title..." 
                            class="flex-1 border border-gray-300 p-3 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        <i class="fas fa-search mr-2"></i> Filter
                    </button>
                </div> --}}

                <!-- Reports Table -->
                <div class="max-h-[790px] overflow-y-auto">
                    <table class="w-full table-fixed divide-y divide-gray-200 border-2 border-gray-200 rounded-lg mt-4">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="w-1/5 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="w-2/5 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="w-1/5 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction Type</th>
                                {{-- <th class="w-1/5 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th> --}}
                                <th class="w-1/5 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($reports as $report)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 text-xs font-medium text-gray-900 truncate">
                                        {{ $report->admin_name }}
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-600 truncate">
                                        {{ $report->title }}
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-600 truncate">
                                        <span class="px-2 py-1 rounded-full text-[10px] font-medium 
                                            {{ str_contains(strtolower($report->transaction_type), 'reset') ? 
                                               'bg-orange-100 text-orange-800 border-2 border-orange-300' :
                                               (str_contains(strtolower($report->transaction_type), 'remove') ?
                                               'bg-purple-100 text-purple-800 border-2 border-purple-300' :
                                               (str_contains(strtolower($report->transaction_type), 'delete') ?
                                               'bg-red-100 text-red-800 border-2 border-red-300' :
                                               (str_contains(strtolower($report->transaction_type), 'generate') ||
                                                str_contains(strtolower($report->transaction_type), 'add') ?
                                               'bg-green-100 text-green-800 border-2 border-green-300' :
                                               (str_contains(strtolower($report->transaction_type), 'edit') || 
                                                str_contains(strtolower($report->transaction_type), 'edited') ?
                                               'bg-yellow-100 text-yellow-800 border-2 border-yellow-300' : 'bg-blue-100 text-blue-800 border-2 border-blue-300')))) }}">
                                            {{ $report->transaction_type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-600 truncate w-[190px]">
                                        {{ $report->created_at->format('M d, Y h:i A') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</x-admin-layout>