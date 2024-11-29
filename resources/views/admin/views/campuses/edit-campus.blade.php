<x-admin-layout>
    <x-slot name="header">
        {{ __('Edit Campus') }}
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <!-- Campus Information -->
        <div class="flex flex-col mb-4">
            <div class="flex items-center mb-4">
                <div class="bg-yellow-100 rounded-full p-3 mr-4 border-2 border-yellow-300 transition-colors duration-300 group-hover:bg-blue-100 group-hover:border-blue-300">
                    @if($campus->profile_picture)
                        <img src="{{ url('/profile_pictures/' . basename($campus->profile_picture)) }}" alt="{{ $campus->name }}" class="h-16 w-16 rounded-full object-cover">
                    @endif
                </div>
            </div>

            <h2 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-yellow-600 to-orange-600 mb-4">{{ $campus->name }}</h2>

            <div class="space-y-3">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-sm text-gray-500">{{ $campus->description }}</p>
                </div>
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <p class="text-sm text-gray-500">{{ $campus->location }}</p>
                </div>
            </div>
        </div>

        {{--
        <!-- Add Program Form -->
        <div class="mt-8">
            <h3 class="text-2xl font-semibold text-gray-800">Add Program</h3>
            <form action="{{ route('admin.campuses.addProgram', $campus->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="program_name" class="block text-sm font-medium text-gray-700 mb-1">Program Name</label>
                    <input type="text" name="name" id="program_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" required>
                </div>
                <div>
                    <label for="program_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <input type="text" name="description" id="program_description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>
                <div class="mt-4">
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-700">
                        Add Program
                    </button>
                </div>
            </form>
        </div> --}}

        <!-- Departments and Programs -->
        <div class="mt-8">
            <h3 class="text-2xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-yellow-600 to-orange-600 mb-6">Departments</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($campus->departments as $department)
                    <div class="bg-white rounded-xl shadow-lg p-6 border-2 border-yellow-300 hover:border-orange-300 transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center mb-4">
                            <div class="bg-yellow-100 rounded-full p-3 mr-4">
                                @if($department->profile_picture)
                                    <img src="{{ url('/profile_pictures/' . basename($department->profile_picture)) }}"
                                         alt="{{ $department->name }}"
                                         class="h-12 w-12 rounded-full object-cover">
                                @else
                                    <svg class="h-16 w-16 text-yellow-500 transition-colors duration-300 group-hover:text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-800">{{ $department->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $department->description }}</p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h5 class="text-lg font-semibold text-gray-800 mb-3 flex items-center cursor-pointer" onclick="togglePrograms('programs-{{ $department->id }}')">
                                <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Programs
                                <div class="flex justify-between items-center w-full">
                                    <svg class="w-4 h-4 ml-2 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                    <span class="text-sm text-gray-500">{{ $department->programs->count() }} Programs</span>
                                </div>
                            </h5>
                            <div id="programs-{{ $department->id }}" class="space-y-2 hidden">
                                @foreach($department->programs as $program)
                                    <div class="bg-gray-50 rounded-lg p-3 hover:bg-yellow-50 transition-colors duration-200 border border-yellow-200 rounded-lg p-4 hover:border-orange-300">
                                        <div class="flex flex-col space-y-2">
                                            <div class="flex justify-between items-center">
                                                <span class="font-medium text-gray-700">{{ $program->name }}</span>
                                                <span class="text-sm text-gray-500">{{ $program->description }}</span>
                                            </div>
                                            <div class="w-full">
                                                <div class="flex justify-between text-sm text-gray-500 mb-1">
                                                    <span>Clearance Progress</span>
                                                    <span>{{ $program->users->where('clearances_status', 'complete')->count() }}/{{ $program->users->count() }} Complete</span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                    <div class="bg-gradient-to-r from-yellow-500 to-orange-500 h-2.5 rounded-full" style="width: {{ ($program->users->where('clearances_status', 'complete')->count() / max($program->users->count(), 1)) * 100 }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <script>
            function togglePrograms(id) {
                const programsDiv = document.getElementById(id);
                const arrow = programsDiv.previousElementSibling.querySelector('svg:last-child');
                if (programsDiv.classList.contains('hidden')) {
                    programsDiv.classList.remove('hidden');
                    arrow.classList.add('rotate-180');
                } else {
                    programsDiv.classList.add('hidden');
                    arrow.classList.remove('rotate-180');
                }
            }
        </script>
    </div>

</x-admin-layout>
