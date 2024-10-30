<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Department') }}
        </h2>
    </x-slot>
    <div class="container mx-auto p-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6">
                <div class="flex items-center mb-4">
                    <div class="relative group">
                        <div class="bg-yellow-100 rounded-full p-3 mr-4 border-2 border-yellow-300 transition-colors duration-300 group-hover:bg-blue-100 group-hover:border-blue-300">
                            <img id="preview-image" src="{{ $department->profile_picture ? asset('storage/' . $department->profile_picture) : '#' }}" 
                                alt="{{ $department->name }}" 
                                class="h-16 w-16 rounded-full object-cover {{ $department->profile_picture ? '' : 'hidden' }}">
                            <svg id="default-image" class="h-16 w-16 text-yellow-500 transition-colors duration-300 group-hover:text-blue-500 {{ $department->profile_picture ? 'hidden' : '' }}" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <label for="profile_picture" class="absolute inset-0 cursor-pointer flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black bg-opacity-50 rounded-full">
                            <span class="text-white text-sm">Change</span>
                        </label>
                        <input type="file" id="profile_picture" name="profile_picture" class="hidden" accept="image/*">
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-white">Edit Department Details</h2>
                        <p class="text-blue-100 mt-2">Update information for {{ $department->name }}</p>
                    </div>
                </div>
                <div class="mt-2 bg-yellow-50 rounded-lg p-3">
                    <p class="text-sm text-yellow-700">
                        <i class="fas fa-info-circle mr-2"></i>
                        Hover over the department image and click "Change" to update the profile picture. Supported formats: JPEG, PNG, JPG, GIF (max 2MB)
                    </p>
                </div>
            </div>

            <form action="{{ route('admin.updateDepartment', $department->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2 md:col-span-1">
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Department Name</label>
                            <input type="text" name="name" id="name" value="{{ $department->name }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                required>
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" id="description" rows="4" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">{{ $department->description }}</textarea>
                        </div>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Associated Programs</label>
                            <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                                <div class="p-4 border-b border-gray-200">
                                    <div class="flex items-center space-x-3">
                                        <input type="text" id="new-program-input" 
                                            placeholder="Enter program name" 
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 text-sm">
                                        <button type="button" onclick="addProgram()" 
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                            <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            Add Program
                                        </button>
                                    </div>
                                </div>

                                <div class="divide-y divide-gray-200">
                                    <div class="p-4 bg-yellow-50 border-b border-yellow-100">
                                        <p class="text-sm text-yellow-700">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                            Note: Checking a checkbox will mark that program for deletion. Uncheck to keep the program.
                                        </p>
                                    </div>
                                    <ul class="divide-y divide-gray-200" id="program-list">
                                        @foreach($department->programs as $program)
                                            <li class="p-4 hover:bg-gray-50 transition-colors duration-150">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center space-x-3">
                                                        <input type="checkbox" name="remove_programs[]" value="{{ $program->id }}" 
                                                            class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                                            onchange="toggleHighlight(this)">
                                                        <span class="text-gray-700">{{ $program->name }}</span>
                                                    </div>
                                                    <button type="button" onclick="removeExistingProgram(this)" 
                                                        class="text-gray-400 hover:text-red-500 transition-colors duration-200">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div id="new-programs" class="divide-y divide-gray-200"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6 mt-6 flex justify-end space-x-4">
                    <a href="{{ route('admin.views.college') }}" 
                        class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all duration-200">
                        Cancel
                    </a>
                    <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transform hover:scale-105 transition-all duration-200">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('profile_picture').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('preview-image').classList.remove('hidden');
                    document.getElementById('default-image').classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        function addProgram() {
            const programName = document.getElementById('new-program-input').value;
            if (programName) {
                const newProgramDiv = document.createElement('li');
                newProgramDiv.classList.add('p-4', 'hover:bg-gray-50', 'transition-colors', 'duration-150', 'list-none');
                newProgramDiv.innerHTML = `
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" name="new_programs[]" value="${programName}" 
                                class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                checked>
                            <span class="text-gray-700">${programName}</span>
                        </div>
                        <button type="button" onclick="removeProgram(this)" 
                            class="text-gray-400 hover:text-red-500 transition-colors duration-200">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                `;
                document.getElementById('new-programs').appendChild(newProgramDiv);
                document.getElementById('new-program-input').value = '';
            }
        }

        function removeProgram(button) {
            button.closest('div').remove();
        }

        function removeExistingProgram(button) {
            const listItem = button.closest('li');
            const checkbox = listItem.querySelector('input[type="checkbox"]');
            checkbox.checked = true;
            listItem.classList.add('opacity-50');
        }

        function toggleHighlight(checkbox) {
            const listItem = checkbox.closest('li');
            if (checkbox.checked) {
                listItem.classList.add('opacity-50');
            } else {
                listItem.classList.remove('opacity-50');
            }
        }
    </script>
</x-admin-layout>