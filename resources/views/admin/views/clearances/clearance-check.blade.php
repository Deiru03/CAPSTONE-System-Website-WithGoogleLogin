<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Clearance Check') }}
        </h2>
    </x-slot>

    <div class="py-12">     
        <h3 class="text-3xl font-semibold mb-4 text-blue-600">User Clearance Check</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr>
                        <th class="py-3 px-4 text-left text-blue-600">User ID</th>
                        <th class="py-3 px-4 text-left text-blue-600">User Name</th>
                        <th class="py-3 px-4 text-left text-blue-600">Document Name</th>
                        <th class="py-3 px-4 text-left text-blue-600">Latest Upload Date</th>
                        <th class="py-3 px-4 text-left text-blue-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userClearances as $userClearance)
                        <tr>
                            <td class="border px-4 py-3">{{ $userClearance->user->id }}</td>
                            <td class="border px-4 py-3">{{ $userClearance->user->name }}</td>
                            <td class="border px-4 py-3">{{ $userClearance->sharedClearance->clearance->document_name }}</td>
                            <td class="border px-4 py-3">
                                {{ optional($userClearance->uploadedClearances->first())->created_at ?? 'N/A' }}
                            </td>
                            <td class="border px-4 py-3">
                                <a href="{{ route('admin.clearances.show', $userClearance->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition-colors duration-300">View Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
