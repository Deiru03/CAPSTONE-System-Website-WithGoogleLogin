 <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script src="//unpkg.com/alpinejs" defer></script>
@if(isset($userClearance) && $userClearance)
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4f46e5; /* Indigo color */
            color: white;
        }

        td {
            vertical-align: middle;
        }

        button {
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        button.upload {
            background-color: #3b82f6; /* Blue */
            color: white;
        }

        button.delete {
            background-color: #ef4444; /* Red */
            color: white;
        }

        button.view-uploads {
            background-color: #10b981; /* Green */
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        button svg {
            margin-right: 4px;
        }
    </style>
    <div class="container mx-auto px-4 py-8 bg-gray-100 rounded-lg shadow-md">
        <h2 class="text-3xl mb-6 text-black border-b-2 border-black pb-2">
            <span>Clearance Checklist:</span>
            <span class="font-bold">{{ $userClearance->sharedClearance->clearance->document_name }}</span>
        </h2>
        <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
            <p class="text-gray-700 mb-2 border-b border-gray-200 pb-2">
                <span class="font-semibold">Description:</span>
                <span class="font-bold ml-2">{{ $userClearance->sharedClearance->clearance->description }}</span>
            </p>
            <p class="text-gray-700 mb-2 border-b border-gray-200 pb-2">
                <span class="font-semibold">Units:</span>
                <span class="font-bold ml-2">{{ $userClearance->sharedClearance->clearance->units }}</span>
            </p>
            <p class="text-gray-700">
                <span class="font-semibold">Type:</span>
                <span class="font-bold ml-2">{{ $userClearance->sharedClearance->clearance->type }}</span>
            </p>
        </div>

        <h3 class="text-2xl font-semibold mt-8 mb-4 text-indigo-600">Requirements</h3>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4 shadow-sm border-l-4 border-green-500">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4 shadow-sm border-l-4 border-red-500">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-lg text-sm">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="py-2 px-3 text-left hidden">ID</th>
                        <th class="py-2 px-3 text-left">Requirement</th>
                        <th class="py-2 px-3 text-left">Status</th>
                        <th class="py-2 px-3 text-left">Feedback</th>
                        <th class="py-2 px-3 text-left text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userClearance->sharedClearance->clearance->requirements as $requirement)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="border-t px-3 py-2 hidden">{{ $requirement->id }}</td>
                        <td class="border-t px-3 py-2">{{ $requirement->requirement }}</td>
                        <td class="border-t px-3 py-2">
                            @if($userClearance->uploadedClearanceFor($requirement->id))
                                @if($userClearance->uploadedClearanceFor($requirement->id)->status == 'signed')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Signed</span>
                                @elseif($userClearance->uploadedClearanceFor($requirement->id)->status == 'return')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Return</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 justify-center">On Check</span>
                                @endif
                            @else
                            <div class="flex items-center justify-center space-x-2 text-center">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Not Uploaded</span>
                            </div>
                            @endif
                        </td>
                        <td class="border-t px-3 py-2">
                            @php
                                $feedback = $userClearance->sharedClearance->clearance->requirements
                                    ->where('id', $requirement->id)
                                    ->first()
                                    ->feedback
                                    ->where('user_id', $userClearance->user_id)
                                    ->first();
                            @endphp

                            @if($feedback)
                                <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg mb-4 shadow-sm border-l-4 border-yellow-500">
                                    <p><strong>Feedback:</strong> {{ $feedback->message }}</p>
                                </div>
                            @else
                                <p class="text-gray-500 italic">No comments yet.</p>
                            @endif
                        </td>
                        <td class="border-t px-3 py-2">
                            @if($userClearance->uploadedClearanceFor($requirement->id))
                                <div class="flex justify-center space-x-1">
                                    <div class="flex space-x-1">
                                        <button 
                                            onclick="openUploadModal({{ $userClearance->shared_clearance_id }}, {{ $requirement->id }})" 
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-1 py-0 rounded-full transition-colors duration-200 text-xs font-semibold flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                            </svg>
                                            <span>Upload</span>
                                        </button>
                                        <button 
                                            onclick="deleteFile({{ $userClearance->shared_clearance_id }}, {{ $requirement->id }})" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-1 py-0 rounded-full transition-colors duration-200 text-xs font-semibold flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 016.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span>Delete</span>
                                        </button>
                                    </div>
                                    <div class="flex justify-center space-x-1">
                                        <button style="width: 108px;"
                                            onclick="viewFilesModal({{ $userClearance->shared_clearance_id }}, {{ $requirement->id }})" 
                                            class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded-full transition-colors duration-200 text-xs font-semibold flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span>View Uploads</span>
                                        </button>
                                    </div>
                            @else
                                <div class="flex justify-center">
                                    <button 
                                        onclick="openUploadModal({{ $userClearance->shared_clearance_id }}, {{ $requirement->id }})" 
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full transition-colors duration-200 text-xs font-semibold">
                                        Upload
                                    </button>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Upload Modal -->
    <div id="uploadModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full relative">
            <h3 class="text-2xl font-semibold mb-4">{{ $userClearance->uploadedClearanceFor($requirement->id) ? 'Replace Files' : 'Upload Files' }} for Requirement ID: <span id="uploadRequirementId"></span></h3>
            <form id="uploadForm" class="space-y-4">
                @csrf
                <input type="hidden" id="uploadUserClearanceId" name="userClearanceId">
                <input type="hidden" id="uploadRequirementIdInput" name="requirementId">
                <div>
                    <label for="uploadFiles" class="block text-sm font-medium text-gray-700">Select Files</label>
                    <div id="dropArea" class="mt-1 block w-full border-2 border-dashed border-gray-300 rounded-md p-6 text-center">
                        <p class="text-gray-500">Drag & drop files here or click to select files</p>
                        <input type="file" id="uploadFiles" name="files[]" multiple class="hidden">
                    </div>
                    <p class="mt-1 text-sm text-gray-500">You can upload multiple files. Allowed types: PDF, DOC, DOCX, JPG, PNG. Max size per file: 100mb.</p>
                </div>
                <div id="uploadNotification" class="hidden bg-green-100 text-green-700 p-2 rounded"></div>
                <div id="uploadLoader" class="hidden">Uploading...</div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeUploadModal()" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Files Modal -->
    <div id="viewFilesModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden z-50">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl w-full relative">
            <h3 class="text-2xl font-semibold mb-6 text-gray-800 border-b pb-2">Uploaded Files for Requirement: <span id="modalRequirementId" class="text-blue-600"></span></h3>
            {{--}} <h3 class="text-2xl font-semibold mb-6 text-gray-800 border-b pb-2">Requirement Name: <span id="requirementName" class="text-blue-600"></span></h3> --}}
            <div class="max-h-96 overflow-y-auto">
                <div id="uploadedFilesGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <!-- Uploaded files will be dynamically inserted here -->
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button onclick="closeViewFilesModal()" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                    Close
                </button>
            </div>
        </div>
    </div>
