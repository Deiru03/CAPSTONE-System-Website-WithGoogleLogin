<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Files') }}
        </h2>
    </x-slot>

    <!-- Notification -->
    {{-- <div id="notification" class="hidden fixed bottom-4 right-4 p-3 bg-green-100 text-green-700 rounded-lg shadow-lg transition-opacity duration-300 ease-in-out z-100"></div> --}}
    <div id="notification" class="hidden fixed top-0 right-0 m-6 p-4 rounded-lg shadow-lg transition-opacity duration-300 ease-in-out z-100">
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium">Uploaded Files</h3>
                    <p class="mt-2">Here you can view all your uploaded files.</p>

                    @if($uploadedFiles->isEmpty())
                        <p class="mt-4 text-gray-500">No files uploaded yet.</p>
                    @else
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 over" style="max-height: 300; overflow-y: auto;">
                            @foreach($uploadedFiles as $file)
                                <div class="flex flex-col p-4 bg-white border rounded-lg shadow-sm hover:shadow-md hover:border-blue-500 transition duration-200 ease-in-out">
                                    <div class="flex items-center mb-2">
                                        <!-- File Icon -->
                                        <div class="mr-4 text-gray-500 flex-shrink-0">
                                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V8l-6-6H4z"/>
                                            </svg>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="font-medium text-gray-800 truncate">{{ basename($file->file_path) }}</p>
                                            <p class="text-sm text-gray-500">Uploaded: {{ $file->created_at->format('Y-m-d h:i:A') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex justify-end space-x-2">
                                        <button 
                                            onclick="viewFile('{{ $file->file_path }}', '{{ basename($file->file_path) }}')" 
                                            class="text-blue-500 hover:text-blue-700 relative group">
                                            <span class="invisible group-hover:visible absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap">
                                                Click to view file content
                                            </span>
                                            View
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-4/5 shadow-lg rounded-md bg-white" style="max-height: 80vh;">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium" id="previewFileName"></h3>
                <button onclick="closePreviewModal()" class="text-gray-600 hover:text-gray-800">&times;</button>
            </div>
            <iframe id="previewFrame" class="w-full h-[70vh]"></iframe>
        </div>
    </div>

    <script>
    function showNotification(message, type = 'success') {
        const notification = document.getElementById('notification');
        
        // Reset classes
        notification.className = 'fixed top-0 right-0 m-6 p-4 rounded-lg shadow-lg transition-opacity duration-300 ease-in-out z-100';
        
        if (type === 'success') {
            notification.classList.add('bg-green-100', 'text-green-700');
        } else if (type === 'error') {
            notification.classList.add('bg-red-100', 'text-red-700');
        }
        
        notification.textContent = message;
        notification.classList.remove('hidden');
        
        // Hide after 3 seconds
        setTimeout(() => {
            notification.classList.add('hidden');
        }, 3000);
    }

    function handleDelete(event, form) {
        event.preventDefault();

        fetch(form.action, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                // Remove the row from the table
                form.closest('tr').remove();
                if (document.querySelector('tbody').children.length === 0) {
                    location.reload(); // Reload if no files left
                }
            } else {
                showNotification(data.message || 'Failed to delete file', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred while deleting the file', 'error');
        });

        return false;
        }

        function viewFile(path, filename) {
            const previewModal = document.getElementById('previewModal');
            const previewFrame = document.getElementById('previewFrame');
            const previewFileName = document.getElementById('previewFileName');
            
            // Use the direct file viewing route
            const fileUrl = `/file-view/${path}`;
            previewFrame.src = fileUrl;
            previewFileName.textContent = filename;
            
            previewModal.classList.remove('hidden');
            previewModal.classList.add('flex');
        }

        function closePreviewModal() {
            const previewModal = document.getElementById('previewModal');
            const previewFrame = document.getElementById('previewFrame');
            
            previewModal.classList.add('hidden');
            previewModal.classList.remove('flex');
            previewFrame.src = '';
        }

    // Other JavaScript functions
    </script>
    @if($uploadedFiles->isEmpty())
        <p class="mt-4 text-gray-500">No files uploaded yet.</p>
    @else
        <div class="mt-6 overflow-y-auto" style="max-height: 400px;">
            <table class="min-w-full divide-y divide-gray-200 border-2 border-gray-200 rounded-lg">
                <thead class="bg-gray-50 sticky top-0">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">File Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Uploaded At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($uploadedFiles as $file)
                <tr class="hover:bg-blue-100 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">{{ basename($file->file_path) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $file->created_at->format('Y-m-d H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button onclick="viewFile('{{ $file->file_path }}', '{{ basename($file->file_path) }}')" class="text-blue-500 hover:text-blue-700">
                            View
                        </button>
                    {{-- <form action="{{ route('faculty.clearances.deleteSingleFile', [$file->shared_clearance_id, $file->requirement_id, $file->id]) }}" method="POST" class="inline" onsubmit="return handleDelete(event, this)">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700">
                        Delete
                        </button>
                    </form> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    @endif
</x-app-layout>