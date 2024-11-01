<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Clearance Check') }}
        </h2>
    </x-slot>

    <!-- Notification component -->
    <div id="notification" class="hidden fixed bottom-4 right-4 p-3 bg-green-100 text-green-700 rounded-lg shadow-lg transition-opacity duration-300 ease-in-out z-50">
        <p id="notificationMessage" class="font-semibold"></p>
    </div>

    {{-- <!-- Loading overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-white"></div>
    </div> --}}

    <!-- Error Modal -->
    @if(session('error'))
        <div id="errorModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-10 animate-fade-in">
            <div class="bg-white p-5 rounded-lg shadow-xl max-w-sm mx-auto transform transition-all duration-300 ease-in-out animate-slide-in">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900">Error</h3>
                </div>
                <p class="text-sm text-gray-600 mb-4">{{ session('error') }}</p>
                <button onclick="closeErrorModal()" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full transition duration-300 ease-in-out">
                    Close
                </button>
            </div>
        </div>
        <script>
            function closeErrorModal() {
                const modal = document.getElementById('errorModal');
                modal.classList.add('animate-fade-out');
                setTimeout(() => {
                    modal.style.display = 'none';
                    modal.classList.remove('animate-fade-out');
                }, 300);
            }

            setTimeout(closeErrorModal, 5000);
        </script>
        <style>
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            @keyframes slideIn {
                from { transform: translateY(-20px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }
            @keyframes fadeOut {
                from { opacity: 1; }
                to { opacity: 0; }
            }
            .animate-fade-in {
                animation: fadeIn 0.3s ease-out;
            }
            .animate-slide-in {
                animation: slideIn 0.3s ease-out;
            }
            .animate-fade-out {
                animation: fadeOut 0.3s ease-in;
            }
        </style>
    @endif

    <div class="py-5 w-auto">     
        <h3 class="text-3xl font-semibold mb-4 text-blue-600">User Clearance Check</h3>
        
        <!-- Search Form -->
        <div class="flex items-center mb-6">
            <form action="{{ route('admin.clearance.search') }}" method="GET" class="flex-grow mr-2">
                <div class="flex items-center">
                    <input type="text" name="search" placeholder="Search by name or ID" value="{{ request('search') }}" 
                           class="border-2 border-gray-300 bg-white h-10 px-5 pr-15 rounded-lg text-sm focus:outline-none w-64">
                    <button type="submit" class="ml-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105">
                        Search
                    </button>
                </div>
            </form>
            <button id="resetButton" class="bg-red-500 hover:bg-red-700  text-white font-bold py-2 px-4 rounded ml-2 transition duration-300 ease-in-out transform hover:scale-105">
                Reset User Clearances
            </button>
            <button type="button" id="searchRequirementsBtn" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 rounded ml-2 transition duration-300 ease-in-out transform hover:scale-105">
                Search Requirements
            </button>
        </div>

        <!-- Modal for Requirements Search -->
        <div id="requirementsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden shadow-lg">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Search Requirements</h3>
                    <div class="mt-2 px-7 py-3">
                        <input type="text" id="requirementSearch" placeholder="Enter requirement name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    <div class="items-center px-4 py-3">
                        <button id="searchRequirementBtn" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            Search
                        </button>
                    </div>
                    <div class="mt-2 px-7 py-3">
                        <ul id="requirementResults" class="list-disc list-inside text-left"></ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Clearances -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 p-4 bg-gray-50 border border-gray-200 rounded-lg shadow-sm">
            <div class="col-span-full mb-3 border-b border-gray-300 pb-2 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-700">User Clearances</h3>
                <span class="text-xs font-medium text-gray-600 bg-gray-200 px-2 py-1 rounded-full">
                    Total Users: {{ $users->count() }}
                </span>
            </div>
            @forelse($users as $user)
                <a href="{{ route('admin.clearances.show', $user->id) }}" class="bg-white rounded-lg shadow p-3 flex flex-col items-center transform hover:scale-105 transition-transform duration-300 ease-in-out border border-gray-200">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-full mb-2 flex items-center justify-center p-1">
                        @if ($user->profile_picture)
                            <img src="{{ $user->profile_picture }}" alt="{{ $user->name }}" class="w-full h-full object-cover rounded-full border-2 border-white">
                        @else
                            <div class="w-full h-full flex items-center justify-center rounded-full text-white font-bold text-xl bg-gradient-to-br from-blue-500 to-indigo-600">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex items-center w-full mb-1">
                        <div class="mx-1 flex-grow">
                            <h4 class="text-xs font-semibold text-gray-800 truncate w-full text-center">{{ $user->name }}</h4>
                        </div>
                    </div>
                    <p class="text-xs font-medium text-indigo-600 mb-1 truncate w-full text-center">
                        @if($user->userClearances->isEmpty())
                            {{ 'Checklist not yet acquired' }}
                        @else
                            {{ Str::limit(optional($user->userClearances->first()->sharedClearance->clearance)->document_name, 20) }}
                        @endif
                    </p>
                    <p class="text-xs text-gray-500 mb-2">
                        @if($user->userClearances->isNotEmpty())
                            @php
                                $userClearance = $user->userClearances->first();
                                $latestUpload = $userClearance->uploadedClearances
                                    ->where('is_archived', false)
                                    ->sortByDesc('created_at')
                                    ->first();
                                
                                $hasComplied = false;
                                if ($latestUpload) {
                                    $feedback = $latestUpload->requirement->feedback
                                        ->where('user_id', $user->id)
                                        ->where('is_archived', false)
                                        ->first();
                                    $hasComplied = $feedback && 
                                        $feedback->signature_status == 'Return' && 
                                        $latestUpload->created_at > $feedback->updated_at;
                                }
                            @endphp
                            @if($latestUpload)
                                Recent: {{ $latestUpload->created_at->format('m/d/Y') }}
                                @if($hasComplied)
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-blue-100 text-blue-800 ml-1">Complied</span>
                                @endif
                            @else
                                Recent: N/A
                            @endif
                        @else
                            Recent: N/A
                        @endif
                    </p>
                    <span class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-xs px-2 py-1 rounded-full shadow-md hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 ease-in-out transform hover:-translate-y-1">View</span>
                </a>
            @empty
                <p class="text-center text-gray-600 col-span-full">No clearances to check available.</p>
            @endforelse
        </div>
    </div>

    <!-- Reset User Modal -->
    <div id="resetUserModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-30 backdrop-blur-sm hidden transition-opacity duration-300">
        <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full relative overflow-hidden duration-300 scale-95 hover:scale-100">
            <div class="absolute top-0 left-0 w-full h-3 bg-gradient-to-r from-red-400 to-red-500"></div>
            <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Reset User Clearances
            </h3>
            <form id="resetUserForm">
                <div class="max-h-96 overflow-y-auto mb-6">
                    @foreach($users as $user)
                        <div class="flex items-center mb-2 p-2 hover:bg-gray-200 rounded-lg transition duration-200 cursor-pointer" onclick="document.getElementById('checkbox-{{ $user->id }}').click()">
                            <input type="checkbox" id="checkbox-{{ $user->id }}" name="user_ids[]" value="{{ $user->id }}" class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500" onclick="event.stopPropagation()">
                            <div class="flex items-center ml-3">
                                <div class="w-8 h-8 rounded-full overflow-hidden mr-2">
                                    @if ($user->profile_picture)
                                        <img src="{{ $user->profile_picture }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-600 font-semibold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm text-gray-700 font-medium">{{ $user->name }}</label>
                                    <div class="mt-0">
                                        <span class="text-xs px-2 py-1 rounded-full {{ $user->clearances_status === 'complete' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                            {{ $user->clearances_status === 'complete' ? 'Checklist Ready for Reset' : 'Checklist Not Yet Done' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeResetModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel
                    </button>
                    <button type="button" id="confirmResetButton" class="px-6 py-3 bg-red-600 text-white rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset Selected
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Confirm Reset</h3>
            <p class="text-sm text-gray-600 mb-6">Are you sure you want to reset the selected user clearances?</p>
            <div class="flex justify-end">
                <button id="cancelButton" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                    Cancel
                </button>
                <button id="confirmButton" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                    Confirm
                </button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchRequirementsBtn').addEventListener('click', function() {
            document.getElementById('requirementsModal').classList.remove('hidden');
        });

        document.getElementById('searchRequirementBtn').addEventListener('click', function() {
            const searchTerm = document.getElementById('requirementSearch').value;
            const results = [
                'Requirement 1 matching "' + searchTerm + '"',
                'Requirement 2 matching "' + searchTerm + '"',
                'Requirement 3 matching "' + searchTerm + '"'
            ];
            const resultsList = document.getElementById('requirementResults');
            resultsList.innerHTML = '';
            results.forEach(result => {
                const li = document.createElement('li');
                li.textContent = result;
                resultsList.appendChild(li);
            });
        });

        window.onclick = function(event) {
            const modal = document.getElementById('requirementsModal');
            if (event.target == modal) {
                modal.classList.add('hidden');
            }
        }

    ////// Reset Functions Script //////
  
        document.getElementById('resetButton').addEventListener('click', function() {
            document.getElementById('resetUserModal').classList.remove('hidden');
        });

        document.getElementById('confirmResetButton').addEventListener('click', function() {
            const form = document.getElementById('resetUserForm');
            const formData = new FormData(form);
            const userIds = formData.getAll('user_ids[]');

            if (userIds.length === 0) {
                showNotification('Please select at least one user.', false);
                return;
            }

            // Show confirmation modal instead of confirm()
            document.getElementById('resetUserModal').classList.add('hidden');
            document.getElementById('confirmationModal').classList.remove('hidden');
        });

        // Handle confirmation modal buttons
        document.getElementById('cancelButton').addEventListener('click', function() {
            document.getElementById('confirmationModal').classList.add('hidden');
            document.getElementById('resetUserModal').classList.remove('hidden');
        });

        document.getElementById('confirmButton').addEventListener('click', function() {
            const form = document.getElementById('resetUserForm');
            const formData = new FormData(form);
            const userIds = formData.getAll('user_ids[]');

            document.getElementById('confirmationModal').classList.add('hidden');

            fetch('{{ route('admin.clearance.resetSelected') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ user_ids: userIds })
            })
            .then(response => response.json())
            .then(data => {

                if (data.success) {
                    showNotification('Selected user clearances reset successfully.', true);
                    location.reload();
                } else {
                    showNotification('Failed to reset user clearances.', false);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred.', false);
            });
        });

        function closeResetModal() {
            document.getElementById('resetUserModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target == document.getElementById('resetUserModal')) {
                document.getElementById('resetUserModal').classList.add('hidden');
            }
            if (event.target == document.getElementById('confirmationModal')) {
                document.getElementById('confirmationModal').classList.add('hidden');
            }
        }
    </script>
   

    <script>
       function showNotification(message, isSuccess = true) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.classList.remove('hidden');
            notification.classList.toggle('bg-green-100', isSuccess);
            notification.classList.toggle('text-green-700', isSuccess);
            notification.classList.toggle('bg-red-100', !isSuccess);
            notification.classList.toggle('text-red-700', !isSuccess);

            // Hide notification after 3 seconds
            setTimeout(() => {
                notification.classList.add('hidden');
            }, 3000);
        }

        // // Loading Overlay Functions
        // function showLoading() {
        //     document.getElementById('loadingOverlay').classList.remove('hidden');
        // }

        // function hideLoading() {
        //     document.getElementById('loadingOverlay').classList.add('hidden');
        // }
    </script>
</x-admin-layout>