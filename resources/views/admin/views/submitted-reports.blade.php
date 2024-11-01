<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submitted Reports') }}
        </h2>
    </x-slot>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-8 text-gray-900">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Submitted Reports</h3>
                <p class="text-gray-600 mb-6">Here you can view and manage submitted reports.</p>

                <!-- Filter Options -->
                <div class="mb-6 flex gap-4 bg-gray-50 p-4 rounded-lg">
                    <input type="text" 
                            placeholder="Search by title..." 
                            class="flex-1 border border-gray-300 p-3 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        <i class="fas fa-search mr-2"></i> Filter
                    </button>
                </div>

                <!-- Reports Table -->
                <div class="max-h-[600px] overflow-y-auto">
                    <table class="w-full table-fixed divide-y divide-gray-200">
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
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 truncate">
                                        {{ $report->admin_name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 truncate">
                                        {{ $report->title }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 truncate">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium 
                                            {{ $report->transaction_type === 'Reset Checklist' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $report->transaction_type }}
                                        </span>
                                    </td>
                                    {{-- <td class="px-6 py-4 text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium
                                            {{ $report->status === 'complete' ? 'bg-green-100 text-green-800' : 
                                                ($report->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $report->status }}
                                        </span>
                                    </td> --}}
                                    <td class="px-6 py-4 text-sm text-gray-600 truncate">
                                        {{ $report->created_at->format('M d, Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</x-admin-layout>