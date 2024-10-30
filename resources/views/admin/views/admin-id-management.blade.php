<!-- resources/views/admin/views/admin-id-management.blade.php -->
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin ID Management') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Admin ID Management</h1>
    
        <!-- Form to create a new Admin ID -->
        <form action="{{ route('admin.createAdminId') }}" method="POST" class="mb-6">
            @csrf
            <div class="mb-4">
                <label for="admin_id" class="block text-sm font-medium text-gray-700">New Admin ID</label>
                <div class="flex gap-2">
                    <input type="text" name="admin_id" id="admin_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <button type="button" onclick="generateRandomId()" class="mt-1 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                        Generate Random ID
                    </button>
                </div>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Create Admin ID</button>
        </form>

        <!-- List of existing Admin IDs -->
        <h2 class="text-xl font-semibold mb-2">Existing Admin IDs</h2>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 uppercase">ID</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 uppercase">Admin ID</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 uppercase">Assigned</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 uppercase">Assigned User</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($adminIds as $adminId)
                <tr>
                    <td class="px-6 py-4 border-b border-gray-300">{{ $adminId->id }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ $adminId->admin_id }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ $adminId->is_assigned ? 'Yes' : 'No' }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">{{ $adminId->users->first() ? $adminId->users->first()->name : 'N/A' }}</td>
                    <td class="px-6 py-4 border-b border-gray-300">
                        <form action="{{ route('admin.deleteAdminId', $adminId->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Admin ID?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function generateRandomId() {
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
</x-admin-layout>