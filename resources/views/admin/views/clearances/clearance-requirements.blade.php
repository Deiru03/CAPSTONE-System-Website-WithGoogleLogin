@extends('admin.layouts.app') <!-- Adjust this if your layout name is different -->

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 shadow-lg border border-gray-300">
    <div class="p-6 text-gray-900">
        <h2 class="text-2xl font-bold mb-4">Manage Requirements for "{{ $clearance->document_name }}"</h2>
        <p>Here you can add, edit, and delete requirements for this clearance checklist.</p>
        <!-- Add Requirement Button -->
        <button onclick="openAddRequirementModal()" class="mt-4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
            Add Requirement
        </button>
        <!-- Back Button -->
        <a href="{{ route('admin.views.clearance') }}" class="mt-4 ml-2 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
            Back to Clearance Management
        </a>
    </div>

    <!-- Requirements Table -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 max-w-full">
        <div class="table-container overflow-x-auto" style="max-height: 490px; max-width: 1200px;">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-200 sticky-header">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requirement</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($clearance->requirements as $requirement)
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $requirement->id }}</td>
                        <td class="px-4 py-3 preserve-whitespace">{{ $requirement->requirement }}</td>
                        <td class="py-2 px-3 border-b">
                            <button 
                                class="edit-button text-blue-500 flex items-center text-xs mr-2"
                                data-clearance-id="{{ $clearance->id }}"
                                data-requirement-id="{{ $requirement->id }}"
                                data-requirement-text="{{ htmlspecialchars($requirement->requirement, ENT_QUOTES, 'UTF-8') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                Edit
                            </button>
                            <button 
                                class="delete-button text-red-500 flex items-center text-xs"
                                data-clearance-id="{{ $clearance->id }}"
                                data-requirement-id="{{ $requirement->id }}"
                                data-requirement-text="{{ htmlspecialchars($requirement->requirement, ENT_QUOTES, 'UTF-8') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H3a1 1 0 000 2h1v10a2 2 0 002 2h8a2 2 0 002-2V6h1a1 1 0 100-2h-2V3a1 1 0 00-1-1H6zm3 4a1 1 0 112 0v8a1 1 0 11-2 0V6z" clip-rule="evenodd" />
                                </svg>
                                Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>     
    </div>
</div>

<!-- Add Requirement Modal -->
<div id="addRequirementModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full relative">
        <h3 class="text-2xl font-semibold mb-4 text-gray-800">Add Requirement</h3>
        <form id="addRequirementForm" method="POST" action="{{ route('admin.clearance.requirements.store', $clearance->id) }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="addRequirementInput" class="block text-sm font-medium text-gray-700">Requirement</label>
                    <input type="text" name="requirement" id="addRequirementInput" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="closeAddRequirementModal()" class="px-4 py-2 border border-gray-300 rounded-md">Cancel</button>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md bg-green-600 text-white">Add</button>
            </div>
        </form>
        <div id="addRequirementNotification" class="hidden mt-2 text-green-600"></div>
        
        <!-- Loader for Add Requirement Modal -->
        <div id="addRequirementLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-75">
            <div class="loader"></div>
        </div>
    </div>
</div>

<!-- Edit Requirement Modal -->
<div id="editRequirementModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full relative">
        <h3 class="text-2xl font-semibold mb-4 text-gray-800">Edit Requirement</h3>
        <form id="editRequirementForm" method="POST" action="">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="editRequirementInput" class="block text-sm font-medium text-gray-700">Requirement</label>
                    <input type="text" name="requirement" id="editRequirementInput" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="closeEditRequirementModal()" class="px-4 py-2 border border-gray-300 rounded-md">Cancel</button>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md bg-blue-600 text-white">Save</button>
            </div>
        </form>
        <div id="editRequirementNotification" class="hidden mt-2 text-blue-600"></div>
        
        <!-- Loader for Edit Requirement Modal -->
        <div id="editRequirementLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-75">
            <div class="loader"></div>
        </div>
    </div>
</div>

