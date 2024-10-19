<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Clearance Check') }}
        </h2>
    </x-slot>

    <div class="py-12">     
        <h3 class="text-3xl font-semibold mb-4 text-blue-600">User Clearance Check</h3>
        
        <!-- Search Form -->
        <div class="flex items-center mb-6">
            <form action="{{ route('admin.clearance.check') }}" method="GET" class="flex-grow mr-2">
                <div class="flex items-center">
                    <input type="text" name="search" placeholder="Search by name or ID" value="{{ request('search') }}" 
                           class="border-2 border-gray-300 bg-white h-10 px-5 pr-15 rounded-lg text-sm focus:outline-none w-64">
                    <button type="submit" class="ml-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105">
                        Search
                    </button>
                </div>
            </form>
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

        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-6 bg-gray-50 border border-gray-200 rounded-lg shadow-sm">
            <div class="col-span-full mb-4 border-b border-gray-300 pb-2 flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-700">User Clearances</h3>
                <span class="text-sm font-medium text-gray-600 bg-gray-200 px-3 py-1 rounded-full">
                    Total Users: {{ $userClearances->count() }}
                </span>
            </div>
            @foreach($userClearances as $userClearance)
                <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col items-center transform hover:scale-105 transition-transform duration-300 ease-in-out border border-gray-200">
                    <div class="w-28 h-28 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-full mb-4 flex items-center justify-center p-1">
                        @if ($userClearance->user->profile_picture)
                            <img src="{{ $userClearance->user->profile_picture }}" alt="{{ $userClearance->user->name }}" class="w-full h-full object-cover rounded-full border-4 border-white">
                        @else
                            <div class="w-full h-full flex items-center justify-center rounded-full text-white font-bold text-4xl bg-gradient-to-br from-blue-500 to-indigo-600">
                                {{ strtoupper(substr($userClearance->user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex items-center w-full mb-2">
                        <h4 class="text-xl font-semibold text-gray-800">{{ $userClearance->user->name }}</h4>
                        <div class="mx-2 flex-grow">
                            <div class="border-t border-gray-300"></div>
                        </div>
                        <p class="text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-full">ID: {{ $userClearance->user->id }}</p>
                    </div>
                    <p class="text-sm font-medium text-indigo-600 mb-1">{{ $userClearance->sharedClearance->clearance->document_name }}</p>
                    <p class="text-xs text-gray-500 mb-4">Recent Upload: {{ optional($userClearance->uploadedClearances->first())->created_at ?? 'N/A' }}</p>
                    <a href="{{ route('admin.clearances.show', $userClearance->id) }}" class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-2 rounded-full shadow-md hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 ease-in-out transform hover:-translate-y-1">View Details</a>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.getElementById('searchRequirementsBtn').addEventListener('click', function() {
            document.getElementById('requirementsModal').classList.remove('hidden');
        });

        document.getElementById('searchRequirementBtn').addEventListener('click', function() {
            const searchTerm = document.getElementById('requirementSearch').value;
            // Here you would typically make an AJAX call to your backend to search for requirements
            // For demonstration, we'll just add some dummy results
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

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('requirementsModal');
            if (event.target == modal) {
                modal.classList.add('hidden');
            }
        }
    </script>
</x-admin-layout>
