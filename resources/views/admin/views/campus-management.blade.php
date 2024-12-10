<x-admin-layout>
    <x-slot name="header">
        {{ __('Campus Management') }} <!-- Set the header content here -->
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="mb-8 flex justify-between items-center bg-gradient-to-r from-yellow-50 to-orange-50 p-6 rounded-xl shadow-lg border border-yellow-200">
            <div class="relative">
                <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-yellow-600 to-orange-600">
                    Manage Campuses
                </h2>
                <div class="h-1 w-full bg-gradient-to-r from-yellow-400 to-orange-400 rounded-full mt-2 animate-pulse"></div>
                <div class="space-y-2 mt-2">
                    <p class="text-sm text-gray-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Total Affiliated Users: <span class="font-semibold text-yellow-600 ml-1">{{ $totalUsers }}</span>
                    </p>
                    <p class="text-sm text-gray-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Total Campuses: <span class="font-semibold text-yellow-600 ml-1">{{ $campuses->count() }}</span>
                    </p>
                    <p class="text-sm text-gray-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                        </svg>
                        Total Departments: <span class="font-semibold text-yellow-600 ml-1">{{ $campuses->sum(function($campus) { return $campus->departments->count(); }) }}</span>
                    </p>
                    <p class="text-sm text-gray-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Total Programs: <span class="font-semibold text-yellow-600 ml-1">{{ $campuses->sum(function($campus) { return $campus->departments->sum(function($dept) { return $dept->programs->count(); }); }) }}</span>
                    </p>
                </div>
            </div>
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full blur opacity-30 group-hover:opacity-100 transition duration-1000 group-hover:duration-200 animate-tilt"></div>
                <button onclick="openModal('campusModal')" class="relative bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-bold py-3 px-6 rounded-full transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add Campus
                </button>
            </div>
        </div>

        <!-- Notification -->
        <div id="notification" role="alert" class="hidden fixed top-0 right-0 m-6 p-4 rounded-lg shadow-lg transition-all duration-500 transform translate-x-full z-50">
            <div class="flex items-center">
                <div id="notificationIcon" class="flex-shrink-0 w-6 h-6 mr-3"></div>
                <div id="notificationMessage" class="text-sm font-medium"></div>
            </div>
        </div>

        <!-- Campuses List -->
        <div class="mt-8 ">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($campuses as $campus)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 border-2 border-orange-300 hover:border-blue-300">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-yellow-100 rounded-full p-3 mr-4 border-2 border-yellow-300 transition-colors duration-300 group-hover:bg-blue-100 group-hover:border-blue-300">
                                    @if($campus->profile_picture)
                                        <img src="{{ url('/profile_pictures/' . basename($campus->profile_picture)) }}" alt="{{ $campus->name }}" class="h-16 w-16 rounded-full object-cover">
                                    @else
                                        <svg class="h-16 w-16 text-yellow-500 transition-colors duration-300 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800">{{ $campus->name }}</h3>
                                    <p class="text-gray-600">{{ $campus->location }}</p>
                                </div>
                            </div>
                            <div class="mb-4">
                                <h4 class="text-lg font-semibold text-gray-800">Clearance Progress:</h4>
                                <div class="w-full bg-gray-200 rounded-full h-4">
                                    <div class="bg-green-500 h-4 rounded-full" style="width: {{ $campus->completeCount / max($campus->users->count(), 1) * 100 }}%"></div>
                                </div>
                                <p class="text-sm text-gray-600 mt-2">
                                    Complete: {{ $campus->completeCount }} / {{ $campus->users->count() }} users
                                </p>
                            </div>
                            @if(Auth::user()->user_type === 'Admin' && !Auth::user()->campus_id)
                                <div class="flex space-x-2">
                                    <button onclick="openConfirmModal('removeCampus', '{{ $campus->id }}')" class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-3 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center shadow-md hover:bg-gradient-to-r hover:from-red-500 hover:to-pink-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span class="ml-1">Remove</span>
                                    </button>
                                    <button onclick="openEditCampusModal('{{ $campus->id }}')" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-3 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center shadow-md hover:bg-gradient-to-r hover:from-yellow-500 hover:to-orange-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span class="ml-1">Edit</span>
                                    </button>
                                </div>
                            @endif
                            <a href="{{ route('admin.campuses.show', $campus->id) }}" class="mt-2 w-full bg-green-400 hover:bg-green-500 text-white font-bold py-2 px-3 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center shadow-md hover:bg-gradient-to-r hover:from-green-400 hover:to-green-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span class="ml-1">View</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Add Campus Modal -->
        <div id="campusModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-70 hidden z-10 transition-opacity duration-300">
            <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full relative overflow-hidden duration-300 scale-95 hover:scale-100">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-400 to-indigo-500"></div>
                <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Add Campus
                </h3>
                <form action="{{ route('admin.campuses.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
                            <input type="file" name="profile_picture" id="profile_picture" accept="image/*" onchange="previewImage(event)" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                            <div class="mt-2 flex justify-center items-center">
                                <div class="relative group">
                                    <img id="preview_image" src="#" alt="Preview" class="hidden h-32 w-32 object-cover rounded-full border-2 border-gray-300">
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Campus Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" required>
                        </div>
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                            <input type="text" name="location" id="location" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" required>
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <input type="text" name="description" id="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end space-x-4">
                        <button type="button" onclick="closeModal('campusModal')" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Campus
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Campus Modal -->
        <div id="editCampusModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-70 hidden z-10 transition-opacity duration-300">
            <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full relative overflow-hidden duration-300 scale-95 hover:scale-100">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-yellow-400 to-orange-500"></div>
                <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Campus
                </h3>
                <form id="editCampusForm" method="POST" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div class="relative">
                            <label for="edit_profile_picture" class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
                            <div class="flex justify-center items-center">
                                <div class="relative group">
                                    <img id="edit_preview_image" src="#" alt="Preview" class="h-32 w-32 object-cover rounded-full border-2 border-gray-300">
                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-full">
                                        <label for="edit_profile_picture" class="text-white cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Edit
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <input type="file" name="profile_picture" id="edit_profile_picture" accept="image/*" onchange="previewEditImage(event)" class="hidden">
                        </div>
                        <div>
                            <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-1">Campus Name</label>
                            <input type="text" name="name" id="edit_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-150 ease-in-out" required>
                        </div>
                        <div>
                            <label for="edit_location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                            <input type="text" name="location" id="edit_location" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-150 ease-in-out" required>
                        </div>
                        <div>
                            <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <input type="text" name="description" id="edit_description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-150 ease-in-out">
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end space-x-4">
                        <button type="button" onclick="closeModal('editCampusModal')" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-3 bg-yellow-600 text-white rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-yellow-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Update Campus
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Confirm Modal -->
        <div id="confirmModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-70 hidden z-10">
            <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full">
                <h3 class="text-2xl font-bold mb-4 text-gray-800">
                    Confirm Action
                </h3>
                <div class="space-y-4">
                    <p class="text-sm text-gray-500" id="confirmMessage">
                        Are you sure you want to perform this action?
                    </p>
                </div>
                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" onclick="closeModal('confirmModal')" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel
                    </button>
                    <button type="button" id="confirmButton" class="px-6 py-3 bg-red-600 text-white rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>

        // Modal functions
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function previewEditImage(event) {
            const preview = document.getElementById('edit_preview_image');
            const file = event.target.files[0];

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        }
        // Confirm modal functions
        function openConfirmModal(action, id) {
            const modal = document.getElementById('confirmModal');
            const confirmButton = document.getElementById('confirmButton');
            const message = document.getElementById('confirmMessage');

            if (action === 'removeCampus') {
                message.textContent = 'Are you sure you want to remove this campus?';
                confirmButton.onclick = () => deleteCampus(id);
            }

            modal.classList.remove('hidden');
        }

        // Delete campus function
        function deleteCampus(id) {
            fetch(`/admin/campuses/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                closeModal('confirmModal');
                showNotification(data.success, 'success');
                // Force reload after short delay to ensure notification is seen
                setTimeout(() => {
                    window.location.href = '/admin/campuses';
                }, 1500);
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error deleting campus', 'error');
            });
        }

        // Edit campus modal function
        function openEditCampusModal(id) {
            fetch(`/admin/campuses/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_name').value = data.name;
                    document.getElementById('edit_location').value = data.location;
                    document.getElementById('edit_description').value = data.description;

                     // Set the preview image source
                    const preview = document.getElementById('edit_preview_image');
                    if (data.profile_picture) {
                        preview.src = `/profile_pictures/${data.profile_picture.split('/').pop()}`;
                        preview.classList.remove('hidden');
                    } else {
                        preview.src = '/images/default-profile.png';
                        preview.classList.remove('hidden');
                    }


                    // Set the form action to the update route
                    const form = document.getElementById('editCampusForm');
                    form.action = `/admin/campuses/${id}`;

                    openModal('editCampusModal');
                })
                .catch(error => console.error('Error:', error));
        }

        // Notification functions
        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            const notificationMessage = document.getElementById('notificationMessage');
            const notificationIcon = document.getElementById('notificationIcon');

            notificationMessage.textContent = message;
            notification.classList.remove('hidden', 'translate-x-full');
            notification.classList.add('translate-x-0');

            if (type === 'success') {
                notification.classList.add('bg-green-500', 'text-white');
                notificationIcon.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
            } else {
                notification.classList.add('bg-red-500', 'text-white');
                notificationIcon.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            }

            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    notification.classList.add('hidden');
                }, 300);
            }, 3000);
        }
    </script>
</x-admin-layout>
