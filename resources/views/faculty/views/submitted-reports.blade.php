<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submitted Reports') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl rounded-lg">
                <div class="p-8">
                    <h3 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-4">Submitted Reports</h3>
                    <p class="text-gray-600 mb-8 text-lg">Here you can view your submitted reports and their current status.</p>
                    
                    <!-- Reports Table -->
                    <div class="overflow-x-auto bg-gray-50 rounded-xl shadow-inner">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gradient-to-r from-blue-500 to-purple-600 text-white">
                                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Details</th>

                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Loop through reports -->
                                @foreach($reports as $report)
                                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $report->title }}</div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $report->created_at->format('M d, Y') }}</div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($report->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($report->status == 'Upload') bg-green-100 text-green-800
                                            @elseif($report->status == 'Delete') bg-red-100 text-red-800
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
                                    {{ $reports->where('status', 'Upload')->count() }}
                                </dd>
                            </div>
                        </div>
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Deleted Files Count
                                </dt>
                                <dd class="mt-1 text-3xl font-semibold text-red-600">
                                    {{ $reports->where('status', 'Delete')->count() }}
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</x-app-layout>