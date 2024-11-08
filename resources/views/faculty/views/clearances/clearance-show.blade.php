 <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Upload Notification -->
    <div id="uploadNotification" class="hidden backdrop-blur-sm fixed top-0 right-0 m-6 p-4 rounded-lg shadow-lg transition-all duration-500 transform translate-x-full z-50">
        <div id="notificationIcon" class="inline-block mr-2"></div>
        <span id="notificationMessage"></span>
    </div>

    <!-- Upload Tracker -->
    <div id="uploadTracker" class="fixed bottom-20 right-4 w-80 bg-white/70 backdrop-blur-sm shadow-2xl rounded-xl p-6 z-20 hidden transform transition-all duration-300 ease-in-out hover:shadow-lg border-2 border-blue-500 hover:border-blue-700 pointer-events-none">
        <div class="flex items-center justify-between mb-4">
            <h4 class="text-lg font-bold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                </svg>
                Upload Progress
            </h4>
            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">In Progress</span>
        </div>
        <div class="text-sm text-amber-600 bg-amber-50 p-2 rounded-lg mb-3">
            ⚠️ Please don't refresh or navigate away while uploading large files (>50MB). This may interrupt your upload.
        </div>
        <div id="uploadList" class="space-y-4 max-h-64 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100"></div>
    </div>

    <button id="returnToTop" class="hidden fixed bottom-4 right-4 bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-full transition-all duration-300 ease-in-out transform hover:scale-110 hover:-translate-y-1 shadow-lg hover:shadow-xl text-sm font-bold flex items-center space-x-2 animate-bounce">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
        <span>Back to Top</span>
    </button>


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
      
        .folder-content {
            transition: max-height 0.5s ease;
            overflow: hidden;
        }

        .folder-content.hidden {
            max-height: 0;
        }

        .folder-content:not(.hidden) {
            max-height: 1000px; /* A sufficiently large value to accommodate the content */
}
    </style>

    <!-- Notification -->
    <div id="notification" class="hidden fixed bottom-4 right-4 p-3 bg-green-100 text-green-700 rounded-lg shadow-lg transition-opacity duration-300 ease-in-out z-50"></div>

    <!-- Clearance Details -->
    <div class="container mx-auto px-4 py-8 bg-gray-100 rounded-lg shadow-md">
        <h2 class="text-3xl mb-6 text-black border-b-2 border-black pb-2">
            <span>Clearance Checklist:</span>
            <span class="font-bold">{{ $userClearance->sharedClearance->clearance->document_name }}</span>
        </h2>
        <div class="grid grid-cols-2 gap-6">
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
            <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                <p class="text-gray-700 mb-2 border-b border-gray-200 pb-2">
                    <span class="font-semibold">Name:</span>
                    <span class="font-bold ml-2">{{ Auth::user()->name }}</span>
                </p>
                <p class="text-gray-700 mb-2 border-b border-gray-200 pb-2">
                    <span class="font-semibold">Email:</span>
                    <span class="font-bold ml-2">{{ Auth::user()->email }}</span>
                </p>
                <p class="text-gray-700 mb-2 border-b border-gray-200 pb-2">
                    <span class="font-semibold">Position:</span>
                    <span class="font-bold ml-2">{{ Auth::user()->position }}</span>
                </p>
                <p class="text-gray-700 mb-2 border-b border-gray-200 pb-2">
                    <span class="font-semibold">Units:</span>
                    <span class="font-bold ml-2">{{ Auth::user()->units == 0 ? 'N/A' : Auth::user()->units }}</span>
                </p>
                <p class="text-gray-700">
                    <span class="font-semibold">Clearance Status:</span>
                    <span class="font-bold ml-2 {{ Auth::user()->clearances_status == 'complete' ? 'text-green-600' : 'text-yellow-600' }}">
                        {{ Auth::user()->clearances_status == 'complete' ? 'Checklist Complete' : (Auth::user()->clearances_status ?? 'Pending') }}
                    </span>
                </p>
            </div>
            <div class="col-span-2 text-center text-gray-600 italic -mt-8 flex items-center justify-center gap-2">
                <span>Scroll down to see more requirements and details</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 animate-bounce">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                </svg>
            </div>
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

        <div id="missingTracker" class="mb-6 bg-transparent p-4">
            <div class="flex flex-col gap-4">
                <div class="flex items-center">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span id="missingCount" class="text-sm font-medium text-gray-600"></span>
                        <button id="findMissing" class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition-colors duration-200 text-sm font-medium ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Find Missing Docs
                        </button>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span id="returnCount" class="text-sm font-medium text-gray-600"></span>
                        <button id="findReturn" class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition-colors duration-200 text-sm font-medium ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z" />
                            </svg>
                            Find Resubmit Docs
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                <!-- Dynamic Categories -->
                @php
                    $requirements = $userClearance->sharedClearance->clearance->requirements->where('is_archived', false);
                    
                    // Group requirements by status
                    $categorizedRequirements = [
                        'Missing' => [],
                        'Uploaded' => [],
                        'Resubmit' => []
                    ];

                    foreach($requirements as $requirement) {
                        $uploadedFiles = App\Models\UploadedClearance::where('shared_clearance_id', $userClearance->shared_clearance_id)
                            ->where('requirement_id', $requirement->id)
                            ->where('user_id', $userClearance->user_id)
                            ->get();
                    
                        $hasNonArchivedUpload = $uploadedFiles->where('is_archived', false)->count() > 0;
                        
                        $feedback = $requirement->feedback
                            ->where('user_id', $userClearance->user_id)
                            ->where('is_archived', false)
                            ->first();

                        if ($feedback && $feedback->signature_status == 'Resubmit') {
                            $categorizedRequirements['Resubmit'][] = $requirement;
                        } elseif ($hasNonArchivedUpload) {
                            $categorizedRequirements['Uploaded'][] = $requirement;
                        } else {
                            $categorizedRequirements['Missing'][] = $requirement;
                        }
                    }
                @endphp

                @foreach($categorizedRequirements as $category => $requirements)
                    @if(count($requirements) > 0)
                        <div class="folder-container mb-4">
                            <!-- Folder Header -->
                            <div class="folder-header p-3 cursor-pointer flex items-center justify-between transition-colors duration-200 
                                {{ $category === 'Missing' ? 'bg-yellow-100 hover:bg-yellow-200' : '' }}
                                {{ $category === 'Uploaded' ? 'bg-green-100 hover:bg-green-200' : '' }}
                                {{ $category === 'Resubmit' ? 'bg-red-100 hover:bg-red-200' : '' }}"
                                onclick="toggleFolder(this)">
                                <div class="flex items-center">
                                    <svg class="folder-icon h-5 w-5 mr-2 transform transition-transform duration-200
                                        {{ $category === 'Missing' ? 'text-yellow-600' : '' }}
                                        {{ $category === 'Uploaded' ? 'text-green-600' : '' }}
                                        {{ $category === 'Resubmit' ? 'text-red-600' : '' }}" 
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                    <h3 class="text-lg font-semibold 
                                        {{ $category === 'Missing' ? 'text-yellow-700' : '' }}
                                        {{ $category === 'Uploaded' ? 'text-green-700' : '' }}
                                        {{ $category === 'Resubmit' ? 'text-red-700' : '' }}">
                                        {{ $category }} ({{ count($requirements) }})
                                    </h3>
                                </div>
                            </div>

                            <!-- Folder Content -->
                            <div class="folder-content hidden">
                                <table class="min-w-full">
                                    <thead class="bg-indigo-600 text-white">
                                        <tr>
                                            <th class="py-2 px-3 text-left">ID</th>
                                            <th class="py-2 px-3 text-left">Requirement</th>
                                            <th class="py-2 px-3 text-center">Document<br>Status</th>
                                            <th class="py-2 px-3 text-left">Feedback</th>
                                            <th class="py-2 px-3 text-left text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($requirements as $requirement)
                                            @php
                                                $uploadedFiles = App\Models\UploadedClearance::where('shared_clearance_id', $userClearance->shared_clearance_id)
                                                    ->where('requirement_id', $requirement->id)
                                                    ->where('user_id', $userClearance->user_id)
                                                    ->get();
                            
                                                $hasNonArchivedUpload = $uploadedFiles->where('is_archived', false)->count() > 0;
                                                
                                                $feedback = $requirement->feedback
                                                    ->where('user_id', $userClearance->user_id)
                                                    ->where('is_archived', false)
                                                    ->first();

                                                $checkStatus = 'No Upload';
                                                if ($hasNonArchivedUpload) {
                                                    $checkStatus = 'Uploaded';
                                                    if ($feedback) {
                                                        if ($feedback->signature_status == 'Complied') {
                                                            $checkStatus = 'Complied';
                                                        } elseif ($feedback->signature_status == 'Resubmit') {
                                                            $checkStatus = 'Resubmit';
                                                        } else {
                                                            $checkStatus = 'On Check';
                                                        }
                                                    }
                                                }
                                            @endphp

                                            <tr class="requirement-row hover:bg-gray-50 transition-colors duration-200" data-uploaded="{{ $hasNonArchivedUpload ? 'true' : 'false' }}">
                                                <td class="border-t px-3 py-2 text-gray-400">{{ $requirement->id }}</td>
                                                <td class="border-t px-3 py-2">{!! nl2br(e($requirement->requirement)) !!}</td>
                                                <td class="border-t px-3 py-2 text-center">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                        {{ $checkStatus === 'Complied' ? 'bg-green-100 text-green-900' : '' }}
                                                        {{ $checkStatus === 'Resubmit' ? 'bg-red-100 text-red-900' : '' }}
                                                        {{ $checkStatus === 'On Check' ? 'bg-yellow-100 text-yellow-900' : '' }}
                                                        {{ $checkStatus === 'Uploaded' ? 'bg-blue-100 text-blue-900' : '' }}
                                                        {{ $checkStatus === 'No Upload' ? 'bg-gray-100 text-gray-800' : '' }}">
                                                        {{ $checkStatus }}
                                                    </span>
                                                </td>
                                                <td class="border-t px-3 py-2">
                                                    @if($feedback && !empty($feedback->message))
                                                        <p class="text-yellow-800"><strong>{{ $feedback->message }}</strong></p>
                                                    @else
                                                        <p class="text-gray-400 italic">No comments yet.</p>
                                                    @endif
                                                </td>
                                                <td class="border-t px-2 py-1">
                                                    @if($hasNonArchivedUpload)
                                                        <div class="flex justify-center">
                                                            <div class="flex justify-center">
                                                                <button 
                                                                    onclick="openUploadModal({{ $userClearance->shared_clearance_id }}, {{ $requirement->id }})" 
                                                                    class="bg-blue-500 hover:bg-blue-700 text-white px-1 py-0 rounded-full transition-colors duration-200 text-xs font-semibold flex items-center">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                                    </svg>
                                                                    Upload
                                                                </button>
                                                            </div>
                                                            <button 
                                                                onclick="openDeleteConfirmationModal({{ $userClearance->shared_clearance_id }}, {{ $requirement->id }})" 
                                                                class="bg-red-500 hover:bg-red-800 text-white px-1 py-0 rounded-full transition-colors duration-200 text-xs font-semibold flex items-center ml-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 016.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                                <span>Delete</span>
                                                            </button>
                                                        </div>
                                                        <div class="p-1 flex justify-center space-x-1">
                                                            <button style="width: 108px;"
                                                                onclick="viewFilesModal({{ $userClearance->shared_clearance_id }}, {{ $requirement->id }})" 
                                                                class="bg-green-500 hover:bg-green-800 text-white px-1 py-0 rounded-full transition-colors duration-200 text-xs font-semibold flex items-center">
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
                                                                class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded-full transition-colors duration-200 text-xs font-semibold">
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
                    @endif
                @endforeach
            </div>
        </div>

        <script>
            function toggleFolder(header) {
                const content = header.nextElementSibling;
                const icon = header.querySelector('.folder-icon');
                
                content.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            }
        </script>
    </div>

    <!-- Upload Modal -->
    <div id="uploadModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-35 hidden z-10 transition-opacity duration-300">
        <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
            <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                {{ $userClearance->uploadedClearanceFor($requirement->id) ? 'Replace Files' : 'Upload Files' }}
            </h3>
            <form id="uploadForm" class="space-y-6">
                @csrf
                <input type="hidden" id="uploadUserClearanceId" name="userClearanceId">
                <input type="hidden" id="uploadRequirementIdInput" name="requirementId">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Requirement Details</label>
                    <div class="flex flex-col space-y-1">
                        <p class="text-sm text-gray-600">ID: <span id="uploadRequirementId" class="font-medium text-gray-900"></span></p>
                        <p class="text-sm text-gray-600">Name: <strong><span id="uploadRequirementName" class="font-medium text-blue-900"></span></strong></p>
                    </div>
                </div>
                <!-- Warning Message -->
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                <strong class="font-medium">Important Warning:</strong> When uploading large files, please wait for the current upload to complete before uploading files for other requirements. Uploading multiple files simultaneously may cause interruptions and failures.
                            </p>
                        </div>
                    </div>
                </div>
                <div>
                    <label for="uploadFiles" class="block text-sm font-medium text-gray-700 mb-2">Select Files</label>
                    <div id="dropArea" class="mt-1 block w-full border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition-colors duration-300">
                        <p class="text-gray-500">Drag & drop files here or click to select files</p>
                        <input type="file" id="uploadFiles" name="files[]" multiple class="hidden" accept="application/pdf">
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Allowed type: PDF only. Max size per file: 1gb.</p>
                </div>
                <div id="uploadLoader" class="hidden flex items-center justify-center">
                    <div class="loader border-t-4 border-blue-500 border-solid rounded-full animate-spin h-8 w-8"></div>
                    <span class="ml-2">Uploading...</span>
                </div>
                <div id="uploadProgressContainer" class="hidden mt-4">
                    <div class="w-full bg-gray-200 rounded-full">
                        <div id="uploadProgressBar" class="bg-blue-500 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" style="width: 0%">0%</div>
                    </div>
                </div>
                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" onclick="closeUploadModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md flex items-center transition duration-300 ease-in-out hover:bg-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Close
                    </button>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md flex items-center transition duration-300 ease-in-out hover:bg-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Files Modal -->
    <div id="viewFilesModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-35 hidden z-10 transition-opacity duration-300">
        <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-4xl w-full relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-green-500 to-teal-500"></div>
            <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                View Uploaded Files
            </h3>
            <div class="mb-4 border-b pb-4">
                <p class="text-gray-600">Requirement ID: <strong><span id="modalRequirementId" class="font-medium text-gray-900"></span></strong></p>
                <p class="text-gray-600">Requirement Name: <strong><span id="modalRequirementName" class="font-medium text-blue-900"></span></strong></p>
            </div>
            <div class="max-h-96 overflow-y-auto">
                <div id="uploadedFilesGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <!-- Uploaded files will be dynamically inserted here -->
                </div>
            </div>
            <div class="mt-8 flex justify-end">
                <button onclick="closeViewFilesModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md flex items-center transition duration-300 ease-in-out hover:bg-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="fixed inset-0 bg-black bg-opacity-35 hidden items-center justify-center z-40">
        <div class="bg-white rounded-lg w-11/12 h-5/6 max-w-4xl flex flex-col">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 id="previewFileName" class="text-lg font-semibold text-gray-800"></h3>
                <button onclick="closePreviewModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="flex-1 p-4 overflow-auto">
                <iframe id="previewFrame" class="w-full h-full border-0" src=""></iframe>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmationModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-35 hidden z-30 transition-opacity duration-300">
        <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-500 to-pink-500"></div>
            <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Confirm Deletion
            </h3>
            <p class="text-lg text-gray-600 mb-8">Are you sure you want to delete this file? This action cannot be undone.</p>
            <div class="flex justify-end space-x-4">
                <button onclick="closeDeleteConfirmationModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md flex items-center transition duration-300 ease-in-out hover:bg-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Cancel
                </button>
                <button id="confirmDeleteButton" class="px-6 py-3 bg-red-600 text-white rounded-md flex items-center transition duration-300 ease-in-out hover:bg-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete
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

    <!-- Single File Delete Modal -->
    <div id="singleFileDeleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-35 hidden z-30 transition-opacity duration-300">
        <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-500 to-pink-500"></div>
            <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Confirm Deletion
            </h3>
            <p class="text-lg text-gray-600 mb-8">Are you sure you want to delete this file? This action cannot be undone.</p>
            <div class="flex justify-end space-x-4">
                <button onclick="closeSingleFileDeleteModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md flex items-center transition duration-300 ease-in-out hover:bg-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Cancel
                </button>
                <button id="confirmSingleFileDeleteButton" class="px-6 py-3 bg-red-600 text-white rounded-md flex items-center transition duration-300 ease-in-out hover:bg-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete
                </button>
            </div>
        </div>
    </div>

    <script>
        // Find Missing Requirements
        document.addEventListener('DOMContentLoaded', function() {
            const requirements = document.querySelectorAll('.requirement-row');
            const missingCountElement = document.getElementById('missingCount');
            const returnCountElement = document.getElementById('returnCount');
            const findMissingButton = document.getElementById('findMissing');
            const findReturnButton = document.getElementById('findReturn');
            const returnToTopButton = document.getElementById('returnToTop');

            let missingCount = 0;
            let returnCount = 0;

            requirements.forEach(row => {
                const isUploaded = row.dataset.uploaded === 'true';
                const statusSpan = row.querySelector('span');

                if (!isUploaded) {
                    missingCount++;
                }

                if (statusSpan && statusSpan.textContent.trim() === 'Resubmit') {
                    returnCount++;
                }
            });

            console.log(requirements);
            console.log(`Missing: ${missingCount}, Resubmit: ${returnCount}`);
            
            missingCountElement.textContent = `Missing Requirements to Upload: ${missingCount} out of ${requirements.length}`;
            returnCountElement.textContent = `Resubmit Documents: ${returnCount} out of ${requirements.length}`;

            // Function to toggle folders
            function toggleFolder(header) {
                const content = header.nextElementSibling;
                const icon = header.querySelector('.folder-icon');
                
                // Toggle the clicked folder
                content.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            }

            // Function to open a specific category and close others
            function openCategory(categoryName) {
                const allHeaders = document.querySelectorAll('.folder-header');
                allHeaders.forEach(header => {
                    const headerText = header.querySelector('h3').textContent.trim().split(' ')[0]; // Get category name
                    const content = header.nextElementSibling;
                    const icon = header.querySelector('.folder-icon');

                    if (headerText === categoryName) {
                        if (content.classList.contains('hidden')) {
                            content.classList.remove('hidden');
                            icon.classList.add('rotate-180');
                        }
                    } else {
                        if (!content.classList.contains('hidden')) {
                            content.classList.add('hidden');
                            icon.classList.remove('rotate-180');
                        }
                    }
                });
            }

            // Event listener for Find Missing Docs
            findMissingButton.addEventListener('click', function() {
                openCategory('Missing');
                // Allow some time for the category to open before scrolling
                setTimeout(() => {
                    let found = false;
                    requirements.forEach(row => {
                        const isUploaded = row.dataset.uploaded === 'true';
                        if (!isUploaded) {
                            row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            found = true;
                            return false; // Exit the loop
                        }
                    });
                    if (!found) {
                        showNotification('No missing documents found.', 'info');
                    }
                }, 300);
            });

            // Event listener for Find Return Docs
            findReturnButton.addEventListener('click', function() {
                openCategory('Resubmit');
                // Allow some time for the category to open before scrolling
                setTimeout(() => {
                    let found = false;
                    requirements.forEach(row => {
                        const statusSpan = row.querySelector('span');
                        if (statusSpan && statusSpan.textContent.trim() === 'Resubmit') {
                            row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            found = true;
                            return false; // Exit the loop
                        }
                    });
                    if (!found) {
                        showNotification('No resubmit documents found.', 'info');
                    }
                }, 300);
            });

            window.addEventListener('scroll', function() {
                if (window.scrollY > 200) {
                    returnToTopButton.classList.remove('hidden');
                } else {
                    returnToTopButton.classList.add('hidden');
                }
            });

            returnToTopButton.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });

        /**
         * Function to toggle folder open/close
         */
        function toggleFolder(header) {
            const content = header.nextElementSibling;
            const icon = header.querySelector('.folder-icon');
            
            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }

        /**
         * Function to open the delete confirmation modal.
         *
         * @param {number} sharedClearanceId
         * @param {number} requirementId
         */
        function openDeleteConfirmationModal(sharedClearanceId, requirementId) {
            const modal = document.getElementById('deleteConfirmationModal');
            const confirmButton = document.getElementById('confirmDeleteButton');
            
            modal.classList.remove('hidden');
            confirmButton.onclick = function() {
                deleteFile(sharedClearanceId, requirementId);
            };
        }

        /**
         * Function to close the delete confirmation modal.
         */
        function closeDeleteConfirmationModal() {
            document.getElementById('deleteConfirmationModal').classList.add('hidden');
        }

        /**
         * Function to handle file deletion.
         *
         * @param {number} sharedClearanceId
         * @param {number} requirementId
         */
        function deleteFile(sharedClearanceId, requirementId) {
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
                    showNotification(data.message, 'success');
                    // Reload the page to reflect changes
                    location.reload();
                } else {
                    showNotification(data.message || 'Failed to delete the file.', 'error');
                }
            })
            .catch(error => {
                console.error('Error deleting file:', error);
                showNotification('An error occurred while deleting the file.', 'error');
            });
            closeDeleteConfirmationModal();
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
            const requirements = @json($userClearance->sharedClearance->clearance->requirements->pluck('requirement', 'id'));
            
            document.getElementById('viewFilesModal').classList.remove('hidden');
            document.getElementById('modalRequirementId').innerText = requirementId;
            document.getElementById('modalRequirementName').innerText = requirements[requirementId];
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
                        fileCard.onclick = () => viewFile(file.url, file.name);

                        // File Icon
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

                        const fileLink = document.createElement('button');
                        fileLink.classList.add('text-blue-500', 'underline', 'truncate', 'w-full', 'text-center', 'mb-2');
                        fileLink.innerText = file.name;
                        fileLink.onclick = () => viewFile(file.url, file.name);

                        const deleteButton = document.createElement('button');
                        deleteButton.classList.add('bg-red-500', 'text-white', 'px-2', 'py-1', 'rounded', 'mt-2');
                        deleteButton.innerText = 'Delete';
                        deleteButton.onclick = function() {
                            event.stopPropagation();
                            openSingleFileDeleteModal(sharedClearanceId, requirementId, file.id);
                        };

                        fileCard.appendChild(fileIcon);
                        fileCard.appendChild(fileLink);
                        fileCard.appendChild(deleteButton);
                        uploadedFilesGrid.appendChild(fileCard);
                    });

                    // Show the modal
                    document.getElementById('viewFilesModal').classList.remove('hidden');
                } else {
                    showNotification(data.message || 'Failed to fetch uploaded files.', 'error');
                }
            })
            .catch(error => {
                console.error('Error fetching uploaded files:', error);
                showNotification('An error occurred while fetching the uploaded files.', 'error');
            });
        }

        /**
         * Function to close the View Files modal.
         */
        function closeViewFilesModal() {
            document.getElementById('viewFilesModal').classList.add('hidden');
        }

        function viewFile(url, filename) {
            const previewModal = document.getElementById('previewModal');
            const previewFrame = document.getElementById('previewFrame');
            const previewFileName = document.getElementById('previewFileName');
            
            // Remove comments if hosted na ang project
            // const fileUrl = `/file-view/${url}`;
            // previewFrame.src = fileUrl;
            previewFrame.src = url;
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

        /**
         * Function to delete a single uploaded file from the modal.
         *
         * @param {number} sharedClearanceId
         * @param {number} requirementId
         * @param {number} fileId
         */
        let currentFileId;
        let currentSharedClearanceId;
        let currentRequirementId;

        function openSingleFileDeleteModal(sharedClearanceId, requirementId, fileId) {
            currentFileId = fileId;
            currentSharedClearanceId = sharedClearanceId;
            currentRequirementId = requirementId;
            document.getElementById('singleFileDeleteModal').classList.remove('hidden');
        }

        function closeSingleFileDeleteModal() {
            document.getElementById('singleFileDeleteModal').classList.add('hidden');
        }

        document.getElementById('confirmSingleFileDeleteButton').onclick = function() {
            deleteSingleFile(currentSharedClearanceId, currentRequirementId, currentFileId);
            closeSingleFileDeleteModal();
        };

        function deleteSingleFile(sharedClearanceId, requirementId, fileId) {
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
                    showNotification(data.message, 'success');
                    // Refresh the file list in the modal
                    viewFilesModal(sharedClearanceId, requirementId);
                } else {
                    showNotification(data.message || 'Failed to delete the file.', 'error');
                }
            })
            .catch(error => {
                console.error('Error deleting file:', error);
                showNotification('An error occurred while deleting the file.', 'error');
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

        function confirmDelete(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform the delete action
                    axios.delete(url)
                        .then(response => {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            // Optionally, refresh the page or update the UI
                        })
                        .catch(error => {
                            Swal.fire(
                                'Error!',
                                'There was a problem deleting the file.',
                                'error'
                            );
                        });
                }
            });
        }
    </script>

