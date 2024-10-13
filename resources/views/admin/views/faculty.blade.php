<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Faculty') }}
        </h2>
    </x-slot>

    <style>
        /* Set a maximum height for the modal content and enable overflow scrolling */
        .modal-content {
            max-height: 80vh; /* Adjust the height as needed */
            overflow-y: auto;
        }

        /* Sticky header styles */
        .sticky-header {
        position: sticky;
        top: 0;
        background-color: rgb(228, 250, 255); /* Background color to cover content below */
        z-index: 10; /* Ensure it stays above other content */
        }

        /* Ensure the table has a defined height */
        .table-container {
            max-height: 400px; /* Adjust as needed */
            overflow-y: auto; /* Enable vertical scrolling */
        }
           /* Add sticky header styles for the modal */
        .modal-header {
            position: sticky;
            top: 0;
            background-color: white; /* Adjust as needed */
            z-index: 20; /* Ensure it stays above other content */
        }
        #editModal {
            z-index: 1000; /* Ensure the modal is above other content */
            margin: 0px; /* Add some margin to avoid overlap */
        }
        #deleteModal {
            z-index: 1000; /* Ensure the modal is above other content */
            margin: 0px; /* Add some margin to avoid overlap */
        }
        /* Background overlay */
        .bg-gray-500 {
            background-color: rgba(0, 0, 0, 0.5); /* Adjust opacity */
        }
        .loader {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #3498db;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 shadow-lg border border-gray-300">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-4">Faculty Management</h2>
                <p>Here you can manage Faculty members.</p>
                <!-- Add your Faculty management content here -->
                <form method="GET" action="{{ route('admin.views.faculty') }}" class="mb-4 flex items-center">
                    <input type="text" name="search" placeholder="Search by name, email, program, units, or position..." value="{{ request('search') }}" class="border rounded p-2 mr-2 w-1/2">
                    <select name="sort" class="border rounded p-2 mr-2 w-40">
                        <option value="" disabled selected>Sort name</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A to Z</option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z to A</option>
                    </select>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Apply</button>
                </form>
            </div>
            
            <!-- Faculty Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 max-w-full">
                <div class="table-container overflow-x-auto" style="max-height: 490px; max-width: 1200px;">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-200 sticky-header">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Units</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Account<br>Type</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200"> 
                            @foreach ($faculty as $member)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $member->id }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $member->name }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $member->email }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $member->program }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-center">{{ $member->units }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $member->position }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-center">{{ $member->user_type }}</td>
                                <td class="py-2 px-3 border-b">
                                    <button onclick="openEditModal({{ $member->id }})" class="text-blue-500 flex items-center text-xs">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                        Edit
                                    </button>
                                    <button 
                                        onclick="openDeleteModal({{ $member->id }}, '{{ addslashes($member->name) }}')" 
                                        class="text-red-500 ml-2 flex items-center text-xs">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H3a1 1 0 000 2h1v10a2 2 0 002 2h8a2 2 0 002-2V6h1a1 1 0 100-2h-2V3a1 1 0 00-1-1H6zm3 4a1 1 0 112 0v8a1 1 0 11-2 0V6z" clip-rule="evenodd" />
                                        </svg>
                                        Dispose
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>     
                <div class="mt-4">
                    {{ $faculty->links() }}
                </div>
            </div>
        </div>
  

        <!-- Edit Modal -->
        <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
            <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full relative">
                <h3 class="text-2xl font-semibold mb-4 text-gray-800">Edit Faculty</h3>
                <form id="editForm" method="POST" action="{{ route('admin.faculty.edit') }}">
                    @csrf
                    <input type="hidden" name="id" id="editId">
                    <!-- Other form fields -->
                    <div class="space-y-4">
                        <div>
                            <label for="editName" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="editName" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm transition duration-300 ease-in-out transform hover:scale-105 focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                        </div>
                        <div>
                            <label for="editEmail" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="editEmail" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm transition duration-300 ease-in-out transform hover:scale-105 focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                        </div>
                        <div>
                            <label for="editProgram" class="block text-sm font-medium text-gray-700">Program</label>
                            <input type="text" name="program" id="editProgram" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm transition duration-300 ease-in-out transform hover:scale-105 focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                        </div>
                        <div>
                            <label for="editUnits" class="block text-sm font-medium text-gray-700">Units</label>
                            <input type="number" name="units" id="editUnits" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm transition duration-300 ease-in-out transform hover:scale-105 focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label for="editPosition" class="block text-sm font-medium text-gray-700">Status/Position</label>
                            <select name="position" id="editPosition" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm transition duration-300 ease-in-out transform hover:scale-105 focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                                <option value="Permanent">Permanent</option>
                                <option value="Part-Timer">Part-Timer</option>
                                <option value="Temporary">Temporary</option>
                            </select>
                        </div>
                        <div>
                            <label for="editUserType" class="block text-sm font-medium text-gray-700">Account Type</label>
                            <select name="user_type" id="editUserType" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm transition duration-300 ease-in-out transform hover:scale-105 focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                                <option value="admin">Admin</option>
                                <option value="faculty">Faculty</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-gray-300 rounded-md transition duration-300 ease-in-out transform hover:scale-105 hover:bg-gray-200">Cancel</button>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md bg-green-600 text-white transition duration-300 ease-in-out transform hover:scale-105 hover:bg-green-700">Save</button>
                    </div>
                </form>
                <div id="editNotification" class="hidden mt-2 text-green-600"></div>
                
                <!-- Loader for Edit Modal -->
                <div id="editLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-75">
                    <div class="loader"></div>
                </div>
            </div>
        </div>
    
        <!-- Delete Modal -->
        <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
            <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full relative">
                <h3 class="text-2xl font-semibold mb-4 text-gray-800">Confirm Deletion</h3>
                <p class="mb-6">Are you sure you want to delete <span id="facultyName" class="font-bold"></span>?</p>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 border border-gray-300 rounded-md">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Delete</button>
                    </div>
                </form>
                <div id="deleteNotification" class="hidden mt-2 text-red-600 bg-red-100 p-2 rounded">
                    <!-- Notification message will appear here -->
                </div>
                <!-- Loader (optional) -->
                <div id="loader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-75">
                    <div class="loader"></div>
                </div>
            </div>
        </div>


    <!--////////////////////// Edit Modal //////////////////////-->
    <script>
         // Delete Functionality
        let currentDeleteId;

        function openDeleteModal(id, name) {
            currentDeleteId = id;
            document.getElementById('facultyName').innerText = name;
            document.getElementById('deleteForm').action = `/admin/faculty/delete/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        document.getElementById('deleteForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Show loader if it exists
            const deleteLoader = document.getElementById('loader');
            if (deleteLoader) {
                deleteLoader.classList.remove('hidden');
            }

            fetch(this.action, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                // Hide loader if it exists
                if (deleteLoader) {
                    deleteLoader.classList.add('hidden');
                }

                if (data.success) {
                    // Close the modal
                    closeDeleteModal();

                    // Show success alert
                    alert(data.message);

                    // Auto-reload after 3 seconds
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                } else {
                    // Show error alert
                    alert(data.message);
                }
            })
            .catch(error => {
                // Hide loader if it exists
                if (deleteLoader) {
                    deleteLoader.classList.add('hidden');
                }

                console.error('There was a problem with the delete operation:', error);
                alert('An error occurred while deleting.');
            });
        });

        // Edit Functionality
        let currentEditId;

        function openEditModal(id) {
            currentEditId = id;
            // Fetch faculty data and populate the form
            fetch(`/admin/faculty/edit/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Populate the form fields with fetched data
                    document.getElementById('editId').value = data.faculty.id;
                    document.getElementById('editName').value = data.faculty.name;
                    document.getElementById('editEmail').value = data.faculty.email;
                    document.getElementById('editProgram').value = data.faculty.program;
                    document.getElementById('editUnits').value = data.faculty.units;
                    document.getElementById('editPosition').value = data.faculty.position;
                    document.getElementById('editUserType').value = data.faculty.user_type;
                    // Set the form action to the edit route
                    document.getElementById('editForm').action = `/admin/faculty/edit`;

                    // Open the edit modal
                    document.getElementById('editModal').classList.remove('hidden');
                } else {
                    alert('Failed to fetch faculty data.');
                }
            })
            .catch(error => {
                console.error('There was a problem fetching faculty data:', error);
                alert('An error occurred while fetching faculty data.');
            });
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Show loader if it exists
            const editLoader = document.getElementById('editLoader');
            if (editLoader) {
                editLoader.classList.remove('hidden');
            }

            const formData = {
                id: document.getElementById('editId').value,
                name: document.getElementById('editName').value,
                email: document.getElementById('editEmail').value,
                program: document.getElementById('editProgram').value,
                units: document.getElementById('editUnits').value,
                position: document.getElementById('editPosition').value,
                user_type: document.getElementById('editUserType').value,
            };

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: JSON.stringify(formData),
            })
            .then(response => response.json())
            .then(data => {
                // Hide loader if it exists
                if (editLoader) {
                    editLoader.classList.add('hidden');
                }

                if (data.success) {
                    // Close the edit modal
                    closeEditModal();

                    // Show success alert
                    alert(data.message);

                    // Auto-reload after 3 seconds
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                } else {
                    // Show error alert
                    alert(data.message);
                }
            })
            .catch(error => {
                // Hide loader if it exists
                if (editLoader) {
                    editLoader.classList.add('hidden');
                }

                console.error('There was a problem with the edit operation:', error);
                alert('An error occurred while editing.');
            });
        });
    </script>
</x-admin-layout>