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
  
    <div class="p-8 bg-white border-b border-gray-200">
        {{-- Display User ID and Name --}}
        <div class="mb-8 bg-indigo-50 p-6 rounded-xl shadow-sm">
            <h3 class="text-2xl font-bold mb-4 text-indigo-800">User Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center">
                    <span class="text-indigo-600 font-semibold mr-2">ID:</span>
                    <span class="text-gray-800">{{ $userClearance->user->id }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-indigo-600 font-semibold mr-2">Name:</span>
                    <span class="text-gray-800">{{ $userClearance->user->name }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-indigo-600 font-semibold mr-2">Position:</span>
                    <span class="text-gray-800">{{ $userClearance->user->position }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-indigo-600 font-semibold mr-2">Unit:</span>
                    <span class="text-gray-800">{{ $userClearance->user->units }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-indigo-600 font-semibold mr-2">Program:</span>
                    <span class="text-gray-800">{{ $userClearance->user->program }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-indigo-600 font-semibold mr-2">Email:</span>
                    <span class="text-gray-800">{{ $userClearance->user->email }}</span>
                </div>
            </div>
        </div>

        <h3 class="text-3xl font-bold mb-6 text-gray-800">{{ $userClearance->sharedClearance->clearance->document_name }}</h3>
        <div class="overflow-x-auto shadow-md rounded-lg">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Requirement</th>
                        <th class="py-3 px-4 text-center text-xs font-medium uppercase tracking-wider">Uploaded Files</th>
                        <th class="py-3 px-4 text-center text-xs font-medium uppercase tracking-wider">Signature Status</th>
                        <th class="py-3 px-4 text-center text-xs font-medium uppercase tracking-wider">Feedback</th>
                        <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($userClearance->sharedClearance->clearance->requirements as $requirement)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-4 py-4 text-sm text-gray-900">{{ $requirement->requirement }}</td>
                            <td class="px-4 py-4">
                                @foreach($userClearance->uploadedClearances->where('user_id', $userClearance->user->id) as $uploaded)
                                    @if($uploaded->requirement_id == $requirement->id)
                                        <div class="flex items-center justify-center space-x-2">
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V8l-6-6H4zm2 2h8v4h4v10H6V6z"></path>
                                            </svg>
                                            <a href="{{ asset('storage/' . $uploaded->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline text-sm font-medium">
                                                {{ basename($uploaded->file_path) }}
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </td>
                            <td class="px-4 py-4 text-center">
                                @php
                                    $feedback = $requirement->feedback->where('user_id', $userClearance->user->id)->first();
                                    $uploadedFile = $userClearance->uploadedClearances->where('user_id', $userClearance->user->id)->where('requirement_id', $requirement->id)->first();
                                @endphp
                                @if($uploadedFile)
                                    @if($feedback)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $feedback->signature_status == 'Signed' ? 'green' : ($feedback->signature_status == 'Return' ? 'red' : 'yellow') }}-100 text-{{ $feedback->signature_status == 'Signed' ? 'green' : ($feedback->signature_status == 'Return' ? 'red' : 'yellow') }}-800">
                                            {{ $feedback->signature_status }}
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">On Check</span>
                                    @endif
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">No Attachment</span>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                @php
                                $feedback = $userClearance->sharedClearance->clearance->requirements
                                    ->where('id', $requirement->id)
                                    ->first()
                                    ->feedback
                                    ->where('user_id', $userClearance->user_id)
                                    ->first();
                                @endphp
                            
                                @if($feedback && !empty($feedback->message))
                                    <p class="text-yellow-800"><strong>Feedback: {{ $feedback->message }}</strong></p>
                                @else
                                    <p class="text-gray-400 italic">No comments yet.</p>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <button onclick="openFeedbackModal({{ $requirement->id }})" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-full transition-colors duration-200 text-sm font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-opacity-50">
                                    Actions Document
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
            
       

    <!-- Add this modal at the end of your Blade file -->
    <div id="feedbackModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
        <div class="bg-white p-8 rounded-xl shadow-2xl max-w-md w-full">
            <h3 class="text-2xl font-bold mb-6 text-gray-800">Provide Feedback</h3>
            <form id="feedbackForm">
                @csrf
                <input type="hidden" name="requirement_id" id="requirementId">
                <input type="hidden" name="user_id" value="{{ $userClearance->user->id }}">
                <div class="mb-6">
                    <label for="signatureStatus" class="block text-sm font-medium text-gray-700 mb-2">Signature Status</label>
                    <select name="signature_status" id="signatureStatus" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="On Check">On Check</option>
                        <option value="Signed">Signed</option>
                        <option value="Return">Return</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label for="feedbackMessage" class="block text-sm font-medium text-gray-700 mb-2">Feedback (Optional)</label>
                    <textarea name="message" id="feedbackMessage" rows="4" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter feedback if needed"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeFeedbackModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition-colors duration-200">Cancel</button>
                    <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Loading overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-white"></div>
    </div>

    <script>
        function openFeedbackModal(requirementId) {
            document.getElementById('requirementId').value = requirementId;
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

        function showLoading() {
            document.getElementById('loadingOverlay').classList.remove('hidden');
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').classList.add('hidden');
        }

        document.getElementById('feedbackForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            showLoading();

            fetch('{{ route('admin.clearance.feedback.store') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
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
                hideLoading();
                console.error('Error:', error);
                showNotification('An error occurred.');
            });
        });
    </script>
</x-admin-layout>