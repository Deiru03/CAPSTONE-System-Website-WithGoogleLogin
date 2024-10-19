<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Original Content -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('profile.edit') }}" class="bg-green-500 text-white p-4 rounded-lg shadow relative hover:bg-green-600 transition duration-300 ease-in-out cursor-pointer transform hover:scale-105 hover:shadow-lg">
                    <div>
                        <h3 class="text-lg font-bold">Profile</h3>
                        <p class="text-sm mt-2">View and edit your profile information</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50 transition-transform duration-300 ease-in-out transform hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>

                <a href="{{ route('faculty.views.clearances') }}" class="bg-purple-500 text-white p-4 rounded-lg shadow relative hover:bg-purple-600 transition duration-300 ease-in-out cursor-pointer transform hover:scale-105 hover:shadow-lg">
                    <div>
                        <h3 class="text-lg font-bold">View Checklist </h3>
                        <p class="text-sm mt-2">Check your clearance and uploaded files</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50 transition-transform duration-300 ease-in-out transform hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </a>

                <a href="{{ route('faculty.views.myFiles') }}" class="block bg-blue-500 text-white p-4 rounded-lg shadow relative hover:bg-blue-600 transition duration-300 ease-in-out cursor-pointer transform hover:scale-105 hover:shadow-lg">
                    <div>
                        <h3 class="text-lg font-bold">Manage My Files</h3>
                        <p class="text-sm mt-2">View and manage your uploaded files</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50 transition-transform duration-300 ease-in-out transform hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </a>

                <a href="{{ route('faculty.views.submittedReports') }}" class="block bg-yellow-500 text-white p-4 rounded-lg shadow relative hover:bg-yellow-600 transition duration-300 ease-in-out cursor-pointer transform hover:scale-105 hover:shadow-lg">
                    <div>
                        <h3 class="text-lg font-bold">Submitted History</h3>
                        <p class="text-sm mt-2">View your submission history</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50 transition-transform duration-300 ease-in-out transform hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </a>
            </div>

            <!-- New Clearance Status Overview -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Clearance Status Overview</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-blue-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800">Total Requirements</h4>
                            <p class="text-2xl font-bold text-blue-600">{{ $totalRequirements }}</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800">Uploaded Requirements</h4>
                            <p class="text-2xl font-bold text-green-600">{{ $uploadedRequirements }}</p>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-yellow-800">Missing Requirements</h4>
                            <p class="text-2xl font-bold text-yellow-600">{{ $missingRequirements }}</p>
                        </div>
                        <div class="bg-red-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-red-800">Returned Documents</h4>
                            <p class="text-2xl font-bold text-red-600">{{ $returnedDocuments }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for First-Time Users -->
            @if($showProfileModal)
                <div id="profileModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
                    <div class="bg-white p-8 rounded-xl shadow-2xl max-w-md mx-auto transform transition-all duration-300 ease-in-out hover:scale-105">
                        <h3 class="text-2xl font-bold mb-6 text-indigo-600">Complete Your Profile</h3>
                        <p class="mb-6 text-gray-600 leading-relaxed">Please update your profile with your program and position information to enhance your experience.</p>
                        <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">
                            <a href="{{ route('profile.edit') }}" class="w-full sm:w-auto bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                                Edit Profile
                            </a>
                            <button onclick="closeModal()" class="w-full sm:w-auto bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-md">
                                Close
                            </button>
                        </div>
                    </div>
                </div>

                <script>
                    function closeModal() {
                        document.getElementById('profileModal').style.display = 'none';
                    }
                </script>
            @endif
        </div>
    </div>
</x-app-layout>
