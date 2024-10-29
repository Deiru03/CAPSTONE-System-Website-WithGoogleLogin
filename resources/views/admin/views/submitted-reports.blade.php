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
                                <th class="py-2 px-4 border-b">User</th>
                                <th class="py-2 px-4 border-b">Title</th>
                                <th class="py-2 px-4 border-b">Transaction Type</th>
                                <th class="py-2 px-4 border-b">Status</th>
                                <th class="py-2 px-4 border-b">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $report->admin_name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $report->title }}</td>
                                    <td class="py-2 px-4 border-b">{{ $report->transaction_type }}</td>
                                    <td class="py-2 px-4 border-b">{{ $report->status }}</td>
                                    <td class="py-2 px-4 border-b">{{ $report->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>
    </div>
</x-admin-layout>