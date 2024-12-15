<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submitted Reports') }}
        </h2>
    </x-slot>

    <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8 border-2 border-gray-200 rounded-lg">
        <div class="bg-white overflow-hidden rounded-lg">
            <div class="p-2">
                <h3 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-4">History of Report Actions Recorded</h3>
                <p class="text-gray-600 mb-8 text-lg">Here you can view your submitted actions and their current status.</p>
                    <!-- Fancy Summary Section -->
                    <div class="mt-12 grid grid-cols-1 gap-5 sm:grid-cols-4">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Total Actions Recorded
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
                                Removed Files Count
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
                        <div class="max-h-[40rem] overflow-y-auto">
                            <table class="w-full table-auto border-2 border-gray-200 rounded-lg mt-4">
                                <thead class="sticky top-0 bg-gradient-to-r from-blue-500 to-purple-600 text-white">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Checked By</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Title</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider items-center text-center w-[170px]" style="width: 170px;">Transaction Type</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Date</th>
                                        {{-- <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Status</th> --}}
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <!-- Loop through reports -->
                                    @foreach($reports->sortByDesc('created_at') as $report)
                                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                        <td class="py-2 px-4 border-b">
                                            <div class="text-xs font-medium text-gray-900">{!! $report->admin->name ?? '<span class="text-gray-400">N/A</span>' !!}</div>
                                        </td>
                                        <td class="py-2 px-4 border-b text-xs">{{ $report->title }}</td>
                                        <td class="py-2 px-4 border-b text-xs items-center text-center">
                                            <span class="px-2 py-1 rounded-full text-[10px] font-medium 
                                                {{ str_contains(strtolower($report->transaction_type), 'reset') || 
                                                str_contains(strtolower($report->transaction_type), 'resubmit') ? 
                                                'bg-orange-100 text-orange-800 border-2 border-orange-300' :
                                                (str_contains(strtolower($report->transaction_type), 'remove') ?
                                                'bg-purple-200 text-purple-800 border-2 border-purple-300' :
                                                (str_contains(strtolower($report->transaction_type), 'delete') ||
                                                    str_contains(strtolower($report->transaction_type), 'remove file') ?
                                                'bg-red-100 text-red-800 border-2 border-red-300' :
                                                (str_contains(strtolower($report->transaction_type), 'upload') ?
                                                'bg-sky-100 text-sky-800 border-2 border-sky-300' :
                                                (str_contains(strtolower($report->transaction_type), 'generate') ||
                                                    str_contains(strtolower($report->transaction_type), 'add') ||
                                                    str_contains(strtolower($report->transaction_type), 'aquire') ||
                                                    str_contains(strtolower($report->transaction_type), 'validated') ?
                                                'bg-green-200 text-green-800 border-2 border-green-300' :
                                                (str_contains(strtolower($report->transaction_type), 'edit') || 
                                                    str_contains(strtolower($report->transaction_type), 'edited') ?
                                                'bg-yellow-100 text-yellow-800 border-2 border-yellow-300' : 'bg-blue-100 text-blue-800 border-2 border-blue-300'))))) }}">
                                                {{ $report->transaction_type }}
                                            </span>
                                        </td>
                                        <td class="py-2 px-4 border-b text-xs w-[190px]">{{ $report->created_at->format('M d, Y h:i A') }}</td>
                                        {{-- <td class="py-2 px-4 border-b">
                                            <span class="px-2 py-1 inline-flex text-xxs leading-4 font-semibold rounded-full 
                                                @if($report->status == 'Completed') bg-green-100 text-green-800
                                                @elseif($report->status == 'Okay') bg-blue-100 text-blue-800
                                                @elseif($report->status == 'Failed') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($report->status) }}
                                            </span>
                                        </td> --}}
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
</x-app-layout>