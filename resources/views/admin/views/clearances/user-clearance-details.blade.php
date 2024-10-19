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
  
    {{-- Display User ID and Name --}}
    <div class="mb-8 p-6 flex items-center space-x-8 border border-gray-300">
        <div class="flex flex-col md:flex-row items-start md:items-center space-y-6 md:space-y-0 md:space-x-8 p-6">
            <div class="flex-shrink-0">
                @if ($userClearance->user->profile_picture)
                    <img src="{{ $userClearance->user->profile_picture }}" alt="{{ $userClearance->user->name }}" class="w-32 h-32 object-cover rounded-full border-4 border-indigo-200">
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
                        <span class="font-semibold text-gray-900">Program:</span>
                        <span>{{ $userClearance->user->program }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-900">College:</span>
                        {{-- <span>{{ $userClearance->user->college }}</span> --}}
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

    <h3 class="text-3xl font-bold mb-6 text-gray-800 hidden">{{ $userClearance->sharedClearance->clearance->document_name }}</h3> 
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
                                    <div class="flex items-center justify-start space-x-3">
                                        <span class="w-3 h-3 bg-gradient-to-r from-green-400 to-blue-500 rounded-full shadow-md"></span>
                                        <a href="{{ asset('storage/' . $uploaded->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 hover:underline text-sm font-medium transition duration-300">
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