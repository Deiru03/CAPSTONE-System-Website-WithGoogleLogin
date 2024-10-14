<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Clearances Checklist') }}
        </h2>
    </x-slot>
    <div class="container mx-auto px-4 py-8 bg-gray-100">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-3xl font-bold mb-6 text-indigo-700 border-b-2 border-indigo-200 pb-2">Shared Clearances</h2>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md shadow">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-md shadow">
                        {{ session('error') }}
                    </div>
                @endif

                @if($sharedClearances->isEmpty())
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded-md shadow-md">
                        <div class="flex items-center">
                            <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <p class="font-semibold">No clearances shared yet</p>
                        </div>
                        <p class="mt-2 text-sm">No clearances have been shared with you at this time. Check back later or contact your administrator if you believe this is an error.</p>
                    </div>
                @else
                    @php
                        $userClearancesCollection = collect($userClearances);
                        $hasAnyCopy = $userClearancesCollection->isNotEmpty();
                    @endphp
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300 shadow-sm rounded-lg overflow-hidden">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document Name</th>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Units</th>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($sharedClearances as $sharedClearance)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $sharedClearance->clearance->id }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $sharedClearance->clearance->document_name }}</td>
                                    <td class="px-4 py-3">{{ Str::limit($sharedClearance->clearance->description, 50) }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-center">{{ $sharedClearance->clearance->units }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $sharedClearance->clearance->type }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex justify-center space-x-2">
                                            @if(isset($userClearances[$sharedClearance->id]))
                                                <a href="{{ route('faculty.clearances.show', $userClearances[$sharedClearance->id]) }}" 
                                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-sm rounded-md transition duration-300 ease-in-out flex items-center"
                                                   onclick="event.preventDefault(); window.location.href='{{ route('faculty.views.clearances', $userClearances[$sharedClearance->id]) }}';">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    View
                                                </a>
                                                <button onclick="openModal('{{ $sharedClearance->id }}')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-sm rounded-md transition duration-300 ease-in-out flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Remove
                                                </button>
                                            @else
                                                @if(!$hasAnyCopy)
                                                    <form action="{{ route('faculty.clearances.getCopy', $sharedClearance->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 text-sm rounded-md transition duration-300 ease-in-out flex items-center">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                                                            </svg>
                                                            Get Copy
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3 shadow-xl">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Confirm Removal</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to remove this clearance?</p>
            <div class="flex justify-end mt-4">
                <button id="cancelButton" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md mr-2 transition duration-300 ease-in-out" onclick="closeModal()">Cancel</button>
                <form id="removeForm" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition duration-300 ease-in-out">Remove</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentClearanceId = null;

        function openModal(clearanceId) {
            currentClearanceId = clearanceId;
            document.getElementById('confirmationModal').classList.remove('hidden');
            document.getElementById('removeForm').action = `/faculty/clearances/remove-copy/${clearanceId}`;
        }

        function closeModal() {
            document.getElementById('confirmationModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
