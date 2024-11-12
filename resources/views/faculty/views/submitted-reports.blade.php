<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submitted Reports') }}
        </h2>
    </x-slot>

    <div class="py-2 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl rounded-lg">
                <div class="p-2">
                    <h3 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-4">Submitted Reports</h3>
                    <p class="text-gray-600 mb-8 text-lg">Here you can view your submitted reports and their current status.</p>
                     <!-- Fancy Summary Section -->
                     <div class="mt-12 grid grid-cols-1 gap-5 sm:grid-cols-4">
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Total Reports
                                </dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                    {{ $reports->count() }}
                                </dd>
                            </div>
                        </div>
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Pending Reports
                                </dt>
                                <dd class="mt-1 text-3xl font-semibold text-yellow-600">
                                    {{ $reports->where('status', 'pending')->count() }}
                                </dd>
                            </div>
                        </div>
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Uploaded Files
                                </dt>
                                <dd class="mt-1 text-3xl font-semibold text-green-600">
                                    {{ $reports->where('transaction_type', 'Upload')->count() }}
                                </dd>
                            </div>
                        </div>
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Deleted Files Count
                                </dt>
                                <dd class="mt-1 text-3xl font-semibold text-red-600">
                                    {{ $reports->where('transaction_type', 'Delete')->count() }}
                                </dd>
                            </div>
                        </div>
                    </div>


                    <!-- Reports Table -->
                    <div class="p-4 bg-gray-50 rounded-xl shadow-inner">
                        <div class="overflow-x-auto">
                            <div class="max-h-[32rem] overflow-y-auto">
                                <table class="w-full table-auto">
                                    <thead class="sticky top-0 bg-gradient-to-r from-blue-500 to-purple-600 text-white">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Title</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Requirement Name</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Uploaded Clearance Name</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Transaction Type</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Date</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <!-- Loop through reports -->
                                        @foreach($reports->sortByDesc('created_at') as $report)
                                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                            <td class="py-2 px-4 border-b">
                                                <div class="text-xs font-medium text-gray-900">{{ $report->title }}</div>
                                            </td>
                                            <td class="py-2 px-4 border-b text-xs">{{ $report->requirement_name }}</td>
                                            <td class="py-2 px-4 border-b text-xs">{{ $report->uploaded_clearance_name }}</td>
                                            <td class="py-2 px-4 border-b text-xs">
                                                <span class="px-2 py-1 rounded-full text-[10px] font-medium 
                                                    {{ str_contains(strtolower($report->transaction_type), 'reset') || 
                                                    str_contains(strtolower($report->transaction_type), 'resubmit') ? 
                                                    'bg-orange-100 text-orange-800' :
                                                    (str_contains(strtolower($report->transaction_type), 'remove') ?
                                                    'bg-purple-100 text-purple-800' :
                                                    (str_contains(strtolower($report->transaction_type), 'delete') ||
                                                        str_contains(strtolower($report->transaction_type), 'remove file') ?
                                                    'bg-red-100 text-red-800' :
                                                    (str_contains(strtolower($report->transaction_type), 'upload') ?
                                                    'bg-indigo-100 text-indigo-800' :
                                                    (str_contains(strtolower($report->transaction_type), 'generate') ||
                                                        str_contains(strtolower($report->transaction_type), 'add') ||
                                                        str_contains(strtolower($report->transaction_type), 'aquire') ||
                                                        str_contains(strtolower($report->transaction_type), 'validated') ?
                                                    'bg-green-100 text-green-800' :
                                                    (str_contains(strtolower($report->transaction_type), 'edit') || 
                                                        str_contains(strtolower($report->transaction_type), 'edited') ?
                                                    'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800'))))) }}">
                                                    {{ $report->transaction_type }}
                                                </span>
                                            </td>
                                            <td class="py-2 px-4 border-b text-xs">{{ $report->created_at->format('M d, Y H:i') }}</td>
                                            <td class="py-2 px-4 border-b">
                                                <span class="px-2 py-1 inline-flex text-xxs leading-4 font-semibold rounded-full 
                                                    @if($report->status == 'Completed') bg-green-100 text-green-800
                                                    @elseif($report->status == 'Okay') bg-blue-100 text-blue-800
                                                    @elseif($report->status == 'Failed') bg-red-100 text-red-800
                                                    @else bg-gray-100 text-gray-800
                                                    @endif">
                                                    {{ ucfirst($report->status) }}
                                                </span>
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
        </div>
    </div>
</x-app-layout>