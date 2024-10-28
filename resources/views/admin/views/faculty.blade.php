<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Faculty') }}
        </h2>
    </x-slot>
    <script src="{{ asset('js/faculty.js') }}"></script>

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
        z-index: 0; /* Ensure it stays above other content */
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
            z-index: 0; /* Ensure it stays above other content */
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

        #manageModal .faculty-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.5rem;
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        #manageModal .faculty-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 0.5rem;
        }

        #manageModal .faculty-item div {
            display: flex;
            flex-direction: column;
        }

        .initials {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 0.5rem;
            font-size: 14px;
        }

        .profile-card {
            display: flex;
            align-items: center;
            background-color: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }

        .profile-card img {
            border-radius: 50%;
            width: 4rem;
            height: 4rem;
            object-fit: cover;
        }

        .profile-card h3 {
            font-size: 1.125rem;
            font-weight: 600;
        }

        .profile-card p {
            font-size: 0.875rem;
            color: #4a5568;
        }

        .profile-card button {
            margin-top: 0.5rem;
            padding: 0.25rem 1rem;
            font-size: 0.875rem;
            background-color: #4299e1;
            color: white;
            border-radius: 0.375rem;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .profile-card button:hover {
            background-color: #3182ce;
            transform: scale(1.05);
        }
    </style>


            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-4">Faculty Management</h2>
                <p>Here you can manage Faculty members.</p>
                <!-- Add your Faculty management content here -->
                <div class="flex justify-between items-center mb-4">
                    <form method="GET" action="{{ route('admin.views.faculty') }}" class="flex items-center w-4/5">
                        <input type="text" name="search" placeholder="Search by name, email, department, program, units, or position..." value="{{ request('search') }}" class="border rounded p-2 mr-2 w-1/2">
                        <select name="sort" class="border rounded p-2 mr-2 w-40">
                            <option value="" disabled selected>Sort by</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name A to Z</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name Z to A</option>
                            <option value="college_asc" {{ request('sort') == 'college_asc' ? 'selected' : '' }}>College A to Z</option>
                            <option value="college_desc" {{ request('sort') == 'college_desc' ? 'selected' : '' }}>College Z to A</option>
                            <option value="program_asc" {{ request('sort') == 'program_asc' ? 'selected' : '' }}>Program A to Z</option>
                            <option value="program_desc" {{ request('sort') == 'program_desc' ? 'selected' : '' }}>Program Z to A</option>
                            <option value="units_asc" {{ request('sort') == 'units_asc' ? 'selected' : '' }}>Units Low to High</option>
                            <option value="units_desc" {{ request('sort') == 'units_desc' ? 'selected' : '' }}>Units High to Low</option>
                        </select>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Apply</button>
                    </form>
                    <button onclick="openManageModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg">
                        Manage My Faculty
                    </button>
                </div>
            </div>
            
            <!-- Faculty Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 max-w-full border border-gray-300">
                <div class="table-container overflow-y-auto" style="max-height: 490px;">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-200 sticky-header">
                            <tr>
                                <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dept</th>
                                <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program</th>
                                <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Units</th>
                                <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                                <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Managed By</th>
                                <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200"> 
                            @foreach ($faculty as $member)
                            <tr>
                                <td class="px-2 py-3 whitespace-nowrap">{{ $member->id }}</td>
                                <td class="px-2 py-3 whitespace-nowrap">{{ $member->name }}</td>
                                <td class="px-2 py-3 whitespace-nowrap">{{ $member->email }}</td>
                                <td class="px-2 py-3 whitespace-nowrap">{{ $member->department->name ?? 'N/A' }}</td>
                                <td class="px-2 py-3 whitespace-nowrap">{{ $member->program_name ?? '' }}</td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">{{ $member->units }}</td>
                                <td class="px-2 py-3 whitespace-nowrap">{{ $member->position }}</td>
                                <td class="px-2 py-3 whitespace-nowrap">
                                    {{ $member->managingAdmins->pluck('name')->join(', ') ?? 'N/A' }}
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">{{ $member->user_type }}</td>
                                <td class="py-2 px-2 border-b">
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
  

        <!-- Edit Modal -->
        <!-- Edit Modal -->
        <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-70 hidden z-50 transition-opacity duration-300">
            <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-400 to-green-500"></div>
                <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Edit Faculty
                </h3>
                <form id="editForm" method="POST" action="{{ route('admin.faculty.edit') }}" class="space-y-6">
                    @csrf
                    <div class="bg-white p-2 mb-2 flex justify-center items-center">
                        <div class="w-24 h-24 rounded-full overflow-hidden">
                            <img id="profileImage" src="default-profile.png" alt="Profile Picture" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <input type="hidden" name="id" id="editId">
                    <div class="space-y-4">
                        <div class="relative">
                            <label for="editName" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" name="name" id="editName" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" required autocomplete="name">
                        </div>
                        <div class="relative">
                            <label for="editEmail" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="editEmail" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" required autocomplete="email">
                        </div>
                        <div class="relative">
                            <label for="editDepartment" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                            <select name="department_id" id="editDepartment" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" required>
                                <option value="">Select Department</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="relative">
                            <label for="editProgram" class="block text-sm font-medium text-gray-700 mb-1">Program</label>
                            <select name="program_id" id="editProgram" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" required>
                                <option value="">Select Program</option>
                                @foreach ($programs as $program)
                                    <option value="{{ $program->id }}" data-department="{{ $program->department_id }}">{{ $program->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const departmentSelect = document.getElementById('editDepartment');
                                const programSelect = document.getElementById('editProgram');
                                const programOptions = programSelect.querySelectorAll('option');

                                function filterPrograms() {
                                    const selectedDepartmentId = departmentSelect.value;
                                    programOptions.forEach(option => {
                                        if (option.value === "") return; // Skip the "Select Program" option
                                        if (selectedDepartmentId === "" || option.dataset.department === selectedDepartmentId) {
                                            option.style.display = "";
                                        } else {
                                            option.style.display = "none";
                                        }
                                    });
                                    // Reset program selection when department changes
                                    programSelect.value = "";
                                }

                                departmentSelect.addEventListener('change', filterPrograms);

                                // Initial filter
                                filterPrograms();
                            });
                        </script>
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-3">
                                <label for="editUnits" class="block text-sm font-medium text-gray-700 mb-1">Units</label>
                                <input type="number" name="units" id="editUnits" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                            </div>
                            <div class="col-span-5">
                                <label for="editPosition" class="block text-sm font-medium text-gray-700 mb-1">Status/Position</label>
                                <select name="position" id="editPosition" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" required>
                                    <option value="Permanent">Permanent</option>
                                    <option value="Part-Timer">Part-Timer</option>
                                    <option value="Temporary">Temporary</option>
                                </select>
                            </div>
                            <div class="col-span-4">
                                <label for="editUserType" class="block text-sm font-medium text-gray-700 mb-1">Account Type</label>
                                <select name="user_type" id="editUserType" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" required>
                                    <option value="admin">Admin</option>
                                    <option value="faculty">Faculty</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end space-x-4">
                        <button type="button" onclick="closeEditModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md flex items-center transition duration-300 ease-in-out hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md flex items-center transition duration-300 ease-in-out hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Save Changes
                        </button>
                    </div>
                </form>
                <div id="editNotification" class="hidden mt-4 text-green-600 bg-green-100 p-3 rounded-lg border border-green-200"></div>
                
                <!-- Loader for Edit Modal -->
                <div id="editLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-75 rounded-2xl">
                    <div class="loader border-t-4 border-blue-500 border-solid rounded-full animate-spin h-12 w-12"></div>
                </div>
            </div>
        </div>
    
        <!-- Delete Modal -->
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
                <p class="mb-6 text-lg text-gray-600">Are you sure you want to delete <span id="facultyName" class="font-bold text-red-600"></span>? This action cannot be undone.</p>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="mt-8 flex justify-end space-x-4">
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
                    <div class="loader border-t-4 border-red-500 border-solid rounded-full animate-spin h-12 w-12"></div>
                </div>
            </div>
        </div>


        <!-- Assign Faculty -->
        <div id="manageModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-70 hidden z-50 transition-opacity duration-300">
            <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-4xl w-full h-[90vh] relative overflow-hidden flex flex-col">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-400 to-green-500"></div>
                <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Manage Faculty
                </h3>
                
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div class="relative">
                        <input type="text" id="facultyNameSearch" placeholder="Search by name..." class="w-full pl-8 pr-3 py-1 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300" onkeyup="filterFaculty()">
                        <svg class="absolute left-2 top-1.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <div class="relative">
                        <input type="text" id="facultyDepartmentSearch" placeholder="Search by college..." class="w-full pl-8 pr-3 py-1 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300" onkeyup="filterFaculty()">
                        <svg class="absolute left-2 top-1.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div class="relative">
                        <input type="text" id="facultyPositionSearch" placeholder="Search by position..." class="w-full pl-8 pr-3 py-1 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300" onkeyup="filterFaculty()">
                        <svg class="absolute left-2 top-1.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="relative">
                        <input type="text" id="facultyProgramSearch" placeholder="Search by program..." class="w-full pl-8 pr-3 py-1 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300" onkeyup="filterFaculty()">
                        <svg class="absolute left-2 top-1.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                </div>  
                
                <div class="flex justify-between mb-3 flex-grow overflow-hidden">
                    <div class="w-1/2 pr-2 flex flex-col h-full">
                        <h4 class="text-base font-medium mb-1 text-gray-700">Available Faculty</h4>
                        <div class="flex justify-between mb-2">
                            <button onclick="deselectAll('unselectedFaculty')" class="px-2 py-1 text-sm bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-300 ease-in-out">Deselect All</button>
                        </div>
                        <div id="unselectedFaculty" class="border rounded-lg p-2 flex-grow overflow-y-auto bg-gray-50 shadow-inner"></div>
                        <button onclick="addSelected()" class="mt-2 px-4 py-1 text-sm bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">Add Selected</button>
                    </div>
                    <div class="w-1/2 pl-2 flex flex-col h-full">
                        <h4 class="text-base font-medium mb-1 text-gray-700">My Managed Faculty</h4>
                        <div class="flex justify-between mb-2">
                            <button onclick="selectAll('selectedFaculty')" class="px-2 py-1 text-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out">Select All</button>
                            <button onclick="deselectAll('selectedFaculty')" class="px-2 py-1 text-sm bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-300 ease-in-out">Deselect All</button>
                        </div>
                        <div id="selectedFaculty" class="border rounded-lg p-2 flex-grow overflow-y-auto bg-gray-50 shadow-inner"></div>
                        <button onclick="removeSelected()" class="mt-2 px-4 py-1 text-sm bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">Remove Selected</button>
                    </div>
                </div>
                
                <div id="notification" class="hidden fixed bottom-4 right-4 p-3 bg-green-100 text-green-700 rounded-lg shadow-lg transition-opacity duration-300 ease-in-out z-50"></div>
        
                <div class="flex justify-end mt-4">
                    <button onclick="updateFaculty()" class="px-4 py-1 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50">Save</button>
                    <button onclick="closeManageModal()" class="ml-2 px-4 py-1 text-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Close</button>
                </div>
            </div>
        </div>
        

    <!-- Script for Assign Faculty -->
    <script>
        function getInitials(name) {
            return name.split(' ').map(word => word[0]).join('').toUpperCase();
        }

        function getRandomColor() {
            const colors = [
                '#FFB6C1', '#FF69B4', '#4682B4', '#1E90FF', '#90EE90',
                '#3CB371', '#FFA07A', '#FF7F50', '#FF0000', '#DC143C',
                '#D2691E', '#CD853F', '#708090', '#778899', '#00CED1',
                '#20B2AA', '#8A2BE2', '#DDA0DD', '#B0C4DE', '#00FA9A',
                '#48D1CC', '#C71585', '#191970', '#F0E68C', '#AFEEEE',
                '#DB7093', '#FFDAB9', '#CD5C5C', '#40E0D0', '#9ACD32',
                '#7B68EE', '#FA8072', '#F4A460', '#D8BFD8', '#DEB887',
                '#5F9EA0', '#FF4500', '#DA70D6', '#EEE8AA', '#98FB98',
                '#F0FFF0', '#F5DEB3', '#FFDAB9', '#D2B48C', '#FAEBD7'
            ];
            return colors[Math.floor(Math.random() * colors.length)];
        }

        function openManageModal() {
            fetch('/admin/admin/manage-faculty', {
                method: 'GET',
                headers: { 'Accept': 'application/json' },
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Log the data to check its structure   
                const unselectedFaculty = document.getElementById('unselectedFaculty');
                const selectedFaculty = document.getElementById('selectedFaculty');
                unselectedFaculty.innerHTML = '';
                selectedFaculty.innerHTML = '';

                data.allFaculty.forEach(faculty => {
                    const isManaged = data.managedFaculty.includes(faculty.id);
                    const managedBy = faculty.managed_by || 'None'; // Use the managed_by field

                    const departmentName = faculty.department ? faculty.department.name : 'N/A';
                    const programName = faculty.program ? faculty.program.name : 'N/A';
                    const profilePicture = faculty.profile_picture ? 
                        `<img src="${faculty.profile_picture}" alt="${faculty.name}" class="w-10 h-10 rounded-full mr-1">` :
                        `<div class="initials w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold mr-1" style="background-color: ${getRandomColor()};">${getInitials(faculty.name)}</div>`;

                    const facultyItem = `
                        <div class="flex items-center mb-2 p-1 bg-white rounded shadow text-xs">
                            <input type="checkbox" id="faculty-${faculty.id}" class="mr-1">
                            ${profilePicture}
                            <div class="overflow-hidden">
                                <strong>${faculty.name}</strong> - ${faculty.position}<br>
                                <span class="text-xxs text-gray-600">${departmentName} - ${programName}</span><br>
                                <span class="text-xxs text-gray-500">Managed by: ${managedBy}</span>
                            </div>
                        </div>
                    `;
                    if (isManaged) {
                        selectedFaculty.innerHTML += facultyItem;
                    } else {
                        unselectedFaculty.innerHTML += facultyItem;
                    }
                });

                document.getElementById('manageModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching faculty data:', error);
                showNotification('An error occurred while fetching faculty data.');
            });
        }

        function triggerDeselectAll(containerId) {
            const deselectButton = document.querySelector(`#${containerId} ~ .flex button:nth-child(2)`);
            if (deselectButton) {
                deselectButton.click();
            }
        }

        function addSelected() {
            const selectedFaculty = document.getElementById('selectedFaculty');
            const unselectedFaculty = document.getElementById('unselectedFaculty');

            unselectedFaculty.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                const facultyItem = checkbox.parentElement;
                selectedFaculty.appendChild(facultyItem);
            });

            updateFaculty();
            deselectAll('unselectedFaculty'); // Uncheck all after adding
        }

        function removeSelected() {
            const selectedFaculty = document.getElementById('selectedFaculty');
            const unselectedFaculty = document.getElementById('unselectedFaculty');

            selectedFaculty.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                const facultyItem = checkbox.parentElement;
                unselectedFaculty.appendChild(facultyItem);
            });

            updateFaculty();
            deselectAll('selectedFaculty'); // Uncheck all after removing
        }

        function updateFaculty() {
            const allSelectedIds = Array.from(document.querySelectorAll('#selectedFaculty input[type="checkbox"]'))
                .map(checkbox => parseInt(checkbox.id.replace('faculty-', '')));

            fetch('/admin/admin/assign-faculty', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    admin_id: {{ Auth::id() }},
                    faculty_ids: allSelectedIds,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Faculty updated successfully!');
                    deselectAll('selectedFaculty');
                    deselectAll('unselectedFaculty');
                } else {
                    showNotification('Failed to update faculty: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error updating faculty management:', error);
                showNotification('An error occurred while updating faculty management: ' + error.message);
            });
        }

        function closeManageModal() {
            document.getElementById('manageModal').classList.add('hidden');
        }

        function selectAll(containerId) {
            const container = document.getElementById(containerId);
            container.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.checked = true;
            });
        }

        function deselectAll(containerId) {
            const container = document.getElementById(containerId);
            if (container) {
                container.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                    checkbox.checked = false;
                });
            } else {
                console.error(`Container with ID ${containerId} not found.`);
            }
        }
    </script>

    <!-- Script for Notification -->
    <script>
        function showNotification(message) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.classList.remove('hidden');
            
            // Hide notification after 3 seconds
            setTimeout(() => {
                notification.classList.add('hidden');
            }, 3000);
        }
    </script>

    <!-- Script for Filtering Faculty -->
    <script>
        function filterFaculty() {
            console.log('Filtering faculty...');
            const nameSearch = document.getElementById('facultyNameSearch').value.toLowerCase();
            const departmentSearch = document.getElementById('facultyDepartmentSearch').value.toLowerCase();
            const positionSearch = document.getElementById('facultyPositionSearch').value.toLowerCase();
            const programSearch = document.getElementById('facultyProgramSearch').value.toLowerCase();
            const unselectedFaculty = document.getElementById('unselectedFaculty');
            const selectedFaculty = document.getElementById('selectedFaculty');

            function filterList(list) {
                Array.from(list.children).forEach(item => {
                    const name = item.querySelector('strong').textContent.toLowerCase();
                    const details = item.querySelector('span').textContent.toLowerCase();
                    const matchesName = name.includes(nameSearch);
                    const matchesDepartment = details.includes(departmentSearch);
                    const matchesPosition = details.includes(positionSearch);
                    const matchesProgram = details.includes(programSearch);

                    if (matchesName && matchesDepartment && matchesPosition && matchesProgram) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }

            filterList(unselectedFaculty);
            filterList(selectedFaculty);
        }
    </script>

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

        function getInitials(name) {
            return name.split(' ')[0][0].toUpperCase();
        }

        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        function openEditModal(id) {
            currentEditId = id;
            fetch(`/admin/faculty/edit/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const faculty = data.faculty;
                    const profileImage = document.getElementById('profileImage');
                    if (faculty.profile_picture) {
                        profileImage.src = faculty.profile_picture;
                        profileImage.style.backgroundColor = '';
                        profileImage.textContent = '';
                    } else {
                        const initials = getInitials(faculty.name);
                        const bgColor = getRandomColor();
                        profileImage.src = '';
                        profileImage.style.backgroundColor = bgColor;
                        profileImage.textContent = initials;
                        profileImage.style.display = 'flex';
                        profileImage.style.alignItems = 'center';
                        profileImage.style.justifyContent = 'center';
                        profileImage.style.color = 'white';
                        profileImage.style.fontWeight = 'bold';
                        profileImage.style.fontSize = '2rem';
                    }

                    document.getElementById('editId').value = faculty.id;
                    document.getElementById('editName').value = faculty.name;
                    document.getElementById('editEmail').value = faculty.email;
                    document.getElementById('editDepartment').value = faculty.department_id;
                    document.getElementById('editProgram').value = faculty.program_id;
                    document.getElementById('editUnits').value = faculty.units;
                    document.getElementById('editPosition').value = faculty.position;
                    document.getElementById('editUserType').value = faculty.user_type;
                    document.getElementById('editForm').action = `/admin/faculty/edit`;
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
                department_id: document.getElementById('editDepartment').value,
                program_id: document.getElementById('editProgram').value,
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
