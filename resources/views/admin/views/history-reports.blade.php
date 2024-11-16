<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submitted Reports') }}
        </h2>
    </x-slot>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-8 text-gray-900">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">History of Report Actions Recorded</h3>
                <p class="text-gray-600 mb-6">Here you can view and manage submitted reports.</p>
                <form action="{{ route('admin.reports.generateSubmittedReport') }}" method="POST" target="_blank" class="bg-white p-6 rounded-lg shadow-md">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-4">
                            <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">Start Date</label>
                            <div class="relative">
                                <input type="date" id="start_date" name="start_date" 
                                    class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-2">End Date</label>
                            <div class="relative">
                                <input type="date" id="end_date" name="end_date" 
                                    class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            <i class="fas fa-file-download mr-2"></i>Generate Report
                        </button>
                    </div>
                </form>
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
               <!-- Reports Table -->
                <div class="max-h-[790px] overflow-y-auto">
                    <table class="w-full table-fixed divide-y divide-gray-200 border-2 border-gray-200 rounded-lg mt-4">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="hidden w-1/6 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                                <th class="w-1/6 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Faculty</th>
                                <th class="w-2/6 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="w-1/6 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider items-center text-center">Transaction Type</th>
                                <th class="w-1/6 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($reports as $report)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="hidden px-6 py-4 text-xs font-medium text-gray-900 truncate">
                                        {{ $report->admin_name }}
                                    </td>
                                    <td class="px-6 py-4 text-xs font-medium text-gray-900 truncate">
                                        {{ $report->faculty_name ?? 'System Generated' }}
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-600 truncate">
                                        {{ $report->title }}
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-600 truncate items-center text-center">
                                        <span class="px-2 py-1 rounded-full text-[10px] font-medium 
                                            {{ str_contains(strtolower($report->transaction_type), 'reset') || 
                                            str_contains(strtolower($report->transaction_type), 'resubmit') ? 
                                            'bg-orange-100 text-orange-800 border-2 border-orange-300' :
                                            (str_contains(strtolower($report->transaction_type), 'removed checklist') ?
                                            'bg-purple-100 text-purple-800 border-2 border-purple-300' :
                                            (str_contains(strtolower($report->transaction_type), 'removed file') ||
                                                str_contains(strtolower($report->transaction_type), 'delete') ?
                                            'bg-red-100 text-red-800 border-2 border-red-300' :
                                            (str_contains(strtolower($report->transaction_type), 'uploaded') ?
                                            'bg-indigo-100 text-indigo-800 border-2 border-indigo-300' :
                                            (str_contains(strtolower($report->transaction_type), 'generate') ||
                                                str_contains(strtolower($report->transaction_type), 'add') ||
                                                str_contains(strtolower($report->transaction_type), 'aquire') ||
                                                str_contains(strtolower($report->transaction_type), 'validated') ?
                                            'bg-green-100 text-green-800 border-2 border-green-300' :
                                            (str_contains(strtolower($report->transaction_type), 'edit') || 
                                                str_contains(strtolower($report->transaction_type), 'edited') ?
                                            'bg-yellow-100 text-yellow-800 border-2 border-yellow-300' : 'bg-blue-100 text-blue-800 border-2 border-blue-300'))))) }}">
                                            {{ $report->transaction_type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-600 truncate">
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