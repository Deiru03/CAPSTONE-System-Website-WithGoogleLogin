<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submitted Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium">Submitted Reports</h3>
                    <p class="mt-2">Here you can view and manage submitted reports.</p>
                    <!-- Add your Submitted Reports management content here -->

                     <!-- Filter Options -->
                     <div class="mb-4">
                        <input type="text" placeholder="Search by title..." class="border p-2 rounded">
                        <select class="border p-2 rounded">
                            <option value="">Filter by status</option>
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected</option>
                        </select>
                        <button class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
                    </div>

                    <!-- Reports Table -->
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Title</th>
                                <th class="py-2 px-4 border-b">Submitted By</th>
                                <th class="py-2 px-4 border-b">Date</th>
                                <th class="py-2 px-4 border-b">Status</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through reports -->
                           {{--}} @foreach($reports as $report)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $report->title }}</td>
                                <td class="py-2 px-4 border-b">{{ $report->submitted_by }}</td>
                                <td class="py-2 px-4 border-b">{{ $report->created_at->format('Y-m-d') }}</td>
                                <td class="py-2 px-4 border-b">{{ $report->status }}</td>
                                <td class="py-2 px-4 border-b">
                                    <button class="bg-green-500 text-white px-2 py-1 rounded">Approve</button>
                                    <button class="bg-red-500 text-white px-2 py-1 rounded">Reject</button>
                                </td>
                            </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>
    </div>
</x-admin-layout>