@else
    <div class="container mx-auto px-8 py-12">
        <div class="text-center">
            <i class="fas fa-file-alt text-6xl text-indigo-500 mb-6"></i>
            <h2 class="text-4xl font-bold mb-4 text-indigo-800">
                No Clearances Available
            </h2>
            <p class="text-xl text-gray-700 mb-8">
                It looks like you haven't obtained a copy of your clearance yet.
            </p>
            <a href="{{ route('faculty.clearances.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-full transition duration-300 ease-in-out transform hover:scale-105">
                Get Your Clearance
            </a>
        </div>
    </div>
@endif

    <script>
        /**
         * Function to open the Upload modal.
         *
         * @param {number} sharedClearanceId
         * @param {number} requirementId
         */
        function openUploadModal(sharedClearanceId, requirementId) {
            document.getElementById('uploadModal').classList.remove('hidden');
            document.getElementById('uploadUserClearanceId').value = sharedClearanceId;
            document.getElementById('uploadRequirementId').innerText = requirementId;
            document.getElementById('uploadRequirementIdInput').value = requirementId;
        }

        // Function to close the upload modal
        function closeUploadModal() {
            document.getElementById('uploadModal').classList.add('hidden');
            document.getElementById('uploadForm').reset();
            document.getElementById('uploadNotification').classList.add('hidden');
            document.getElementById('uploadLoader').classList.add('hidden');
        }

        // Handle Upload Form Submission
        document.getElementById('uploadForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const sharedClearanceId = document.getElementById('uploadUserClearanceId').value;
            const requirementId = document.getElementById('uploadRequirementIdInput').value;
            const fileInput = document.getElementById('uploadFiles');
            const uploadNotification = document.getElementById('uploadNotification');
            const uploadLoader = document.getElementById('uploadLoader');

            if (fileInput.files.length === 0) {
                alert('Please select at least one file to upload.');
                return;
            }

            const formData = new FormData();
            for (let i = 0; i < fileInput.files.length; i++) {
                formData.append('files[]', fileInput.files[i]);
            }

            uploadLoader.classList.remove('hidden');
            uploadNotification.classList.add('hidden');

            fetch(`/faculty/clearances/${sharedClearanceId}/upload/${requirementId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                uploadLoader.classList.add('hidden');

                if (data.success) {
                    uploadNotification.classList.remove('hidden');
                    uploadNotification.innerText = data.message;
                    setTimeout(() => {
                        closeUploadModal();
                        location.reload();
                    }, 1500);
                } else {
                    if (data.errors) {
                        alert(JSON.stringify(data.errors));
                    } else {
                        alert(data.message || 'Failed to upload files.');
                    }
                }
            })
            .catch(error => {
                uploadLoader.classList.add('hidden');
                console.error('Error uploading files:', error);
                alert('An error occurred while uploading the files.');
            });
        });

        /**
         * Function to handle file deletion.
         *
         * @param {number} sharedClearanceId
         * @param {number} requirementId
         */
        function deleteFile(sharedClearanceId, requirementId) {
            if (!confirm('Are you sure you want to delete this file?')) {
                return;
            }

            fetch(`/faculty/clearances/${sharedClearanceId}/upload/${requirementId}/delete`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    // Reload the page to reflect changes
                    location.reload();
                } else {
                    alert(data.message || 'Failed to delete the file.');
                }
            })
            .catch(error => {
                console.error('Error deleting file:', error);
                alert('An error occurred while deleting the file.');
            });
        }

        // Function to open the view files modal
        /**
         * Function to open the View Files modal and fetch uploaded files.
         *
         * @param {number} sharedClearanceId
         * @param {number} requirementId
         */
        function viewFilesModal(sharedClearanceId, requirementId) {
            // Set the requirement ID in the modal
            document.getElementById('modalRequirementId').innerText = requirementId;

            // Clear the current list
            const uploadedFilesGrid = document.getElementById('uploadedFilesGrid');
            uploadedFilesGrid.innerHTML = '';

            // Fetch uploaded files
            fetch(`/faculty/clearances/${sharedClearanceId}/requirement/${requirementId}/files`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    data.files.forEach(file => {
                        const fileCard = document.createElement('div');
                        fileCard.classList.add('bg-gray-100', 'p-4', 'rounded-lg', 'shadow-md', 'flex', 'flex-col', 'items-center', 'justify-between');

                        const fileIcon = document.createElement('i');
                        fileIcon.classList.add('fas', 'fa-file', 'fa-3x', 'mb-2');

                        // Determine the file type and set the appropriate icon
                        const fileType = file.name.split('.').pop().toLowerCase();
                        switch (fileType) {
                            case 'pdf':
                                fileIcon.classList.add('fa-file-pdf', 'text-red-500');
                                break;
                            case 'doc':
                            case 'docx':
                                fileIcon.classList.add('fa-file-word', 'text-blue-500');
                                break;
                            case 'jpg':
                            case 'jpeg':
                            case 'png':
                                fileIcon.classList.add('fa-file-image', 'text-yellow-500');
                                break;
                            default:
                                fileIcon.classList.add('fa-file-alt', 'text-gray-500');
                        }

                        const fileLink = document.createElement('a');
                        fileLink.href = file.url;
                        fileLink.target = '_blank';
                        fileLink.classList.add('text-blue-500', 'underline', 'truncate', 'w-full', 'text-center');
                        fileLink.innerText = file.name;

                        const deleteButton = document.createElement('button');
                        deleteButton.classList.add('bg-red-500', 'text-white', 'px-2', 'py-1', 'rounded', 'mt-2');
                        deleteButton.innerText = 'Delete';
                        deleteButton.onclick = function() {
                            deleteSingleFile(sharedClearanceId, requirementId, file.id);
                        };

                        fileCard.appendChild(fileIcon);
                        fileCard.appendChild(fileLink);
                        fileCard.appendChild(deleteButton);
                        uploadedFilesGrid.appendChild(fileCard);
                    });

                    // Show the modal
                    document.getElementById('viewFilesModal').classList.remove('hidden');
                } else {
                    alert(data.message || 'Failed to fetch uploaded files.');
                }
            })
            .catch(error => {
                console.error('Error fetching uploaded files:', error);
                alert('An error occurred while fetching the uploaded files.');
            });
        }

        /**
         * Function to close the View Files modal.
         */
        function closeViewFilesModal() {
            document.getElementById('viewFilesModal').classList.add('hidden');
        }

        /**
         * Function to delete a single uploaded file from the modal.
         *
         * @param {number} sharedClearanceId
         * @param {number} requirementId
         * @param {number} fileId
         */
        function deleteSingleFile(sharedClearanceId, requirementId, fileId) {
            if (!confirm('Are you sure you want to delete this file?')) {
                return;
            }

            fetch(`/faculty/clearances/${sharedClearanceId}/upload/${requirementId}/delete/${fileId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    // Refresh the file list in the modal
                    viewFilesModal(sharedClearanceId, requirementId);
                } else {
                    alert(data.message || 'Failed to delete the file.');
                }
            })
            .catch(error => {
                console.error('Error deleting file:', error);
                alert('An error occurred while deleting the file.');
            });
        }

        // Drag and Drop functionality
        const dropArea = document.getElementById('dropArea');
        const fileInput = document.getElementById('uploadFiles');

        dropArea.addEventListener('click', () => fileInput.click());

        dropArea.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropArea.classList.add('border-blue-500');
        });

        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('border-blue-500');
        });

        dropArea.addEventListener('drop', (event) => {
            event.preventDefault();
            dropArea.classList.remove('border-blue-500');
            const files = event.dataTransfer.files;
            fileInput.files = files;
            // Manually trigger change event to update file input
            const changeEvent = new Event('change');
            fileInput.dispatchEvent(changeEvent);
        });

        // Handle file input change event
        fileInput.addEventListener('change', () => {
            const files = fileInput.files;
            if (files.length > 0) {
                dropArea.querySelector('p').innerText = `${files.length} file(s) selected`;
            } else {
                dropArea.querySelector('p').innerText = 'Drag & drop files here or click to select files';
            }
        });
    </script>
    <script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
