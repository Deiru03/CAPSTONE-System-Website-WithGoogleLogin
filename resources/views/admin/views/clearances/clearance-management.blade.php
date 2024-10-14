<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clearance Management') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 shadow-lg border border-gray-300">
        <div class="p-6 text-gray-900">
            <h2 class="text-3xl font-extrabold mb-6 text-indigo-600 ">Manage Clearance Checklists</h2>
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
            <!-- Add this button below the "Add Clearance Checklist" button -->
            <button onclick="openSharedClearancesModal()" class="mt-4 bg-gradient-to-r from-purple-400 to-purple-600 hover:from-purple-500 hover:to-purple-700 text-white font-bold py-3 px-6 rounded-full shadow-lg transform transition duration-300 hover:scale-105">
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" clip-rule="evenodd" />
                    </svg>
                    View Shared Clearances
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
                                    class="text-purple-600 flex hover:text-purple-800 items-center text-sm">
                                    {{-- Edit Requirements Icon --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                        <path fill-rule="evenodd" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v2a1 1 0 01-1 1H6a1 1 0 01-1-1V5z" clip-rule="evenodd" />
                                    </svg>
                                    Manage Reqs
                                </button>
                                <button 
                                    onclick="openShareModal({{ $clearance->id }}, '{{ addslashes($clearance->document_name) }}')" 
                                    class="text-green-600 hover:text-green-800 flex items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M8 9H7v6H5V9H4l3-3 3 3z" />
                                        <path d="M18 10v6a2 2 0 01-2 2H4a2 2 0 01-2-2v-6a2 2 0 012-2h1V7a2 2 0 012-2h4a2 2 0 012 2v1h1a2 2 0 012 2z" />
                                    </svg>
                                    Share Clearance
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
    <div id="addModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-70 hidden z-50 transition-opacity duration-300">
        <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full relative overflow-hidden duration-300 scale-95 hover:scale-100">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-green-400 to-blue-500"></div>
            <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Clearance Checklist
            </h3>
            <form id="addForm" method="POST" action="{{ route('admin.clearance.store') }}" class="space-y-6">
                @csrf
                <div class="space-y-4">
                    <div class="relative">
                        <label for="addDocumentName" class="block text-sm font-medium text-gray-700 mb-1">Document Name</label>
                        <input type="text" name="document_name" id="addDocumentName" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out" required>
                    </div>
                    <div class="relative">
                        <label for="addDescription" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="addDescription" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out" rows="3"></textarea>
                    </div>
                    <div class="relative">
                        <label for="addUnits" class="block text-sm font-medium text-gray-700 mb-1">Units</label>
                        <input type="number" name="units" id="addUnits" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out">
                    </div>
                    <div class="relative">
                        <label for="addType" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select name="type" id="addType" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out" required>
                            <option value="" disabled selected>Select Type</option>
                            <option value="Permanent">Permanent</option>
                            <option value="Part-Timer">Part-Timer</option>
                            <option value="Temporary">Temporary</option>
                        </select>
                    </div>
                </div>
                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" onclick="closeAddModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Clearance
                    </button>
                </div>
            </form>
            <div id="addNotification" class="hidden mt-4 text-green-600 bg-green-100 p-3 rounded-lg border border-green-200"></div>
            
            <!-- Loader for Add Modal -->
            <div id="addLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-75 rounded-2xl">
                <div class="loader border-t-4 border-green-500 border-solid rounded-full animate-spin h-12 w-12"></div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-70 hidden z-50 transition-opacity duration-300">
        <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full relative overflow-hidden duration-300 scale-95 hover:scale-100">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-400 to-indigo-500"></div>
            <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Clearance Checklist
            </h3>
            <form id="editForm" method="POST" action="" class="space-y-6">
                @csrf
                <div class="space-y-4">
                    <div class="relative">
                        <label for="editDocumentName" class="block text-sm font-medium text-gray-700 mb-1">Document Name</label>
                        <input type="text" name="document_name" id="editDocumentName" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" required>
                    </div>
                    <div class="relative">
                        <label for="editDescription" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="editDescription" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" rows="3"></textarea>
                    </div>
                    <div class="relative">
                        <label for="editUnits" class="block text-sm font-medium text-gray-700 mb-1">Units</label>
                        <input type="number" name="units" id="editUnits" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                    </div>
                    <div class="relative">
                        <label for="editType" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select name="type" id="editType" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" required>
                            <option value="" disabled>Select Type</option>
                            <option value="Permanent">Permanent</option>
                            <option value="Part-Timer">Part-Timer</option>
                            <option value="Temporary">Temporary</option>
                        </select>
                    </div>
                </div>
                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" onclick="closeEditModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Save Changes
                    </button>
                </div>
            </form>
            <div id="editNotification" class="hidden mt-4 text-blue-600 bg-blue-100 p-3 rounded-lg border border-blue-200"></div>
            
            <!-- Loader for Edit Modal -->
            <div id="editLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-75 rounded-2xl">
                <div class="loader border-t-4 border-blue-500 border-solid rounded-full animate-spin h-12 w-12"></div>
            </div>
        </div>
    </div>

     <!-- Edit Requirements Modal -->
     <div id="editRequirementsModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-70 hidden z-50 transition-opacity duration-300">
        <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-4xl w-full relative overflow-hidden duration-300 scale-95 hover:scale-100">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-400 to-purple-500"></div>
            <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Requirements for "<span id="modalClearanceName" class="text-blue-600"></span>"
            </h3>
            
            <!-- Requirements Table -->
            <div class="mb-6">
                <button onclick="openAddRequirementModal()" class="mb-4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add Requirement
                </button>
                <div class="overflow-y-auto max-h-[30rem] shadow-inner rounded-lg">
                    <table class="min-w-full text-sm border-collapse">
                        <thead class="bg-gray-100 sticky top-0">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requirement</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="requirementsTableBody" class="bg-white divide-y divide-gray-200">
                            {{-- Dynamically filled via JavaScript --}}
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4 flex justify-end">
                <button onclick="closeEditRequirementsModal()" class="px-4 py-2 border border-gray-300 rounded-md">Close</button>
            </div>

            <!-- Add Requirement Modal (Nested) -->
            <div id="addRequirementModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden z-100">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-xl w-full relative">
                    <h4 class="text-xl font-semibold mb-4 text-gray-800">Add Requirement</h4>
                    <form id="addRequirementForm">
                        @csrf
                        <div class="mb-4">
                            <label for="newRequirement" class="block text-sm font-medium text-gray-700">Requirement</label>
                            <textarea id="newRequirement" name="requirement" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-20 resize-y" required></textarea>
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

    <!-- Share Clearance Modal -->
    <div id="shareModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-30 backdrop-blur-sm hidden transition-opacity duration-300">
        <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full relative overflow-hidden duration-300 scale-95 hover:scale-100">
            <div class="absolute top-0 left-0 w-full h-3 bg-gradient-to-r from-green-400 to-blue-500"></div>
            <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                </svg>
                Share Clearance Checklist
            </h3>
            <p class="mb-6 text-lg text-gray-600">Are you sure you want to share the clearance checklist: <strong id="shareClearanceName" class="font-bold text-green-600"></strong>?</p>
            <form id="shareForm" method="POST">
                @csrf
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeShareModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                        Share
                    </button>
                </div>
            </form>
            <div id="shareNotification" class="hidden mt-4 text-green-600 bg-green-100 p-3 rounded-lg border border-green-200"></div>
            <!-- Loader -->
            <div id="shareLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-75 rounded-2xl">
                <div class="loader border-t-4 border-green-500 border-solid rounded-full animate-spin h-12 w-12"></div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-70 hidden z-50 transition-opacity duration-300">
        <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full relative overflow-hidden duration-300 scale-95 hover:scale-100">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-500 to-pink-500"></div>
            <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Confirm Deletion
            </h3>
            <p class="mb-6 text-lg text-gray-600">Are you sure you want to delete <span id="clearanceName" class="font-bold text-red-600"></span>? This action cannot be undone.</p>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeDeleteModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </div>
            </form>
            <div id="deleteNotification" class="hidden mt-4 text-red-600 bg-red-100 p-3 rounded-lg border border-red-200">
                <!-- Notification message will appear here -->
            </div>
            
            <!-- Loader for Delete Modal -->
            <div id="deleteLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-75 rounded-2xl">
                <div class="loader"></div>
            </div>
        </div>
    </div>
    
    <!-- Shared Clearances Modal ID -->
    <div id="sharedClearancesModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden z-50">
        <div class="bg-white p-8 rounded-lg shadow-2xl max-w-3xl w-full relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-green-400 to-blue-500"></div>
            <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                Shared Clearances
            </h3>
            <div class="overflow-x-auto shadow-md rounded-lg">
                <table class="min-w-full text-sm border-collapse">
                    <thead class="bg-gradient-to-r from-green-400 to-blue-500 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Document Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Units</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sharedClearancesTableBody" class="bg-white divide-y divide-gray-200">
                        <!-- Shared clearances will be populated here -->
                    </tbody>
                </table>
            </div>
            <div class="mt-8 flex justify-end">
                <button type="button" onclick="closeSharedClearancesModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Close
                </button>
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

                    // Store the new clearance ID in localStorage
                    localStorage.setItem('newClearanceId', data.clearance.id);
                    localStorage.setItem('newClearanceName', data.clearance.document_name);

                    // Reload the page
                    location.reload();
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

        // Add this new function at the end of your script section
        function checkAndOpenEditRequirements() {
            const newClearanceId = localStorage.getItem('newClearanceId');
            const newClearanceName = localStorage.getItem('newClearanceName');
            
            if (newClearanceId && newClearanceName) {
                // Clear the localStorage items
                localStorage.removeItem('newClearanceId');
                localStorage.removeItem('newClearanceName');
                
                // Wait for 3 seconds before opening the edit requirements modal
                setTimeout(() => {
                    openEditRequirementsModal(newClearanceId, newClearanceName);
                }, 999);
            }
        }

        // Call this function when the page loads
        document.addEventListener('DOMContentLoaded', checkAndOpenEditRequirements);

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
    <!-- Share Clearance Modal -->
    <script>
        // Share Clearance Modal Functions
        let currentShareClearanceId = null;

        function openShareModal(id, name) {
            currentShareClearanceId = id;
            document.getElementById('shareClearanceName').innerText = name;
            document.getElementById('shareForm').action = `{{ route('admin.clearance.share', '') }}/${id}`;
            document.getElementById('shareModal').classList.remove('hidden');
        }

        function closeShareModal() {
            document.getElementById('shareModal').classList.add('hidden');
            document.getElementById('shareForm').reset();
            document.getElementById('shareNotification').classList.add('hidden');
        }

        // Handle Share Form Submission
        document.getElementById('shareForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const shareLoader = document.getElementById('shareLoader');
            const shareNotification = document.getElementById('shareNotification');
            shareLoader.classList.remove('hidden');
            shareNotification.classList.add('hidden');

            const actionUrl = this.action;

            fetch(actionUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                shareLoader.classList.add('hidden');

                if (data.success) {
                    shareNotification.classList.remove('hidden');
                    shareNotification.innerText = data.message;
                    // Optionally, reload the page to reflect changes
                    setTimeout(() => {
                        closeShareModal();
                        location.reload();
                    }, 1500);
                } else {
                    shareNotification.classList.remove('hidden');
                    shareNotification.innerText = data.message;
                }
            })
            .catch(error => {
                shareLoader.classList.add('hidden');
                console.error('Error sharing clearance:', error);
                alert('An error occurred while sharing the clearance.');
            });
        });
    </script>
    <!-- Share Clearance Modal -->
    <script>
        function openSharedClearancesModal() {
            fetchSharedClearances();
            document.getElementById('sharedClearancesModal').classList.remove('hidden');
        }
    
        function closeSharedClearancesModal() {
            document.getElementById('sharedClearancesModal').classList.add('hidden');
        }
    
        function fetchSharedClearances() {
            fetch('{{ route('admin.clearance.shared') }}')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('sharedClearancesTableBody');
                    tbody.innerHTML = '';
                    data.sharedClearances.forEach(clearance => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="px-4 py-4 whitespace-nowrap border-b border-gray-200">${clearance.id}</td>
                            <td class="px-4 py-4 whitespace-nowrap border-b border-gray-200">${clearance.document_name}</td>
                            <td class="px-4 py-4 whitespace-nowrap border-b border-gray-200 text-center">${clearance.units}</td>
                            <td class="px-4 py-4 whitespace-nowrap border-b border-gray-200">${clearance.type}</td>
                            <td class="px-4 py-4 whitespace-nowrap border-b border-gray-200">
                                <button onclick="removeSharedClearance(${clearance.id})" class="text-red-600 hover:text-red-800 flex items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H3a1 1 0 000 2h1v10a2 2 0 002 2h8a2 2 0 002-2V6h1a1 1 0 100-2h-2V3a1 1 0 00-1-1H6zm3 4a1 1 0 112 0v8a1 1 0 11-2 0V6z" clip-rule="evenodd" />
                                    </svg>
                                    Remove
                                </button>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
                .catch(error => {
                    console.error('Error fetching shared clearances:', error);
                    alert('An error occurred while fetching shared clearances.');
                });
        }
    
        function removeSharedClearance(id) {
            if (!confirm('Are you sure you want to remove this shared clearance?')) {
                return;
            }
    
            fetch(`{{ route('admin.clearance.removeShared', '') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchSharedClearances();
                    alert(data.message || 'Shared clearance removed successfully.');
                } else {
                    alert(data.message || 'Failed to remove shared clearance.');
                }
            })
            .catch(error => {
                console.error('Error removing shared clearance:', error);
                alert('An error occurred while removing the shared clearance.');
            });
        }
    </script>

</x-admin-layout>
