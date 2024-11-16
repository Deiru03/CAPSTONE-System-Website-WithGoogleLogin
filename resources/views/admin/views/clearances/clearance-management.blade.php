<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clearance Management') }}
        </h2>
    </x-slot>
    

    <div class="max-w-8xl mx-auto sm:px-2 lg:px-2 shadow-lg border border-gray-300">
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
            <button onclick="openSharedClearancesModal()" class="mt-4 ml-2 bg-gradient-to-r from-purple-400 to-purple-600 hover:from-purple-500 hover:to-purple-700 text-white font-bold py-3 px-6 rounded-full shadow-lg transform transition duration-300 hover:scale-105">
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
            <div class="table-container overflow-x-auto" style="max-height: 770px; max-width: 1200px;">
                <table class="min-w-full text-sm border-collapse border border-gray-300">
                    <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 sticky -top-3">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider border-b border-gray-300">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider border-b border-gray-300">Document Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider border-b border-gray-300">Description</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-white uppercase tracking-wider border-b border-gray-300">Units</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-white uppercase tracking-wider border-b border-gray-300">Type</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-white uppercase tracking-wider border-b border-gray-300"># of Req.</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider border-b border-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($clearances as $clearance)
                        <tr class="hover:bg-gray-50 cursor-pointer" onclick="openViewDetailsModal({{ $clearance->id }})" data-id="{{ $clearance->id }}">
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
                            <td class="px-4 py-4 whitespace-nowrap border-b border-gray-200" onclick="event.stopPropagation()">
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
                                    <button onclick="window.open('/admin/clearance/{{ $clearance->id }}/report', '_blank')" class="text-blue-600 hover:text-blue-800 flex items-center text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13 7H7v6h6V7z" />
                                            <path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v10H5V5z" clip-rule="evenodd" />
                                        </svg>
                                        PDF this Checklist
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


    <script>
        function generateReport(clearanceId) {
            window.location.href = `/admin/clearance/${clearanceId}/report`;
        }
    </script>

    <!-- Add Modal -->
    <div id="addModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-20 hidden z-20 transition-opacity duration-300">
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
                            <option value="Dean">Dean</option>
                            <option value="Program-Head">Program-Head</option>
                            <option value="Permanent">Permanent (Full-Time/Part-Time)</option>
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
            <div id="addLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-25 rounded-2xl">
                <div class="loader border-t-4 border-green-500 border-solid rounded-full animate-spin h-12 w-12"></div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-20 hidden z-20 transition-opacity duration-300">
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
                            <option value="Dean">Dean</option>
                            <option value="Program-Head">Program-Head</option>
                            <option value="Permanent">Permanent (Full-Time/Part-Time)</option>
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
            <div id="editLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-25 rounded-2xl">
                <div class="loader border-t-4 border-blue-500 border-solid rounded-full animate-spin h-12 w-12"></div>
            </div>
        </div>
    </div>

     <!-- Edit Requirements Modal -->
     <div id="editRequirementsModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-20 hidden z-20 transition-opacity duration-300">
        <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-4xl w-full relative overflow-hidden">
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
                                <th class="px-2 py-3 text-left text-xs font-medium text-red-900 uppercase tracking-wider">ID</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"># of<br>Req</th>
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
            <div id="addRequirementModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-10 hidden z-20">
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
            <div id="editRequirementModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-10 hidden">
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
            <div id="deleteRequirementModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-10 hidden">
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
    <div id="shareModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-20 backdrop-blur-sm hidden transition-opacity duration-300">
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
            <div id="shareLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-25 rounded-2xl">
                <div class="loader border-t-4 border-green-500 border-solid rounded-full animate-spin h-12 w-12"></div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-20 hidden z-30 transition-opacity duration-300">
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
            <div id="deleteLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-25 rounded-2xl">
                <div class="loader"></div>
            </div>
        </div>
    </div>
    
    <!-- Shared Clearances Modal ID -->
    <div id="sharedClearancesModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-20 hidden z-20">
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

    <!-- Remove Shared Clearance Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-20 hidden z-30">
        <div class="bg-white p-6 rounded-lg shadow-2xl max-w-sm w-full">
            <h3 class="text-xl font-bold mb-4 text-gray-800">Confirm Removal</h3>
            <p class="mb-6">Are you sure you want to remove this shared clearance?</p>
            <div class="flex justify-end">
                <button type="button" onclick="confirmRemoval()" class="px-4 py-2 bg-red-600 text-white rounded-md mr-2">
                    Yes, Remove
                </button>
                <button type="button" onclick="closeConfirmationModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <!-- View Details Modal -->
    <div id="viewDetailsModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-20 hidden z-20 transition-opacity duration-300">
        <div class="bg-white p-5 rounded-2xl shadow-2xl max-w-2xl w-full relative overflow-hidden duration-300 scale-95 hover:scale-100">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-green-400 to-blue-500"></div>
            <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                </svg>
                Clearance Checklist Details
            </h3>
            <div id="clearanceDetailsContent" class="space-y-4 max-h-[60vh] overflow-y-auto pr-4">
                <!-- Clearance Name -->
                <div class="bg-gray-50 p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h4 class="text-xl font-bold text-gray-800">Document Details</h4>
                    </div>
                    <div class="space-y-3">
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500 uppercase tracking-wider">Document Name</span>
                            <p id="clearancesName" class="text-indigo-700 font-medium text-lg"></p>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-500 uppercase tracking-wider">Clearance ID</span>
                                <p id="clearanceId" class="text-red-700 font-medium"></p>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-500 uppercase tracking-wider">Type</span>
                                <p id="clearanceType" class="text-gray-700 font-medium"></p>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-500 uppercase tracking-wider">Units</span>
                                <p id="clearanceUnits" class="text-gray-700 font-medium"></p>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500 uppercase tracking-wider">Description</span>
                            <p id="clearanceDescription" class="text-gray-700 font-medium"></p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-500 uppercase tracking-wider">Created At</span>
                                <p id="clearanceCreatedAt" class="text-gray-700 font-medium"></p>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-500 uppercase tracking-wider">Updated At</span>
                                <p id="clearanceUpdatedAt" class="text-gray-700 font-medium"></p>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex items-center">
                                <span class="text-sm text-gray-500 uppercase tracking-wider">Requirements Count:&nbsp;</span>
                                <span id="requirementCount" class="text-gray-700 font-medium"></span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm text-gray-500 uppercase tracking-wider">Users Copy Count: Not implemented</span>
                                <p id="sharedCount" class="text-gray-700 font-medium"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Requirements List -->
                <div class="bg-gray-50 p-2 rounded-lg">
                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Requirements:</h4>
                    <ol id="requirementsList" class="space-y-3 list-none pl-0 text-[11px]">
                        <!-- Requirements will be populated here -->
                    </ol>
                </div>
            </div>
            <div class="mt-1 flex justify-end sticky bottom-0 bg-white pt-1">
                <button type="button" onclick="closeViewDetailsModal()" 
                    class="px-6 py-1 bg-gray-200 text-gray-700 rounded-md flex items-center 
                    transition duration-300 ease-in-out transform hover:scale-105 
                    hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 
                    focus:ring-opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Loader CSS -->
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

        #clearanceDetailsContent::-webkit-scrollbar {
            width: 8px;
        }

        #clearanceDetailsContent::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        #clearanceDetailsContent::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 4px;
        }

        #clearanceDetailsContent::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        #viewDetailsModal {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        #viewDetailsModal.hidden {
            opacity: 0;
            transform: scale(0.95);
        }

        #viewDetailsModal:not(.hidden) {
            opacity: 1;
            transform: scale(1);
        }

        #requirementsList li {
            @apply bg-white p-4 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200;
            white-space: pre-wrap;
            word-wrap: break-word;
            position: relative;
            padding-left: 2.5rem;
            border-bottom: 2px solid #e2e8f0;
        }

        #requirementsList li::before {
            @apply font-bold text-gray-700;
            content: counter(list-item) ".";
            position: absolute;
            left: 1rem;
        }

        #requirementsList li span {
            @apply ml-2 text-gray-600;
            display: block;
            text-indent: -0.5rem;
            padding-left: 0.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px dashed #e2e8f0;
        }

        #requirementsList li:last-child {
            border-bottom: none;
        }

        #requirementsList li:last-child span {
            border-bottom: none;
        }
        .preserve-whitespace {
            white-space: pre-wrap; /* Preserves whitespace and newlines */
            word-wrap: break-word; /* Allows long words to be broken and wrapped onto the next line */
            /* text-indent: -2em; /* Creates negative indent for hanging effect *
            padding-left: 2em; /* Offsets the negative indent */
        }
    </style>

    <!-- Scripts -->
    <script>
        let allClearances = [];

        document.addEventListener('DOMContentLoaded', function() {
            fetch("{{ route('admin.clearance.all') }}", {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    allClearances = data.clearances;
                    console.log('All clearances loaded:', allClearances); // Debugging line
                } else {
                    console.error('Failed to load clearances:', data.message);
                }
            })
            .catch(error => {
                console.error('Error loading clearances:', error);
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const tableRows = document.querySelectorAll('.clearance-row');
            tableRows.forEach(row => {
                row.addEventListener('click', function() {
                    const clearanceId = this.dataset.id;
                    console.log(`Row clicked: Clearance ID = ${clearanceId}`); // Debugging line
                    openViewDetailsModal(clearanceId);
                });
            });
        });
        /**
         * Open the View Details Modal
         */
        function openViewDetailsModal(clearanceId) {
            console.log(`Opening modal for clearance ID: ${clearanceId}`); // Debugging line

            // Find the clearance in the pre-fetched data
            const clearance = allClearances.find(c => c.id === clearanceId);

            if (clearance) {
                // Populate modal with clearance details
                // Get all elements
                const elements = {
                    name: document.getElementById('clearancesName'),
                    id: document.getElementById('clearanceId'), 
                    description: document.getElementById('clearanceDescription'),
                    units: document.getElementById('clearanceUnits'),
                    type: document.getElementById('clearanceType'),
                    createdAt: document.getElementById('clearanceCreatedAt'),
                    updatedAt: document.getElementById('clearanceUpdatedAt'),
                    requirementCount: document.getElementById('requirementCount'),
                    sharedCount: document.getElementById('sharedCount')
                };

                // Helper function to format date
                const formatDate = (dateString) => {
                    return new Date(dateString).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long', 
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                };

                // Update each element if it exists
                Object.entries(elements).forEach(([key, element]) => {
                    if (element) {
                        let value = clearance[key === 'name' ? 'document_name' : 
                                    key === 'createdAt' ? 'created_at' :
                                    key === 'updatedAt' ? 'updated_at' : key];
                        
                        // Format dates
                        if (key === 'createdAt' || key === 'updatedAt') {
                            value = formatDate(value);
                        }

                         // Set requirements count and shared count
                        if (key === 'requirementCount') {
                            value = clearance.requirements.length;
                        } 
                        // else if (key === 'sharedCount') {
                        //     value = clearance.shared_users_count; // Assuming this data is available
                        // }

                        
                        element.textContent = value;
                        console.log(`${key} set to:`, element.textContent);
                    } else {
                        console.error(`Element with ID "${key}" not found.`);
                    }
                });
                

                const requirementsList = document.getElementById('requirementsList');
                requirementsList.innerHTML = ''; // Clear existing list

                clearance.requirements.forEach(req => {
                    const li = document.createElement('li');
                    const span = document.createElement('span');
                    span.textContent = req.requirement;
                    li.appendChild(span);
                    requirementsList.appendChild(li);
                });

                // Show the modal
                document.getElementById('viewDetailsModal').classList.remove('hidden');
            } else {
                console.error('Clearance not found for ID:', clearanceId);
                showNotification('Failed to fetch clearance details.', 'error');
            }
        }

        /**
         * Close the View Details Modal
         */
        function closeViewDetailsModal() {
            document.getElementById('viewDetailsModal').classList.add('hidden');
        }

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
                    showNotification(data.message, 'successAdd');

                    // Reload the page
                    location.reload();
                } else {
                    addNotification.classList.remove('hidden');
                    addNotification.classList.add('text-red-600');
                    addNotification.innerText = data.message;
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                addLoader.classList.add('hidden');
                console.error('Error:', error);
                showNotification('An error occurred while adding the clearance 101.', 'error');
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
                showNotification('Clearance added successfully.', 'successAdd');
                
                // Wait for 3 seconds before opening the edit requirements modal
                setTimeout(() => {
                    openEditRequirementsModal(newClearanceId, newClearanceName);
                }, 500);
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
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred while fetching clearance data.', 'error');
            });
        }

        function closeEditModal(showNotifications = false) {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editForm').reset();
            document.getElementById('editNotification').classList.add('hidden');

            // Check for session messages and show notifications
            if (!showNotifications) {
                return;
            }
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
                    localStorage.setItem('showEditNotification', 'true');
                    // Optionally, update the table without reloading
                    // showNotification(data.message, 'successEdit');
                    location.reload();
                    // closeEditModal(true);
                } else {
                    editNotification.classList.remove('hidden');
                    editNotification.classList.add('text-red-600');
                    editNotification.innerText = data.message;
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                editLoader.classList.add('hidden');
                console.error('Error:', error);
                showNotification('An error occurred while updating the clearance.', 'error');
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('showEditNotification') === 'true') {
                showNotification('Clearance edited successfully.', 'successEdit');
                localStorage.removeItem('showEditNotification');
            }
        });

        // Delete Modal Functions
        let currentDeleteId;

        function openDeleteModal(id, name) {
            currentDeleteId = id;
            document.getElementById('clearanceName').innerText = name;
            document.getElementById('deleteForm').action = `/admin/clearance/delete/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }
        function closeDeleteModal(showNotifications = false) {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteNotification').classList.add('hidden');
            // Remove any error notifications when just closing the modal
            if (!showNotifications) {
                return;
            }
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
                    showNotification(data.message, 'successDelete');
                    location.reload();
                    closeDeleteModal(true);
                } else {
                    deleteNotification.classList.remove('hidden');
                    deleteNotification.innerText = data.message;
                    showNotification('Deleting Clearance Failed.', 'error');
                }
            })
            .catch(error => {
                deleteLoader.classList.add('hidden');
                console.error('Error:', error);
                showNotification('An error occurred while deleting the clearance.', 'error');
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
                    showNotification('Failed to fetch requirements.', 'error');
                }
            })
            .catch(error => {
                console.error('Error fetching requirements:', error);
                showNotification('An error occurred while fetching requirements.', 'error');
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
                    <td class="px-2 py-2 border text-sm text-gray-300">${req.id}</td>
                    <td class="px-4 py-2 border text-sm">${tbody.children.length + 1}</td>
                    <td class="px-4 py-2 border preserve-whitespace text-sm text-black">${req.requirement}</td>
                    <td class="px-4 py-2 border text-sm">
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
                    showNotification(data.message, 'successAddRequirement');
                } else {
                    addRequirementNotification.classList.remove('hidden');
                    addRequirementNotification.innerText = data.message;
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred while adding the requirement.', 'error');
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
                    showNotification('Failed to fetch requirement data.', 'error');
                }
            })
            .catch(error => {
                console.error('Error fetching requirement data:', error);
                showNotification('An error occurred while fetching requirement data.', 'error');
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
                showNotification('Requirement cannot be empty.', 'error');
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
                    showNotification(data.message, 'successUpdate');

                    // Reset and close the modal after a short delay
                    setTimeout(() => {
                        closeEditRequirementModal();
                    }, 1500);
                } else {
                    showNotification(data.message || 'Failed to update requirement.', 'error');
                }
            })
            .catch(error => {
                console.error('Error updating requirement:', error);
                showNotification('An error occurred while updating the requirement.', 'error');
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
                    showNotification('Requirement deleted successfully.', 'successDeleteRequirement');
                } else {
                    deleteRequirementNotification.classList.remove('hidden');
                    deleteRequirementNotification.innerText = data.message;
                    showNotification('Failed to delete requirement.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred while deleting the requirement.', 'error');
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
                    showNotification(data.message, 'successShared');
                    // Optionally, reload the page to reflect changes
                    setTimeout(() => {
                        closeShareModal();
                    }, 1000);
                } else {
                    shareNotification.classList.remove('hidden');
                    shareNotification.innerText = data.message;
                }
            })
            .catch(error => {
                shareLoader.classList.add('hidden');
                console.error('Error sharing clearance:', error);
                showNotification('An error occurred while sharing the clearance.', 'error');
            });
        });
    </script>
    <!-- Share Clearance Modal -->
    <script>
        let clearanceIdToRemove = null;

        function openConfirmationModal(id) {
            clearanceIdToRemove = id;
            document.getElementById('confirmationModal').classList.remove('hidden');
        }

        function closeConfirmationModal() {
            clearanceIdToRemove = null;
            document.getElementById('confirmationModal').classList.add('hidden');
        }

        function confirmRemoval() {
            if (clearanceIdToRemove !== null) {
                removeSharedClearance(clearanceIdToRemove);
                closeConfirmationModal();
            }
        }

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
                                <button onclick="openConfirmationModal(${clearance.id})" class="text-red-600 hover:text-red-800 flex items-center text-sm">
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
                    showNotification('An error occurred while fetching shared clearances.', 'error');
                });
        }
    
        function removeSharedClearance(id) {
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
                    showNotification(data.message, 'successRemovedShared');
                } else {
                    showNotification(data.message || 'Failed to remove shared clearance.', 'error');
                }
            })
            .catch(error => {
                console.error('Error removing shared clearance:', error);
                showNotification('An error occurred while removing the shared clearance.', 'error');
            });
        }
    </script>

   <!-- Notification -->
        <div id="notification" class="hidden fixed top-0 right-0 m-6 p-4 rounded-lg shadow-lg transition-all duration-500 transform translate-x-full z-50">
            <div class="flex items-center">
                <div id="notificationIcon" class="flex-shrink-0 w-6 h-6 mr-3"></div>
                <div id="notificationMessage" class="text-sm font-medium"></div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                    @if(session('notification'))
                        showNotification('{{ session('notification') }}', 'success');
                    @endif

                    @if(session('error'))
                        showNotification('{{ session('error') }}', 'error');
                    @endif

                    @if(session('successRemovedShared'))
                        showNotification('{{ session('successRemovedShared') }}', 'successRemovedShared');
                    @endif

                    @if(session('successShared'))
                        showNotification('{{ session('successShared') }}', 'successShared');
                    @endif

                    @if(session('successUpdate'))
                        showNotification('{{ session('successUpdate') }}', 'successUpdate');
                    @endif

                    @if(session('successDelete'))
                        showNotification('{{ session('successDelete') }}', 'successDelete');
                    @endif

                    @if(session('successEdit'))
                        showNotification('{{ session('success') }}', 'success');
                    @endif

                    @if(session('successAddRequirement'))
                        showNotification('{{ session('successAddRequirement') }}', 'successAddRequirement');
                    @endif

                    @if(session('successAdd'))
                        showNotification('{{ session('successAdd') }}', 'successAdd');
                @endif
            });

            function showNotification(message, type = 'success') {
                const notification = document.getElementById('notification');
                const notificationMessage = document.getElementById('notificationMessage');
                const notificationIcon = document.getElementById('notificationIcon');

                notificationMessage.textContent = message;

                // Reset classes
                notification.className = 'hidden fixed top-0 right-0 m-6 p-4 rounded-lg shadow-lg transition-all duration-500 transform translate-x-full z-50';
                notificationIcon.innerHTML = '';

                if (type === 'success') {
                    notification.classList.add('bg-emerald-50', 'border-l-4', 'border-emerald-200', 'text-emerald-600');
                    notificationIcon.innerHTML = '<svg class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                } else if (type === 'error') {
                    notification.classList.add('bg-rose-50', 'border-l-4', 'border-rose-200', 'text-rose-600');
                    notificationIcon.innerHTML = '<svg class="h-6 w-6 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                } else if (type === 'successRemovedShared') {
                    notification.classList.add('bg-orange-50', 'border-l-4', 'border-orange-200', 'text-orange-600');
                    notificationIcon.innerHTML = '<svg class="h-6 w-6 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>';
                } else if (type === 'successShared') {
                    notification.classList.add('bg-emerald-50', 'border-l-4', 'border-emerald-200', 'text-emerald-600');
                    notificationIcon.innerHTML = '<svg class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                } else if (type === 'successUpdate') {
                    notification.classList.add('bg-sky-50', 'border-l-4', 'border-sky-200', 'text-sky-600');
                    notificationIcon.innerHTML = '<svg class="h-6 w-6 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>';
                } else if (type === 'successDelete') {
                    notification.classList.add('bg-orange-50', 'border-l-4', 'border-orange-200', 'text-orange-600');
                    notificationIcon.innerHTML = '<svg class="h-6 w-6 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>';
                } else if (type === 'successEdit') {
                    notification.classList.add('bg-sky-50', 'border-l-4', 'border-sky-200', 'text-sky-600');
                    notificationIcon.innerHTML = '<svg class="h-6 w-6 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>';
                } else if (type === 'successAddRequirement') {
                    notification.classList.add('bg-emerald-50', 'border-l-4', 'border-emerald-200', 'text-emerald-600');
                    notificationIcon.innerHTML = '<svg class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                } else if (type === 'successAdd') {
                    notification.classList.add('bg-emerald-50', 'border-l-4', 'border-emerald-200', 'text-emerald-600');
                    notificationIcon.innerHTML = '<svg class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                }

                notification.classList.remove('hidden', 'translate-x-full');
                notification.classList.add('translate-x-0');

                setTimeout(() => {
                    notification.classList.remove('translate-x-0');
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        notification.classList.add('hidden');
                        notification.classList.remove('bg-green-100', 'border-l-4', 'border-green-500', 'text-green-700', 'bg-red-100', 'border-red-500', 'text-red-700');
                    }, 500);
                }, 5000);
            }

        </script>
</x-admin-layout>
