<!-- resources/views/admin/views/admin-id-management.blade.php -->
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin ID Management') }}
        </h2>
    </x-slot>

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