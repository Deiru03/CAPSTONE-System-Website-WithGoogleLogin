<!-- resources/views/admin/views/admin-id-management.blade.php -->
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin ID Management') }}
        </h2>
    </x-slot>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <div class="container mx-auto p-4">
        <!-- Tab Navigation -->
        <div class="border-b border-gray-200 mb-4">
            <nav class="flex -mb-px">
                <button onclick="switchTab('admin')" id="admin-tab" class="tab-button px-6 py-3 border-b-2 font-medium text-sm leading-5 focus:outline-none transition duration-150 ease-in-out">
                    Admin ID Management
                </button>
                <button onclick="switchTab('program-head-dean')" id="phd-tab" class="tab-button px-6 py-3 border-b-2 font-medium text-sm leading-5 focus:outline-none transition duration-150 ease-in-out ml-8">
                    Program Head & Dean Management
                </button>
            </nav>
        </div>

        <!-- Admin ID Management Section -->
        <div id="admin-content" class="tab-content">
            <!-- Form to create a new Admin ID -->
            <form action="{{ route('admin.createAdminId') }}" method="POST" class="mb-6">
                @csrf
                <div class="mb-4">
                    <label for="admin_id" class="block text-sm font-medium text-gray-700">New Admin ID</label>
                    <div class="flex gap-2">
                        <input type="text" name="admin_id" id="admin_id" class="mt-1 block w-1/2 border-gray-300 rounded-md shadow-sm" required>
                        <button type="button" onclick="generateRandomAdminId()" class="mt-1 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                            Generate Random ID
                        </button>
                    </div>
                </div>
                <button type="submit" class="w-1/4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Create Admin ID</button>
            </form>

            <!-- List of existing Admin IDs -->
            <h2 class="text-xl font-semibold mb-2">Existing Admin IDs</h2>
            <div class="overflow-auto h-[600px]">
                <table class="min-w-full bg-white text-xs">
                    <thead class="sticky top-0 bg-gray-100 shadow-sm">
                        <tr>
                            <th class="px-6 py-3 border-b-2 border-blue-300 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider bg-gradient-to-r from-gray-50 to-gray-100">ID</th>
                            <th class="px-6 py-3 border-b-2 border-blue-300 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider bg-gradient-to-r from-gray-50 to-gray-100">Admin ID</th>
                            <th class="px-6 py-3 border-b-2 border-blue-300 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider bg-gradient-to-r from-gray-50 to-gray-100">Assigned</th>
                            <th class="px-6 py-3 border-b-2 border-blue-300 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider bg-gradient-to-r from-gray-50 to-gray-100">Assigned User</th>
                            <th class="px-6 py-3 border-b-2 border-blue-300 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider bg-gradient-to-r from-gray-50 to-gray-100">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($adminIds as $adminId)
                        <tr class="{{ $adminId->is_assigned ? 'bg-red-50' : 'bg-sky-50' }}">
                            <td class="px-4 py-2 border-b border-gray-300">{{ $adminId->id }}</td>
                            <td class="px-4 py-2 border-b border-gray-300">{{ $adminId->admin_id }}</td>
                            <td class="px-4 py-2 border-b border-gray-300">{{ $adminId->is_assigned ? 'Yes' : 'No' }}</td>
                            <td class="px-4 py-2 border-b border-gray-300">{{ $adminId->users->first() ? $adminId->users->first()->name : 'N/A' }}</td>
                            <td class="px-4 py-2 border-b border-gray-300">
                                <button type="button" onclick="confirmDelete({{ $adminId->id }})" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">Remove</button>

                                @if(!$adminId->is_assigned)
                                    <button type="button" onclick="openAssignModalAdmin({{ $adminId->id }})" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded">Assign User</button>
                                @endif

                                <form id="delete-form-{{ $adminId->id }}" action="{{ route('admin.deleteAdminId', $adminId->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <script>
                                function confirmDelete(id) {
                                    if (confirm('Are you sure you want to delete this Admin ID?')) {
                                        document.getElementById('delete-form-' + id).submit();
                                    }
                                }
                                </script>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal for Assigning User -->
        <div id="assignModalAdmin" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-30 hidden z-10 transition-opacity duration-300">
            <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full relative overflow-hidden duration-300">
                <!-- Decorative gradient bar -->
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-400 to-indigo-500"></div>

                <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Assign Admin ID
                </h3>

                <div class="space-y-6" style="z-index: 9999">
                    <div class="relative">
                        <label for="userSelect" class="block text-sm font-medium text-gray-700 mb-1 w-full">Select User</label>
                        <div class="relative">
                            <select id="userSelectAdmin" class="w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                <option value="" disabled selected>Choose a user to assign...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" class="py-2">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            {{-- <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div> --}}
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-4">
                        <button type="button" onclick="closeAssignModalAdmin()"
                            class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </button>
                        <button onclick="assignUserAdmin()"
                            class="px-6 py-3 bg-blue-600 text-white rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Assign User
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let currentAdminId = null;

            function openAssignModalAdmin(adminId) {
                currentAdminId = adminId;
                document.getElementById('assignModalAdmin').classList.remove('hidden');
            }

            function closeAssignModalAdmin() {
                document.getElementById('assignModalAdmin').classList.add('hidden');
            }

            function assignUserAdmin() {
                const userId = document.getElementById('userSelectAdmin').value;
                if (userId) {
                    fetch(`/admin/admin/assign-admin-id`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ adminId: currentAdminId, userId: userId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('User assigned successfully!');
                            closeAssignModalAdmin();
                            location.reload(); // Reload the page to reflect changes
                        } else {
                            alert('Failed to assign user.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred.');
                    });
                } else {
                    alert('Please select a user.');
                }
            }
        </script>

        <script>
            $(document).ready(function() {
                $('#userSelectAdmin').select2({
                    placeholder: "Choose a user to assign...",
                    allowClear: true,
                    width: '100%',
                    zIndex: 9999
                });
            });
        </script>


        {{-- --------------------------------------------- Program Head & Dean ID Management Section ------------------------------------------------ --}}
        <!-- Program Head & Dean ID Management Section -->
        <div id="phd-content" class="tab-content hidden">
            <!-- Form to create a new Program Head/Dean ID -->
            <form action="{{ route('admin.createProgramHeadDeanId') }}" method="POST" class="mb-6">
                @csrf
                <div class="mb-4">
                    <label for="identifier" class="block text-sm font-medium text-gray-700">New ID</label>
                    <div class="flex gap-2">
                        <input type="text" name="identifier" id="identifier" class="mt-1 block w-1/4 border-gray-300 rounded-md shadow-sm" required>
                        <select name="type" class="mt-1 block w-1/4 border-gray-300 rounded-md shadow-sm">
                            <option value="" disabled selected>Select Type</option>
                            <option value="">Unassigned</option>
                            <option value="Program-Head">Program Head</option>
                            <option value="Dean">Dean</option>
                        </select>
                        <button type="button" onclick="generateRandomPHDId()" class="mt-1 w-1/4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                            Generate Random ID
                        </button>
                    </div>
                </div>
                <button type="submit" class="w-1/4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Create ID</button>
            </form>

            <!-- List of existing Program Head/Dean IDs -->
            <h2 class="text-xl font-semibold mb-2">Existing Program Head & Dean IDs</h2>
            <div class="overflow-auto h-[600px]"> <!-- Added fixed height container with scroll -->
                <table class="min-w-full bg-white text-xs">
                    <thead class="sticky top-0 bg-gray-100 shadow-sm">
                        <tr>
                            <th class="px-6 py-3 border-b-2 border-blue-300 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider bg-gradient-to-r from-gray-50 to-gray-100">ID</th>
                            <th class="px-6 py-3 border-b-2 border-blue-300 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider bg-gradient-to-r from-gray-50 to-gray-100">Identifier</th>
                            <th class="px-6 py-3 border-b-2 border-blue-300 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider bg-gradient-to-r from-gray-50 to-gray-100">Type</th>
                            <th class="px-6 py-3 border-b-2 border-blue-300 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider bg-gradient-to-r from-gray-50 to-gray-100">Assigned</th>
                            <th class="px-6 py-3 border-b-2 border-blue-300 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider bg-gradient-to-r from-gray-50 to-gray-100">Assigned User</th>
                            <th class="px-6 py-3 border-b-2 border-blue-300 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider bg-gradient-to-r from-gray-50 to-gray-100">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($programHeadDeanIds as $id)
                        <tr class="{{ $id->is_assigned ? 'bg-red-50' : 'bg-sky-50' }}">
                            <td class="px-4 py-2 border-b border-gray-300">{{ $id->id }}</td>
                            <td class="px-4 py-2 border-b border-gray-300">{{ $id->identifier }}</td>
                            <td class="px-4 py-2 border-b border-gray-300">
                                @if($id->type == 'Program-Head')
                                    <span class="text-blue-600 font-medium">{{ $id->type }}</span>
                                @elseif($id->type == 'Dean')
                                    <span class="text-emerald-600 font-medium">{{ $id->type }}</span>
                                @else
                                    <span class="text-gray-500">Unassigned</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 border-b border-gray-300">{{ $id->is_assigned ? 'Yes' : 'No' }}</td>
                            <td class="px-4 py-2 border-b border-gray-300">{{ $id->user ? $id->user->name : 'N/A' }}</td>
                            <td class="px-4 py-2 border-b border-gray-300">
                                <button type="button" onclick="confirmDelete({{ $id->id }})" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">Remove</button>

                                @if(!$id->is_assigned)
                                    <button type="button" onclick="openAssignModalProgramHeadDean({{ $id->id }})" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded">Assign User</button>
                                @endif

                                <form id="delete-form-{{ $id->id }}" action="{{ route('admin.deleteProgramHeadDeanId', $id->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <script>
                                    function confirmDelete(id) {
                                        if (confirm('Are you sure you want to delete this ID?')) {
                                            document.getElementById('delete-form-' + id).submit();
                                        }
                                    }
                                </script>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="assignModalPHD" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-30 hidden z-10">
        <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full">
            <h3 class="text-3xl font-bold mb-6 text-gray-800">Assign Admin ID</h3>
            <div class="space-y-6">
                <div>
                    <label for="userSelectPHD" class="block text-sm font-medium text-gray-700 mb-1">Select User</label>
                    <select id="userSelectPHD" class="w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <option value="" disabled selected>Choose a user to assign...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end space-x-4">
                    <button onclick="closeAssignModalPHD()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md">Cancel</button>
                    <button onclick="assignUserPHD()" class="px-6 py-3 bg-blue-600 text-white rounded-md">Assign User</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openAssignModalProgramHeadDean(id) {
            currentProgramHeadDeanId = id;
            document.getElementById('assignModalPHD').classList.remove('hidden');
        }

        function closeAssignModalPHD() {
            document.getElementById('assignModalPHD').classList.add('hidden');
        }

        function assignUserPHD() {
            const userId = document.getElementById('userSelectPHD').value;
            if (userId) {
                fetch(`/admin/admin/assign-program-head-dean-id`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ id: currentProgramHeadDeanId, userId: userId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('User assigned successfully!');
                        closeAssignModalPHD();
                        location.reload();
                    } else {
                        alert('Failed to assign user.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred.');
                });
            } else {
                alert('Please select a user.');
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#userSelectPHD').select2({
                placeholder: "Choose a user to assign...",
                allowClear: true,
                width: '100%',
                zIndex: 9999
            });
        });
    </script>

    <style>
        .tab-button {
            color: #6B7280;
            border-color: transparent;
        }

        .tab-button.active {
            color: #2563EB;
            border-color: #2563EB;
        }
    </style>

    <script>
        function switchTab(tabName) {
            // Hide all content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active class from all tabs
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
            });

            // Show selected content and activate tab
            if (tabName === 'admin') {
                document.getElementById('admin-content').classList.remove('hidden');
                document.getElementById('admin-tab').classList.add('active');
            } else {
                document.getElementById('phd-content').classList.remove('hidden');
                document.getElementById('phd-tab').classList.add('active');
            }

            // Save active tab to localStorage
            localStorage.setItem('activeTab', tabName);
        }

        // Initialize tab based on localStorage or default to admin
        window.onload = function() {
            const activeTab = localStorage.getItem('activeTab') || 'admin';
            switchTab(activeTab);
        };
    </script>

    <script>
        function generateRandomAdminId() {
            // Generate a random string of 8 characters (letters and numbers)
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let randomId = '';
            for (let i = 0; i < 8; i++) {
                randomId += chars.charAt(Math.floor(Math.random() * chars.length));
            }

            // Add prefix 'ADM-' to make it more identifiable
            randomId = 'ADM-' + randomId;

            // Set the value to the input field
            document.getElementById('admin_id').value = randomId;
        }
    </script>

    <script>
        function generateRandomPHDId() {
            // Generate a random string of 8 characters (letters and numbers)
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let randomId = '';
            for (let i = 0; i < 8; i++) {
                randomId += chars.charAt(Math.floor(Math.random() * chars.length));
            }

            randomId = 'PHDN-' + randomId;

            // Set the value to the input field
            document.getElementById('identifier').value = randomId;
        }
    </script>
</x-admin-layout>