<!-- Delete Requirement Modal -->
<div id="deleteRequirementModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full relative">
        <h3 class="text-2xl font-semibold mb-4 text-gray-800">Confirm Deletion</h3>
        <p class="mb-6">Are you sure you want to delete the requirement: "<span id="requirementName" class="font-bold"></span>"?</p>
        <form id="deleteRequirementForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-4">
                <button type="button" onclick="closeDeleteRequirementModal()" class="px-4 py-2 border border-gray-300 rounded-md">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Delete</button>
            </div>
        </form>
        <div id="deleteRequirementNotification" class="hidden mt-2 text-red-600 bg-red-100 p-2 rounded">
            <!-- Notification message will appear here -->
        </div>
        <!-- Loader for Delete Requirement Modal -->
        <div id="deleteRequirementLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-75">
            <div class="loader"></div>
        </div>
    </div>
</div>

<!-- Loader CSS (Ensure this is included if not already present) -->
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
    
    .preserve-whitespace {
       white-space: pre-wrap;
   }
</style>

<!-- Scripts -->
<script>
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

        const addLoader = document.getElementById('addRequirementLoader');
        const addNotification = document.getElementById('addRequirementNotification');
        addLoader.classList.remove('hidden');

        const formData = {
            requirement: document.getElementById('addRequirementInput').value,
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

                // Append the new requirement to the table
                const tbody = document.querySelector('tbody');
                const tr = document.createElement('tr');

                tr.innerHTML = `
                    <td class="px-4 py-3 whitespace-nowrap">${data.requirement.id}</td>
                    <td class="px-4 py-3 whitespace-nowrap">${data.requirement.requirement}</td>
                    <td class="py-2 px-3 border-b">
                        <button onclick="openEditRequirementModal(${data.requirement.clearance_id}, ${data.requirement.id})" class="text-blue-500 flex items-center text-xs mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit
                        </button>
                        <button 
                            onclick="openDeleteRequirementModal(${data.requirement.clearance_id}, ${data.requirement.id}, '${data.requirement.requirement.replace(/'/g, "\\'")}')" 
                            class="text-red-500 flex items-center text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H3a1 1 0 000 2h1v10a2 2 0 002 2h8a2 2 0 002-2V6h1a1 1 0 100-2h-2V3a1 1 0 00-1-1H6zm3 4a1 1 0 112 0v8a1 1 0 11-2 0V6z" clip-rule="evenodd" />
                            </svg>
                            Delete
                        </button>
                    </td>
                `;

                tbody.appendChild(tr);

                // Reset and close the modal after a short delay
                setTimeout(() => {
                    closeAddRequirementModal();
                }, 1000);
            } else {
                addNotification.classList.remove('hidden');
                addNotification.classList.add('text-red-600');
                addNotification.innerText = data.message;
            }
        })
        .catch(error => {
            addLoader.classList.add('hidden');
            console.error('Error:', error);
            alert('An error occurred while adding the requirement.');
        });
    });

    // Edit Requirement Modal Functions
    function openEditRequirementModal(clearanceId, requirementId) {
        // Fetch requirement data
        fetch(`/admin/clearance/${currentClearanceId}/requirements/edit/${requirementId}`, {
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
    function openDeleteRequirementModal(clearanceId, requirementId, requirementName) {
        document.getElementById('requirementName').innerText = requirementName;
        document.getElementById('deleteRequirementForm').action = `/admin/clearance/${clearanceId}/requirements/delete/${requirementId}`;
        document.getElementById('deleteRequirementModal').classList.remove('hidden');
    }

    function closeDeleteRequirementModal() {
        document.getElementById('deleteRequirementModal').classList.add('hidden');
        document.getElementById('deleteRequirementNotification').classList.add('hidden');
    }

    document.getElementById('deleteRequirementForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const deleteLoader = document.getElementById('deleteRequirementLoader');
        const deleteNotification = document.getElementById('deleteRequirementNotification');
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
                closeDeleteRequirementModal();
                alert(data.message);
                location.reload(); // Reload to update the table and number_of_requirements
            } else {
                deleteNotification.classList.remove('hidden');
                deleteNotification.innerText = data.message;
            }
        })
        .catch(error => {
            deleteLoader.classList.add('hidden');
            console.error('Error:', error);
            alert('An error occurred while deleting the requirement.');
        });
    });
</script>
@endsection