<script>
    function showNotification(message, type = 'success') {
        const notification = document.getElementById('uploadNotification');
        const notificationMessage = document.getElementById('notificationMessage');
        const notificationIcon = document.getElementById('notificationIcon');

        notificationMessage.textContent = message;

        // Reset classes
        notification.className = 'hidden fixed top-0 right-0 m-6 p-4 rounded-lg shadow-lg transition-all duration-500 transform translate-x-full z-50';
        notificationIcon.innerHTML = '';

        if (type === 'success') {
            notification.classList.add('bg-green-100/90', 'border-l-4', 'border-green-500', 'text-green-700');
            notificationIcon.innerHTML = '<svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
        } else if (type === 'error') {
            notification.classList.add('bg-red-100/90', 'border-l-4', 'border-red-500', 'text-red-700');
            notificationIcon.innerHTML = '<svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
        } else if (type === 'successDelete') {
            notification.classList.add('bg-yellow-100/90', 'border-l-4', 'border-yellow-500', 'text-yellow-700', 'z-50');
            notificationIcon.innerHTML = '<svg class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-7 7-3-3"></path></svg>';
        } else if (type === 'info') {
            notification.classList.add('bg-blue-100/80', 'border-l-4', 'border-blue-500', 'text-blue-700');
            notificationIcon.innerHTML = '<svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
        }

        notification.classList.remove('hidden', 'translate-x-full');
        notification.classList.add('translate-x-0');

        setTimeout(() => {
            notification.classList.remove('translate-x-0');
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                notification.classList.add('hidden');
                notification.classList.remove('bg-green-100', 'border-l-4', 'border-green-500', 'text-green-700', 'bg-red-100', 'border-red-500', 'text-red-700', 'bg-yellow-100', 'border-yellow-500', 'text-yellow-700');
            }, 500);
        }, 3000);
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            showNotification('{{ session('success') }}', 'success');
        @endif

        @if(session('successDelete'))
            showNotification('{{ session('successDelete') }}', 'successDelete');
        @endif

        @if(session('error'))
            showNotification('{{ session('error') }}', 'error');
        @endif
        @if (session('info'))
            showNotification('{{ session('info') }}', 'info');
        @endif
    });
