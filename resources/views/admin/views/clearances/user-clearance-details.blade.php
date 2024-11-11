<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Clearance Details') }}
        </h2>
    </x-slot>

    <!-- Notification component -->
    <div id="notification" class="fixed top-5 right-5 bg-green-500 text-white p-4 rounded-lg shadow-lg transform transition-all duration-500 -translate-y-full opacity-0 z-50">
        <p id="notificationMessage" class="font-semibold"></p>
    </div>
    
    {{-- <!-- Loading overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-white"></div>
    </div> --}}
  
    {{-- Display User ID and Name --}}
    <div class="mb-8 p-6 flex items-center space-x-8 border border-gray-300">
        <div class="flex flex-col md:flex-row items-start md:items-center space-y-6 md:space-y-0 md:space-x-8 p-6">
            <div class="flex-shrink-0">
                @if ($userClearance->user->profile_picture)
                    @if (str_contains($userClearance->user->profile_picture, 'http'))
                        <img src="{{ $userClearance->user->profile_picture }}" alt="{{ $userClearance->user->name }}" class="w-32 h-32 object-cover rounded-full border-4 border-indigo-200">
                    @else
                        <img src="{{ url('/profile_pictures/' . basename($userClearance->user->profile_picture)) }}" alt="{{ $userClearance->user->name }}" class="w-32 h-32 object-cover rounded-full border-4 border-indigo-200">
                    @endif
                @else
                    <div class="w-32 h-32 flex items-center justify-center rounded-full text-white font-bold text-4xl border-4 border-indigo-200" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        {{ strtoupper(substr($userClearance->user->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="flex-grow">
                <h3 class="text-3xl font-extrabold text-gray-800 mb-2">{{ $userClearance->user->name }}</h3>
                <p class="text-lg text-indigo-600 mb-4">{{ $userClearance->user->email }}</p>
                <div class="grid grid-cols-2 gap-y-3 gap-x-8 text-gray-700">
                    <div>
                        <span class="font-semibold text-gray-900">ID:</span>
                        <span>{{ $userClearance->user->id }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-900">Position:</span>
                        <span>{{ $userClearance->user->position }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-900">Unit:</span>
                        <span>{{ $userClearance->user->units }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-900">College:</span>
                        <span>{{ $college->name ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-900">Program:</span>
                        <span>{{ $program->name ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="border-l-2 border-gray-400 h-52 mx-6"></div>
        
        <div class="mt-8">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-2xl font-semibold text-gray-800">Clearance Details</h4>
                <div class="h-1 flex-grow mx-4 bg-gradient-to-r from-indigo-500 to-purple-500 rounded"></div>
            </div>
            <div class="space-y-4">
                <div>
                    <span class="text-lg font-medium text-gray-700">Title:</span>
                    <p class="text-xl text-indigo-600">{{ $userClearance->sharedClearance->clearance->document_name }}</p>
                </div>
                <div>
                    <span class="text-lg font-medium text-gray-700">Description:</span>
                    <p class="text-gray-600 mt-1">{{ $userClearance->sharedClearance->clearance->description ?? 'No description available' }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Reset Button -->
    <button id="resetButton" class="bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform transition duration-200 ease-in-out hover:scale-105 flex items-center space-x-2 border-2 border-red-600 hover:border-red-800">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
        </svg>
        <span>Update User Clearances</span>
    </button>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50 mt-10">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
            <h3 id="confirmationMessage" class="text-lg font-semibold text-gray-800 mb-4"></h3>
            <div class="flex justify-end space-x-3">
                <button onclick="closeConfirmationModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition-colors duration-200">Cancel</button>
                <button id="confirmResetButton" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">Confirm</button>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('resetButton').addEventListener('click', function() {
            const clearanceStatus = '{{ $userClearance->user->clearances_status }}';
            const message = clearanceStatus === 'Complete'
                ? 'The clearance is complete. Are you sure you want to reset?'
                : 'The clearance is not complete. Are you sure you want to reset?';
    
            document.getElementById('confirmationMessage').textContent = message;
            document.getElementById('confirmationModal').classList.remove('hidden');
        });
    
        document.getElementById('confirmResetButton').addEventListener('click', function() {
            // showLoading();

            fetch('{{ route('admin.clearance.resetSpecific', ['userId' => $userClearance->user->id]) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // hideLoading();
                if (data.success) {
                    showNotification('User clearance reset successfully.');
                    location.reload();
                } else {
                    showNotification('Failed to reset user clearance.', false);
                }
            })
            .catch(error => {
                // hideLoading();
                console.error('Error:', error);
                showNotification('An error occurred.', false);
            });

            closeConfirmationModal();
        });

        // function showLoading() {
        //     document.getElementById('loadingOverlay').classList.remove('hidden');
        // }

        // function hideLoading() {
        //     document.getElementById('loadingOverlay').classList.add('hidden');
        // }
    
        function closeConfirmationModal() {
            document.getElementById('confirmationModal').classList.add('hidden');
        }
    </script>

    <h3 class="text-3xl font-bold mb-6 text-gray-800 hidden">{{ $userClearance->sharedClearance->clearance->document_name }}</h3> 
    <div class="overflow-x-auto shadow-md rounded-lg">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-indigo-600 text-white">
                <tr>
                    <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Requirement</th>
                    <th class="py-3 px-4 text-center text-xs font-medium uppercase tracking-wider">Uploaded Files</th>
                    <th class="py-3 px-4 text-center text-xs font-medium uppercase tracking-wider">Document<br>Status</th>
                    @if(Auth::user()->user_type === 'Admin')
                        <th class="py-3 px-4 text-center text-xs font-medium uppercase tracking-wider">Feedback</th>
                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($userClearance->sharedClearance->clearance->requirements as $requirement)
                    @php
                        // Get the feedback for the current requirement and user
                        $feedback = $requirement->feedback->where('user_id', $userClearance->user->id)->first();
                        
                        // Get the most recent uploaded file for the current requirement and user
                        $uploadedFile = $userClearance->uploadedClearances
                            ->where('user_id', $userClearance->user->id)
                            ->where('requirement_id', $requirement->id)
                            ->sortByDesc('created_at')
                            ->first();
                        
                        // Determine if the requirement is complied based on feedback and upload dates
                        $isComplied = $uploadedFile && $feedback && $feedback->signature_status == 'Resubmit' && $uploadedFile->created_at > $feedback->updated_at;
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-4 py-4 text-sm text-gray-900 whitespace-pre-line">{{ $requirement->requirement }}</td>
                        <td class="px-4 py-4">
                            @foreach($userClearance->uploadedClearances->where('user_id', $userClearance->user->id)->where('requirement_id', $requirement->id)->where('is_archived', false)->sortByDesc('created_at') as $uploaded)
                                <div class="flex items-center justify-start space-x-3">
                                    <span class="w-3 h-3 bg-gradient-to-r from-green-400 to-blue-500 rounded-full shadow-md"></span>
                                    <!-- Update the link to use the viewFile function for previewing -->
                                    <a href="#" data-path="{{ $uploaded->file_path }}" class="file-link text-indigo-600 hover:text-indigo-800 hover:underline text-sm font-medium transition duration-300">
                                        {{ basename($uploaded->file_path) }}
                                    </a>
                                </div>
                            @endforeach
                        </td>
                        <td class="px-4 py-4 text-center">
                            @if($isComplied)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Returned Complied
                                </span>
                            @elseif($uploadedFile && !$uploadedFile->is_archived)
                                @if($feedback && !$feedback->is_archived)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $feedback->signature_status == 'Complied' ? 'green' : ($feedback->signature_status == 'Resubmit' ? 'red' : 'yellow') }}-100 text-{{ $feedback->signature_status == 'Complied' ? 'green' : ($feedback->signature_status == 'Resubmit' ? 'red' : 'yellow') }}-800">
                                        {{ $feedback->signature_status }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Checking</span>
                                @endif
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">No Attachment</span>
                            @endif
                        </td>
                        @if(Auth::user()->user_type === 'Admin')
                            <td class="px-4 py-4">
                                @if($feedback && !$feedback->is_archived && !empty($feedback->message) && $uploadedFile && !$uploadedFile->is_archived)
                                    <p class="text-yellow-800"><strong> {{ $feedback->message }}</strong></p>
                                @else
                                    <p class="text-gray-400 italic">No comments yet.</p>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <button onclick="openFeedbackModal({{ $requirement->id }})" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-full transition-colors duration-200 text-sm font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-opacity-50">
                                    Actions Document
                                </button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
            
       

    <!-- Feedback Modal -->
    <div id="feedbackModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-70 hidden z-50 transition-opacity duration-300">
        <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 to-blue-500"></div>
            <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Provide Feedback
            </h3>
            <form id="feedbackForm">
                @csrf
                <input type="hidden" name="requirement_id" id="requirementId">
                <input type="hidden" name="user_id" value="{{ $userClearance->user->id }}">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Requirement Details</label>
                    <p id="requirementName" class="text-sm text-gray-600 bg-gray-100 p-2 rounded whitespace-pre-line"></p>
                </div>
                <div class="mb-6">
                    <label for="signatureStatus" class="block text-sm font-medium text-gray-700 mb-2">Document Status</label>
                    <select name="signature_status" id="signatureStatus" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="Checking">Checking</option>
                        <option value="Complied">Complied</option>
                        <option value="Resubmit">Resubmit</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label for="feedbackMessage" class="block text-sm font-medium text-gray-700 mb-2">Feedback (Optional)</label>
                    <textarea name="message" id="feedbackMessage" rows="4" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter feedback if needed"></textarea>
                </div>
                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" onclick="closeFeedbackModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md flex items-center transition duration-300 ease-in-out hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-md flex items-center transition duration-300 ease-in-out hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Save
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-70 hidden z-50 transition-opacity duration-300">
        <div class="bg-white p-3 rounded-2xl shadow-2xl max-w-5xl w-11/12 h-5/6 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
            <div class="flex justify-between items-center mb-4">
                <h3 id="previewFileName" class="text-2xl font-bold text-gray-800"></h3>
                <button onclick="closePreviewModal()" class="text-gray-500 hover:text-gray-700 transition duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="flex-1 overflow-auto h-full">
                <iframe id="previewFrame" class="w-full h-full border-0"></iframe>
            </div>
        </div>
    </div>
    

    <script>
        function openFeedbackModal(requirementId) {
            const feedback = @json($userClearance->sharedClearance->clearance->requirements->pluck('feedback', 'id'));
            const requirements = @json($userClearance->sharedClearance->clearance->requirements->pluck('requirement', 'id'));
            const currentFeedback = feedback[requirementId]?.find(f => f.user_id === {{ $userClearance->user->id }});

            document.getElementById('requirementId').value = requirementId;
            document.getElementById('requirementName').textContent = `Requirement ID: ${requirementId}\n${requirements[requirementId]}`;
            document.getElementById('signatureStatus').value = currentFeedback?.signature_status || 'Checking';
            document.getElementById('feedbackMessage').value = currentFeedback?.message || '';

            document.getElementById('feedbackModal').classList.remove('hidden');
        }

        function closeFeedbackModal() {
            document.getElementById('feedbackModal').classList.add('hidden');
        }

        function showNotification(message) {
            const notification = document.getElementById('notification');
            const notificationMessage = document.getElementById('notificationMessage');
            notificationMessage.textContent = message;
            notification.classList.remove('-translate-y-full', 'opacity-0');
            setTimeout(() => {
                notification.classList.add('-translate-y-full', 'opacity-0');
            }, 5000);
        }

        // function showLoading() {
        //     document.getElementById('loadingOverlay').classList.remove('hidden');
        // }

        // function hideLoading() {
        //     document.getElementById('loadingOverlay').classList.add('hidden');
        // }

        document.getElementById('feedbackForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            // showLoading();

            fetch('{{ route('admin.clearance.feedback.store') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                // hideLoading();
                if (data.success) {
                    closeFeedbackModal();
                    showNotification('Feedback saved successfully.');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification('Failed to save feedback.');
                }
            })
            .catch(error => {
                // hideLoading();
                console.error('Error:', error);
                showNotification('An error occurred.');
            });
        });

        function viewFile(path, filename) {
            const previewModal = document.getElementById('previewModal');
            const previewFrame = document.getElementById('previewFrame');
            const previewFileName = document.getElementById('previewFileName');
            
          // Convert the storage URL to our direct file viewing route
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

        // Update the link to use viewFile function
        document.querySelectorAll('.file-link').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const path = this.getAttribute('data-path');
                const filename = this.textContent;
                viewFile(path, filename);
            });
        });
    </script>
</x-admin-layout>