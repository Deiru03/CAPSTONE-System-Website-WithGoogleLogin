<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Clearances Checklist') }}
        </h2>
    </x-slot>
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-3xl font-bold mb-6 text-indigo-700 border-b-2 border-indigo-200 pb-2">Shared Clearances</h2>

                <!-- User Info Section -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg border-2 border-gray-300">
                    <h3 class="text-xl font-semibold text-indigo-600 mb-4">Your Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600"><span class="font-semibold">Name:</span> {{ Auth::user()->name }}</p>
                            <p class="text-gray-600"><span class="font-semibold">Email:</span> {{ Auth::user()->email }}</p>
                            <p class="text-gray-600"><span class="font-semibold">Managed by:</span> {{ Auth::user()->checked_by }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600"><span class="font-semibold">Position:</span> {{ Auth::user()->position }}</p>
                            <p class="text-gray-600"><span class="font-semibold">Teaching Units:</span> {{ Auth::user()->units }}</p>
                            <p class="text-gray-600"><span class="font-semibold">Program:</span> {{ Auth::user()->program }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Active Clearances Section -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg border-2 border-green-300">
                    <h3 class="text-xl font-semibold text-green-600 -mb-1">Active Clearances</h3>
                    <h6 class="text-gray-600 mb-4">These are the clearances checklist that you are currently using.</h6>
                    @if($activeClearances->isEmpty())
                        <p class="text-gray-600">No active clearances at the moment.</p>
                    @else
                        <ul class="list-disc pl-5 p-2 rounded-md border-2 border-gray-300 bg-green-50">
                            @foreach($activeClearances as $activeClearance)
                                <li class="mb-2 flex items-center justify-between">
                                    <div>
                                        <span class="font-bold">{{ $activeClearance->sharedClearance->clearance->document_name }}</span> - {{ $activeClearance->sharedClearance->clearance->description }}
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('faculty.views.clearances', $activeClearance->id) }}" 
                                           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-sm rounded-md transition duration-300 ease-in-out flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 011 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                                            </svg>
                                            View
                                        </a>
                                        <button onclick="openModal('{{ $activeClearance->shared_clearance_id }}')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-sm rounded-md transition duration-300 ease-in-out flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Remove
                                        </button>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <!-- Recommendations Section -->
                @if($recommendations->isNotEmpty())
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg border-2 border-yellow-300">
                        <h3 class="text-xl font-semibold text-yellow-600 -mb-1">Recommended for You</h3>
                        <h6 class="text-gray-600 mb-4">These are the clearance checklists that are recommended for you according to your position and teaching units.</h6>
                        <ul class="list-disc pl-5 p-2 rounded-md border-2 border-gray-300 bg-yellow-50">
                            @foreach($recommendations as $recommendation)
                                <li class="mb-2">
                                    <span class="font-bold">{{ $recommendation->clearance->document_name }}</span> - {{ $recommendation->clearance->description }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- End of Recommendations Section -->


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

                @if($filteredClearances->isEmpty())
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
                    <div class="overflow-x-auto bg-white rounded-lg shadow-lg border-2 border-blue-600">
                        <div class="p-2 flex justify-between items-center">
                            <h2 class="text-xl font-semibold text-blue-600 mb-0">Available Clearances</h2>
                            <h6 class="text-gray-600 mb-0">These are the clearances checklist that are available for you to use.</h6>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gradient-to-r from-blue-600 to-blue-800">
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Document Name</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider text-center">Teaching Units</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider text-center">Type</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider text-center"># Req.</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($filteredClearances as $sharedClearance)
                                @php
                                    $userPosition = Auth::user()->position;
                                    $userUnits = Auth::user()->units;
                                    
                                    $isRecommended = false;
                                    
                                    // For Dean and Program-Head
                                    if (($userPosition === 'Dean' || $userPosition === 'Program-Head') && 
                                        $sharedClearance->clearance->type === $userPosition) {
                                        $isRecommended = true;
                                    }
                                    
                                    // For Permanent positions
                                    if (in_array($userPosition, ['Permanent-FullTime', 'Permanent-PartTime']) && 
                                        $sharedClearance->clearance->type === 'Permanent' && 
                                        $sharedClearance->clearance->units == $userUnits) {
                                        $isRecommended = true;
                                    }
                                    
                                    // For Temporary position
                                    if ($userPosition === 'Temporary' && 
                                        $sharedClearance->clearance->type === 'Temporary' && 
                                        $sharedClearance->clearance->units == $userUnits) {
                                        $isRecommended = true;
                                    }
                                    
                                    // For Part-Timer position
                                    if ($userPosition === 'Part-Timer') {
                                        if ($userUnits >= 12 && $sharedClearance->clearance->units >= 12) {
                                            $isRecommended = true;
                                        } elseif ($userUnits >= 9 && $userUnits <= 11 && 
                                                 $sharedClearance->clearance->units >= 9 && 
                                                 $sharedClearance->clearance->units <= 11) {
                                            $isRecommended = true;
                                        }
                                    }
                                @endphp
                                <tr class="hover:bg-gray-50 transition-all duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $sharedClearance->clearance->id }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900 break-words max-w-xs">{{ $sharedClearance->clearance->document_name }}</div>
                                            @if($isRecommended)
                                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Recommended
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ Str::limit($sharedClearance->clearance->description, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ $sharedClearance->clearance->units ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                            {{ $sharedClearance->clearance->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $sharedClearance->clearance->requirements->count() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex justify-center space-x-2">
                                            @if(isset($userClearances[$sharedClearance->id]))
                                                <a href="{{ route('faculty.clearances.show', $userClearances[$sharedClearance->id]) }}" 
                                                   class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200"
                                                   onclick="event.preventDefault(); window.location.href='{{ route('faculty.views.clearances', $userClearances[$sharedClearance->id]) }}';">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 011 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                                                    </svg>
                                                    View
                                                </a>
                                                <button onclick="openModal('{{ $sharedClearance->id }}')" 
                                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Remove
                                                </button>
                                            @else
                                                @if(!$hasAnyCopy)
                                                    <form action="{{ route('faculty.clearances.getCopy', $sharedClearance->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
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