{{-- resources/views/admin/views/clearance.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clearance Management') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 shadow-lg border border-gray-300">
        <div class="p-6 text-gray-900">
            <h2 class="text-3xl font-extrabold mb-6 text-indigo-600 animate-pulse">Manage Clearance Checklists</h2>
            <p class="text-lg mb-4">Here you can create and manage clearance checklists.</p>
            <!-- Add Button -->
            <button onclick="openAddModal()" class="mt-4 bg-gradient-to-r from-green-400 to-green-600 hover:from-green-500 hover:to-green-700 text-white font-bold py-3 px-6 rounded-full shadow-lg transform transition duration-300 hover:scale-105">
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add Clearance Checklist
                </span>
            </button>
        </div>

        <!-- Clearance Table -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 max-w-full">
            <div class="table-container overflow-x-auto" style="max-height: 490px; max-width: 1200px;">
                <table class="min-w-full text-sm border-collapse border border-gray-300">
                    <thead class="bg-gray-200 sticky top-0">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300">Document Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300">Description</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300 text-center">Units</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300 text-center">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300 text-center"># of Req.</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($clearances as $clearance)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 whitespace-nowrap border-b border-gray-200">{{ $clearance->id }}</td>
                            <td class="px-4 py-4 whitespace-nowrap border-b border-gray-200">{{ $clearance->document_name }}</td>
                            <td class="px-4 py-4 border-b border-gray-200">
                                <div class="max-w-xs overflow-hidden overflow-ellipsis">
                                    {{ $clearance->description }}
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap border-b border-gray-200 text-center">{{ $clearance->units }}</td>
                            <td class="px-4 py-4 whitespace-nowrap border-b border-gray-200 text-center">{{ $clearance->type }}</td>
                            <td class="px-4 py-4 whitespace-nowrap border-b border-gray-200 text-center">{{ $clearance->number_of_requirements }}</td>
                            <td class="px-4 py-4 whitespace-nowrap border-b border-gray-200">
                                <div class="flex flex-col space-y-2">
                                    <div class="flex space-x-2">
                                        <button onclick="openEditModal({{ $clearance->id }})" class="text-blue-600 hover:text-blue-800 flex items-center text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                            Edit
                                        </button>
                                        <button 
                                            onclick="openDeleteModal({{ $clearance->id }}, '{{ addslashes($clearance->document_name) }}')" 
                                            class="text-red-600 hover:text-red-800 flex items-center text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H3a1 1 0 000 2h1v10a2 2 0 002 2h8a2 2 0 002-2V6h1a1 1 0 100-2h-2V3a1 1 0 00-1-1H6zm3 4a1 1 0 112 0v8a1 1 0 11-2 0V6z" clip-rule="evenodd" />
                                            </svg>
                                            Delete
                                        </button>
                                    </div>
                                    <button 
                                    onclick="openEditRequirementsModal({{ $clearance->id }}, '{{ addslashes($clearance->document_name) }}')" 
                                    class="text-purple-800 flex items-center text-sm">
                                    {{-- Edit Requirements Icon --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                        <path fill-rule="evenodd" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v2a1 1 0 01-1 1H6a1 1 0 01-1-1V5z" clip-rule="evenodd" />
                                    </svg>
                                    Manage Reqs
                                </button>
                                <button onclick="openSendClearanceModal({{ $clearance->id }}, '{{ addslashes($clearance->document_name) }}')" class="text-yellow-600 hover:text-yellow-800 flex items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                        <path fill-rule="evenodd" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v2a1 1 0 01-1 1H6a1 1 0 01-1-1V5z" clip-rule="evenodd" />
                                    </svg>
                                    Send Clearance
                                </button>
                                </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>     
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full relative">
            <h3 class="text-2xl font-semibold mb-4 text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Clearance Checklist
            </h3>
            <form id="addForm" method="POST" action="{{ route('admin.clearance.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="addDocumentName" class="block text-sm font-medium text-gray-700">Document Name</label>
                        <input type="text" name="document_name" id="addDocumentName" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div>
                        <label for="addDescription" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="addDescription" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>
                    <div>
                        <label for="addUnits" class="block text-sm font-medium text-gray-700">Units</label>
                        <input type="number" name="units" id="addUnits" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="addType" class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="type" id="addType" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="" disabled selected>Select Type</option>
                            <option value="Permanent">Permanent</option>
                            <option value="Part-Timer">Part-Timer</option>
                            <option value="Temporary">Temporary</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeAddModal()" class="px-4 py-2 border border-gray-300 rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md bg-green-600 text-white flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Add
                    </button>
                </div>
            </form>
            <div id="addNotification" class="hidden mt-2 text-green-600"></div>
            
            <!-- Loader for Add Modal -->
            <div id="addLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-75">
                <div class="loader"></div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full relative">
            <h3 class="text-2xl font-semibold mb-4 text-gray-800">Edit Clearance Checklist</h3>
            <form id="editForm" method="POST" action="">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="editDocumentName" class="block text-sm font-medium text-gray-700">Document Name</label>
                        <input type="text" name="document_name" id="editDocumentName" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div>
                        <label for="editDescription" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="editDescription" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>
                    <div>
                        <label for="editUnits" class="block text-sm font-medium text-gray-700">Units</label>
                        <input type="number" name="units" id="editUnits" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="editType" class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="type" id="editType" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="" disabled>Select Type</option>
                            <option value="Permanent">Permanent</option>
                            <option value="Part-Timer">Part-Timer</option>
                            <option value="Temporary">Temporary</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-gray-300 rounded-md">Cancel</button>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md bg-blue-600 text-white">Save</button>
                </div>
            </form>
            <div id="editNotification" class="hidden mt-2 text-blue-600"></div>
            
            <!-- Loader for Edit Modal -->
            <div id="editLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-75">
                <div class="loader"></div>
            </div>
        </div>
    </div>

     <!-- Edit Requirements Modal -->
     <div id="editRequirementsModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-3xl w-full relative">
            <h3 class="text-2xl font-semibold mb-4 text-gray-800">Edit Requirements for "<span id="modalClearanceName"></span>"</h3>
            
            <!-- Requirements Table -->
            <div class="mb-4">
                <button onclick="openAddRequirementModal()" class="mb-2 bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded">
                    Add Requirement
                </button>
                <div class="overflow-y-auto max-h-[30rem]">
                    <table class="min-w-full text-sm border">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">ID</th>
                                <th class="px-4 py-2 text-left">Requirement</th>
                                <th class="px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="requirementsTableBody" class="divide-y divide-gray-200">
                            {{-- Dynamically filled via JavaScript --}}
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4 flex justify-end">
                <button onclick="closeEditRequirementsModal()" class="px-4 py-2 border border-gray-300 rounded-md">Close</button>
            </div>

            <!-- Add Requirement Modal (Nested) -->
            <div id="addRequirementModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-xl w-full relative">
                    <h4 class="text-xl font-semibold mb-4 text-gray-800">Add Requirement</h4>
                    <form id="addRequirementForm">
                        @csrf
                        <div class="mb-4">
                            <label for="newRequirement" class="block text-sm font-medium text-gray-700">Requirement</label>
                            <textarea id="newRequirement" name="requirement" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-40 resize-y" required></textarea>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="closeAddRequirementModal()" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-200 transition duration-200 transform hover:scale-105">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-200 transform hover:scale-105">Add</button>
                        </div>
                    </form>
                    <div id="addRequirementNotification" class="hidden mt-2 text-green-600"></div>
                </div>
            </div>

            <!-- Edit Requirement Modal (Nested) -->
            <div id="editRequirementModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-xl w-full relative">
                    <h4 class="text-xl font-semibold mb-4 text-gray-800">Edit Requirement</h4>
                    <form id="editRequirementForm">
                        @csrf
                        <input type="hidden" id="editRequirementId">
                        <div class="mb-4">
                            <label for="editRequirementInput" class="block text-sm font-medium text-gray-700">Requirement</label>
                            <textarea id="editRequirementInput" name="requirement" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-40 resize-y" required></textarea>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="closeEditRequirementModal()" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-200 transition duration-200 transform hover:scale-105">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200 transform hover:scale-105">Save</button>
                        </div>
                    </form>
                    <div id="editRequirementNotification" class="hidden mt-2 text-blue-600"></div>
                </div>
            </div>

            <!-- Delete Requirement Confirmation Modal (Nested) -->
            <div id="deleteRequirementModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
                    <h4 class="text-xl font-semibold mb-4 text-gray-800">Confirm Deletion</h4>
                    <p>Are you sure you want to delete the requirement: <strong id="deleteRequirementName"></strong>?</p>
                    <form id="deleteRequirementForm">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" id="deleteRequirementId">
                        <div class="flex justify-end space-x-2 mt-4">
                            <button type="button" onclick="closeDeleteRequirementModal()" class="px-4 py-2 border border-gray-300 rounded-md">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Delete</button>
                        </div>
                    </form>
                    <div id="deleteRequirementNotification" class="hidden mt-2 text-red-600"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full relative">
            <h3 class="text-2xl font-semibold mb-4 text-gray-800">Confirm Deletion</h3>
            <p class="mb-6">Are you sure you want to delete <span id="clearanceName" class="font-bold"></span>?</p>
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
            
            <!-- Loader for Delete Modal -->
            <div id="deleteLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-75">
                <div class="loader"></div>
            </div>
        </div>
    </div>

    <!-- Loader CSS (Add to your main CSS if not already present) -->
    <style>
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

    <!-- Scripts -->
    <script>
        // Add Modal Functions
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addForm').reset();
            document.getElementById('addNotification').classList.add('hidden');
        }

        document.getElementById('addForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const addLoader = document.getElementById('addLoader');
            const addNotification = document.getElementById('addNotification');
            addLoader.classList.remove('hidden');

            const formData = {
                document_name: document.getElementById('addDocumentName').value,
                description: document.getElementById('addDescription').value,
                units: document.getElementById('addUnits').value,
                type: document.getElementById('addType').value,
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
                addLoader.classList.add('hidden');

                if (data.success) {
                    addNotification.classList.remove('hidden');
                    addNotification.innerText = data.message;

                    // Optionally, append the new clearance to the table
                    location.reload(); // Simple reload, can be optimized
                } else {
                    addNotification.classList.remove('hidden');
                    addNotification.classList.add('text-red-600');
                    addNotification.innerText = data.message;
                }
            })
            .catch(error => {
                addLoader.classList.add('hidden');
                console.error('Error:', error);
                alert('An error occurred while adding the clearance.');
            });
        });

        // Edit Modal Functions
        function openEditModal(id) {
            // Fetch clearance data
            fetch(`/admin/clearance/edit/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('editDocumentName').value = data.clearance.document_name;
                    document.getElementById('editDescription').value = data.clearance.description;
                    document.getElementById('editUnits').value = data.clearance.units;
                    document.getElementById('editType').value = data.clearance.type;

                    document.getElementById('editForm').action = `/admin/clearance/update/${id}`;

                    document.getElementById('editModal').classList.remove('hidden');
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while fetching clearance data.');
            });
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editForm').reset();
            document.getElementById('editNotification').classList.add('hidden');
        }

        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const editLoader = document.getElementById('editLoader');
            const editNotification = document.getElementById('editNotification');
            editLoader.classList.remove('hidden');

            const formData = {
                document_name: document.getElementById('editDocumentName').value,
                description: document.getElementById('editDescription').value,
                units: document.getElementById('editUnits').value,
                type: document.getElementById('editType').value,
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
                editLoader.classList.add('hidden');

                if (data.success) {
                    editNotification.classList.remove('hidden');
                    editNotification.innerText = data.message;

                    // Optionally, update the table without reloading
                    location.reload(); // Simple reload, can be optimized
                } else {
                    editNotification.classList.remove('hidden');
                    editNotification.classList.add('text-red-600');
                    editNotification.innerText = data.message;
                }
            })
            .catch(error => {
                editLoader.classList.add('hidden');
                console.error('Error:', error);
                alert('An error occurred while updating the clearance.');
            });
        });
        // Delete Modal Functions
        let currentDeleteId;

        function openDeleteModal(id, name) {
            currentDeleteId = id;
            document.getElementById('clearanceName').innerText = name;
            document.getElementById('deleteForm').action = `/admin/clearance/delete/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteNotification').classList.add('hidden');
        }

        document.getElementById('deleteForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const deleteLoader = document.getElementById('deleteLoader');
            const deleteNotification = document.getElementById('deleteNotification');
            deleteLoader.classList.remove('hidden');

            fetch(this.action, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                deleteLoader.classList.add('hidden');

                if (data.success) {
                    closeDeleteModal();
                    alert(data.message);
                    location.reload(); // Simple reload, can be optimized
                } else {
                    deleteNotification.classList.remove('hidden');
                    deleteNotification.innerText = data.message;
                }
            })
            .catch(error => {
                deleteLoader.classList.add('hidden');
                console.error('Error:', error);
                alert('An error occurred while deleting the clearance.');
            });
        });

        // =============================================
        // Edit Requirements Modal Functions
        // =============================================

        let currentClearanceId = null;
        let currentClearanceName = '';

        /**
         * Open the Edit Requirements Modal for a specific clearance
         */
        function openEditRequirementsModal(clearanceId, clearanceName) {
            currentClearanceId = clearanceId;
            currentClearanceName = clearanceName;
            document.getElementById('modalClearanceName').innerText = clearanceName;
            document.getElementById('editRequirementsModal').classList.remove('hidden');
            fetchRequirements(clearanceId);
        }

        /**
         * Close the Edit Requirements Modal
         */
        function closeEditRequirementsModal() {
            currentClearanceId = null;
            currentClearanceName = '';
            document.getElementById('modalClearanceName').innerText = '';
            document.getElementById('editRequirementsModal').classList.add('hidden');
            document.getElementById('requirementsTableBody').innerHTML = '';
        }

        /**
         * Fetch Requirements for a specific clearance via AJAX
         */
        function fetchRequirements(clearanceId) {
            fetch(`/admin/clearance/${clearanceId}/requirements`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    populateRequirementsTable(data.requirements);
                } else {
                    alert('Failed to fetch requirements.');
                }
            })
            .catch(error => {
                console.error('Error fetching requirements:', error);
                alert('An error occurred while fetching requirements.');
            });
        }

        /**
         * Populate the Requirements Table in the Modal
         */
        function populateRequirementsTable(requirements) {
            const tbody = document.getElementById('requirementsTableBody');
            tbody.innerHTML = ''; // Clear existing rows

            requirements.forEach(req => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="px-4 py-2 border">${req.id}</td>
                    <td class="px-4 py-2 border">${req.requirement}</td>
                    <td class="px-4 py-2 border">
                        <button onclick="openEditRequirementModal(${currentClearanceId}, ${req.id})" class="text-blue-500 mr-2">
                            Edit
                        </button>
                        <button onclick="openDeleteRequirementModal(${currentClearanceId}, ${req.id}, '${escapeHtml(req.requirement)}')" class="text-red-500">
                            Delete
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        /**
         * Escape HTML entities to prevent XSS
         */
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        // Add Requirement Modal Functions
        function openAddRequirementModal() {
            document.getElementById('addRequirementModal').classList.remove('hidden');
        }

        function closeAddRequirementModal() {
            document.getElementById('addRequirementModal').classList.add('hidden');
            document.getElementById('addRequirementForm').reset();
            document.getElementById('addRequirementNotification').classList.add('hidden');
        }

        document.getElementById('addRequirementForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const addRequirementNotification = document.getElementById('addRequirementNotification');
            addRequirementNotification.classList.add('hidden');

            const formData = {
                requirement: document.getElementById('newRequirement').value,
            };

            fetch(`/admin/clearance/${currentClearanceId}/requirements/store`, {
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
                if (data.success) {
                    closeAddRequirementModal();
                    fetchRequirements(currentClearanceId);
                } else {
                    addRequirementNotification.classList.remove('hidden');
                    addRequirementNotification.innerText = data.message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while adding the requirement.');
            });
        });

        // Edit Requirement Modal Functions
        function openEditRequirementModal(clearanceId, requirementId) {
            // Fetch the latest requirement data
            fetch(`/admin/clearance/${clearanceId}/requirements/edit/${requirementId}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('editRequirementId').value = data.requirement.id;
                    document.getElementById('editRequirementInput').value = data.requirement.requirement;
                    document.getElementById('editRequirementModal').classList.remove('hidden');
                } else {
                    alert('Failed to fetch requirement data.');
                }
            })
            .catch(error => {
                console.error('Error fetching requirement data:', error);
                alert('An error occurred while fetching requirement data.');
            });
        }

        function closeEditRequirementModal() {
            document.getElementById('editRequirementModal').classList.add('hidden');
            document.getElementById('editRequirementForm').reset();
            document.getElementById('editRequirementNotification').classList.add('hidden');
        }

        document.getElementById('editRequirementForm').addEventListener('submit', function(event) {
            event.preventDefault(); // prevent default form submission

            const requirementId = document.getElementById('editRequirementId').value;
            const updatedRequirement = document.getElementById('editRequirementInput').value.trim();

            if (updatedRequirement === '') {
                alert('Requirement cannot be empty.');
                return;
            }

            fetch(`/admin/clearance/${currentClearanceId}/requirements/update/${requirementId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ requirement: updatedRequirement }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Find the table row and update the requirement text
                    const tbody = document.getElementById('requirementsTableBody');
                    const rows = tbody.getElementsByTagName('tr');
                    for (let row of rows) {
                        const cellId = row.cells[0].innerText;
                        if (cellId == requirementId) {
                            row.cells[1].innerText = data.requirement.requirement;
                            break;
                        }
                    }

                    // Show success notification
                    const notification = document.getElementById('editRequirementNotification');
                    notification.innerText = data.message;
                    notification.classList.remove('hidden');

                    // Reset and close the modal after a short delay
                    setTimeout(() => {
                        closeEditRequirementModal();
                    }, 1500);
                } else {
                    alert(data.message || 'Failed to update requirement.');
                }
            })
            .catch(error => {
                console.error('Error updating requirement:', error);
                alert('An error occurred while updating the requirement.');
            });
        });

        // Delete Requirement Modal Functions
        let currentDeleteRequirementId = null;

        function openDeleteRequirementModal(clearanceId, requirementId, requirementName) {
            currentDeleteRequirementId = requirementId;
            document.getElementById('deleteRequirementName').innerText = requirementName;
            document.getElementById('deleteRequirementId').value = requirementId;
            document.getElementById('deleteRequirementModal').classList.remove('hidden');
        }

        function closeDeleteRequirementModal() {
            document.getElementById('deleteRequirementModal').classList.add('hidden');
            document.getElementById('deleteRequirementNotification').classList.add('hidden');
        }

        document.getElementById('deleteRequirementForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const deleteRequirementNotification = document.getElementById('deleteRequirementNotification');
            deleteRequirementNotification.classList.add('hidden');

            fetch(`/admin/clearance/${currentClearanceId}/requirements/delete/${currentDeleteRequirementId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeDeleteRequirementModal();
                    fetchRequirements(currentClearanceId);
                } else {
                    deleteRequirementNotification.classList.remove('hidden');
                    deleteRequirementNotification.innerText = data.message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the requirement.');
            });
        });
        
    </script>
    <script>
        function openSendClearanceModal(clearanceId, clearanceName) {
            document.getElementById('sendClearanceModal').classList.remove('hidden');
            document.getElementById('modalClearanceName').innerText = clearanceName;
        }

        function closeSendClearanceModal() {
            document.getElementById('sendClearanceModal').classList.add('hidden');
            document.getElementById('modalClearanceName').innerText = '';
        }
    </script>
</x-admin-layout>