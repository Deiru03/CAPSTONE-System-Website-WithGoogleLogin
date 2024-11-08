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
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">File Name</th>
                                    <th class="py-2 px-4 border-b">Requirement</th>
                                    <th class="py-2 px-4 border-b">Uploaded Date</th>
                                    <th class="py-2 px-4 border-b">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($uploadedFiles as $file)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ basename($file->file_path) }}</td>
                                        <td class="py-2 px-4 border-b">{{ $file->requirement->requirement ?? 'N/A' }}</td>
                                        <td class="py-2 px-4 border-b">{{ $file->created_at->format('Y-m-d H:i') }}</td>
                                        <td class="py-2 px-4 border-b">
                                            <button onclick="viewFile('{{ $file->file_path }}', '{{ basename($file->file_path) }}')" class="text-blue-500 hover:underline">View</button>
                                            {{-- <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="text-blue-500 hover:underline">View</a>
                                            <form action="{{ route('faculty.clearances.deleteSingleFile', [$file->shared_clearance_id, $file->requirement_id, $file->id]) }}" 
                                                method="POST" 
                                                class="inline"
                                                onsubmit="return handleDelete(event, this)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-4/5 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium" id="previewFileName"></h3>
                <button onclick="closePreviewModal()" class="text-gray-600 hover:text-gray-800">&times;</button>
            </div>
            <iframe id="previewFrame" class="w-full h-[80vh]"></iframe>
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

    </script>
    
</x-app-layout>