</script>

<!-- Script for Upload Tracker -->
<script>
/////////////////////////////////////////////////////// START OF UPLOAD MODAL ///////////////////////////////////////////////////////
    /**
     * Function to open the Upload modal.
     *
     * @param {number} sharedClearanceId
     * @param {number} requirementId
     */
    function openUploadModal(sharedClearanceId, requirementId) {
        const requirements = @json($userClearance->sharedClearance->clearance->requirements->pluck('requirement', 'id'));
        
        document.getElementById('uploadModal').classList.remove('hidden');
        document.getElementById('uploadUserClearanceId').value = sharedClearanceId;
        document.getElementById('uploadRequirementId').innerText = requirementId;
        document.getElementById('uploadRequirementIdInput').value = requirementId;
        document.getElementById('uploadRequirementName').textContent = requirements[requirementId];
    }

    // Function to close the upload modal
    function closeUploadModal() {
        document.getElementById('uploadModal').classList.add('hidden');
        document.getElementById('uploadForm').reset();
        document.getElementById('uploadNotification').classList.add('hidden');
        document.getElementById('uploadLoader').classList.add('hidden');
    }

    function createUploadProgress(fileName, fileSize) {
        const uploadList = document.getElementById('uploadList');
        const uploadItem = document.createElement('div');
        uploadItem.className = 'mb-2';
        uploadItem.innerHTML = `
            <div class="font-medium text-sm mb-1">${fileName}</div>
            <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                <div class="bg-blue-500 h-2 rounded-full" style="width: 0%" data-progress="0"></div>
            </div>
            <div class="flex justify-end">
                <div class="text-xs text-gray-600">0% (0 MB of ${(fileSize / (1024 * 1024)).toFixed(2)} MB)</div>
            </div>
        `;
        uploadList.appendChild(uploadItem);
        return uploadItem;
    }

    function updateUploadProgress(uploadItem, percentComplete, loaded, total) {
        const progressBar = uploadItem.querySelector('.bg-blue-500');
        const progressText = uploadItem.querySelector('.text-xs');
        progressBar.style.width = percentComplete + '%';
        progressBar.setAttribute('data-progress', percentComplete);
        progressText.textContent = `${Math.round(percentComplete)}% (${(loaded / (1024 * 1024)).toFixed(2)} MB of ${(total / (1024 * 1024)).toFixed(2)} MB)`;
    }

    function showUploadTracker() {
        const uploadTracker = document.getElementById('uploadTracker');
        uploadTracker.classList.remove('hidden');
    }

    function hideUploadTracker() {
        const uploadTracker = document.getElementById('uploadTracker');
        uploadTracker.classList.add('hidden');
    }

    function checkAllUploadsComplete() {
        const progressBars = document.querySelectorAll('#uploadList .bg-blue-500');
        if (progressBars.length === 0) return false;
        
        return Array.from(progressBars).every(bar => {
            const progress = parseFloat(bar.getAttribute('data-progress'));
            return progress === 100;
        });
    }

    // Single Upload Form Submit Handler with completion tracking
    document.getElementById('uploadForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const sharedClearanceId = document.getElementById('uploadUserClearanceId').value;
        const requirementId = document.getElementById('uploadRequirementIdInput').value;
        const fileInput = document.getElementById('uploadFiles');

        if (fileInput.files.length === 0) {
            showNotification('Please select at least one file to upload.', 'error');
            return;
        }

        const files = fileInput.files;
        for (let i = 0; i < files.length; i++) {
            if (files[i].type !== 'application/pdf' && files[i].type !== 'image/*' && files[i].type !== 'application/msword' && files[i].type !== 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') { // Only allow PDF only but for Testing Images, Word, and Excel files
                showNotification('Only PDF files are allowed.', 'error');
                return;
            }
        }

        showUploadTracker();

        for (let i = 0; i < files.length; i++) {
            const formData = new FormData();
            formData.append('files[]', files[i]);

            const uploadItem = createUploadProgress(files[i].name, files[i].size);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', `/faculty/clearances/${sharedClearanceId}/upload/${requirementId}`, true);
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

            xhr.upload.onprogress = function(event) {
                if (event.lengthComputable) {
                    const percentComplete = (event.loaded / event.total) * 100;
                    updateUploadProgress(uploadItem, percentComplete, event.loaded, event.total);
                    
                    // Check if all uploads are complete after each progress update
                    if (checkAllUploadsComplete()) {
                        setTimeout(() => {
                            closeUploadModal();
                            location.reload();
                        }, 1000);
                    }
                }
            };

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        showNotification(response.message, 'success');
                        updateUploadProgress(uploadItem, 100, files[i].size, files[i].size);
                    } else {
                        showNotification(response.message || 'Failed to upload files.', 'error');
                    }
                } else {
                    showNotification('An error occurred while uploading the files.', 'error');
                }
                
                if (document.getElementById('uploadList').children.length === 0) {
                    hideUploadTracker();
                }
            };

            xhr.onerror = function() {
                showNotification('An error occurred while uploading the files.', 'error');
                uploadItem.remove();
                if (document.getElementById('uploadList').children.length === 0) {
                    hideUploadTracker();
                }
            };

            xhr.send(formData);
        }
    });
</script>

<!-- Return to Top Button -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const returnToTopButton = document.getElementById('returnToTop');

        window.addEventListener('scroll', function() {
            if (window.scrollY > 200) {
                returnToTopButton.classList.remove('hidden');
            } else {
                returnToTopButton.classList.add('hidden');
            }
        });

        returnToTopButton.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
</script>
    
