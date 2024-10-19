<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Clearance Check') }}
        </h2>
    </x-slot>

    <div class="py-5 w-auto">     
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

        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 p-4 bg-gray-50 border border-gray-200 rounded-lg shadow-sm">
            <div class="col-span-full mb-3 border-b border-gray-300 pb-2 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-700">User Clearances</h3>
                <span class="text-xs font-medium text-gray-600 bg-gray-200 px-2 py-1 rounded-full">
                    Total Users: {{ $userClearances->count() }}
                </span>
            </div>
            @foreach($userClearances as $userClearance)
                <a href="{{ route('admin.clearances.show', $userClearance->id) }}" class="bg-white rounded-lg shadow p-3 flex flex-col items-center transform hover:scale-105 transition-transform duration-300 ease-in-out border border-gray-200">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-full mb-2 flex items-center justify-center p-1">
                        @if ($userClearance->user->profile_picture)
                            <img src="{{ $userClearance->user->profile_picture }}" alt="{{ $userClearance->user->name }}" class="w-full h-full object-cover rounded-full border-2 border-white">
                        @else
                            <div class="w-full h-full flex items-center justify-center rounded-full text-white font-bold text-xl bg-gradient-to-br from-blue-500 to-indigo-600">
                                {{ strtoupper(substr($userClearance->user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex items-center w-full mb-1">
                        <div class="mx-1 flex-grow">
                            <h4 class="text-xs font-semibold text-gray-800 truncate w-full text-center">{{ $userClearance->user->name }}</h4>
                           {{-- <p class="text-xs text-gray-600 mb-1 text-center">ID: {{ $userClearance->user->id }}</p> --}}
                        </div>
                    </div>
                    <p class="text-xs font-medium text-indigo-600 mb-1 truncate w-full text-center">{{ Str::limit($userClearance->sharedClearance->clearance->document_name, 20) }}</p>
                    <p class="text-xs text-gray-500 mb-2">Recent: {{ optional($userClearance->uploadedClearances->first())->created_at ? optional($userClearance->uploadedClearances->first())->created_at->format('m/d/Y') : 'N/A' }}</p>
                    <span class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-xs px-2 py-1 rounded-full shadow-md hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 ease-in-out transform hover:-translate-y-1">View</span>
                </a>
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
