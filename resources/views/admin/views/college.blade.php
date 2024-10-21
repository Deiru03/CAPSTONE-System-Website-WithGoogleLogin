<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Departments and Programs') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="mb-8 flex justify-between items-center">
            <h2 class="text-3xl font-bold text-gray-800">Manage Departments and Programs</h2>
            <div>
                <button onclick="openModal('departmentModal')" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full mr-4 transition duration-300 ease-in-out transform hover:scale-105">
                    Add Department
                </button>
                <button onclick="openModal('programModal')" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full transition duration-300 ease-in-out transform hover:scale-105">
                    Add Program
                </button>
            </div>
        </div>

        <!-- Notification -->
        <div id="notification" class="hidden fixed top-0 right-0 m-6 p-4 rounded-lg shadow-lg transition-all duration-500 transform translate-x-full">
            <div class="flex items-center">
                <div id="notificationIcon" class="flex-shrink-0 w-6 h-6 mr-3"></div>
                <div id="notificationMessage" class="text-sm font-medium"></div>
            </div>
        </div>

        <!-- Departments List -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Programs</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($departments as $department)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <svg class="h-12 w-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-base font-medium text-gray-900">
                                            {{ $department->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-base text-gray-900">{{ $department->programs->count() }} programs</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                <button onclick="openDepartmentModal('{{ $department->id }}')" class="flex items-center justify-center mx-auto mb-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View Programs
                                </button>
                                <button onclick="openConfirmModal('removeDepartment', '{{ $department->id }}')" class="flex items-center justify-center mx-auto bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Remove
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Add Department Modal -->
        <div id="departmentModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-70 hidden z-50 transition-opacity duration-300">
            <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full relative overflow-hidden duration-300 scale-95 hover:scale-100">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-400 to-indigo-500"></div>
                <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Add Department
                </h3>
                <form action="{{ route('admin.departments.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-4">
                        <div class="relative">
                            <label for="department_name" class="block text-sm font-medium text-gray-700 mb-1">Department Name</label>
                            <input type="text" name="name" id="department_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" required>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end space-x-4">
                        <button type="button" onclick="closeModal('departmentModal')" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Department
                        </button>
                    </div>
                </form>
                <div id="departmentNotification" class="hidden mt-4 text-blue-600 bg-blue-100 p-3 rounded-lg border border-blue-200"></div>
                
                <!-- Loader for Department Modal -->
                <div id="departmentLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-75 rounded-2xl">
                    <div class="loader border-t-4 border-blue-500 border-solid rounded-full animate-spin h-12 w-12"></div>
                </div>
            </div>
        </div>

        <!-- Add Program Modal -->
        <div id="programModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-70 hidden z-50 transition-opacity duration-300">
            <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full relative overflow-hidden duration-300 scale-95 hover:scale-100">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-green-400 to-blue-500"></div>
                <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Program
                </h3>
                <form action="{{ route('admin.programs.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-4">
                        <div class="relative">
                            <label for="program_name" class="block text-sm font-medium text-gray-700 mb-1">Program Name</label>
                            <input type="text" name="name" id="program_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out" required>
                        </div>
                        <div class="relative">
                            <label for="department_id" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                            <select name="department_id" id="department_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out" required>
                                <option value="" disabled selected>Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end space-x-4">
                        <button type="button" onclick="closeModal('programModal')" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Program
                        </button>
                    </div>
                </form>
                <div id="programNotification" class="hidden mt-4 text-green-600 bg-green-100 p-3 rounded-lg border border-green-200"></div>
                
                <!-- Loader for Program Modal -->
                <div id="programLoader" class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-75 rounded-2xl">
                    <div class="loader border-t-4 border-green-500 border-solid rounded-full animate-spin h-12 w-12"></div>
                </div>
            </div>
        </div>

        <!-- Department Programs Modal -->
        <div id="departmentProgramsModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-70 hidden z-50 transition-opacity duration-300">
            <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full relative overflow-hidden duration-300 scale-95 hover:scale-100">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-400 to-green-500"></div>
                <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center" id="departmentName">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Department Programs
                </h3>
                <div class="relative py-3">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-2 bg-white text-sm text-gray-500">Programs List</span>
                    </div>
                </div>
                <ul id="programsList" class="space-y-3 max-h-96 overflow-y-auto">
                    <!-- Programs will be dynamically added here -->
                </ul>
                <div class="relative py-3 mt-4">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="button" onclick="closeDepartmentProgramsModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Close
                    </button>
                </div>can you `
            </div>
        </div>

        <!-- Confirmation Modal -->
        <div id="confirmModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-70 hidden z-50 transition-opacity duration-300">
            <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full relative overflow-hidden duration-300 scale-95 hover:scale-100">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-400 to-orange-500"></div>
                <h3 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Confirm Action
                </h3>
                <div class="space-y-4">
                    <p class="text-sm text-gray-500" id="confirmMessage">
                        Are you sure you want to perform this action?
                    </p>
                </div>
                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" onclick="closeModal('confirmModal')" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel
                    </button>
                    <button type="button" id="confirmButton" class="px-6 py-3 bg-red-600 text-white rounded-md flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

        {{-- <!-- Confirmation Modal -->
        <div id="confirmModal" class="modal hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Confirm Action
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500" id="confirmMessage">
                                        Are you sure you want to perform this action?
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" id="confirmButton" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Confirm
                        </button>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal('confirmModal')">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function openDepartmentModal(departmentId) {
            const department = @json($departments->keyBy('id'));
            const departmentData = department[departmentId];
            
            document.getElementById('departmentName').textContent = departmentData.name + ' Programs';
            
            const programsList = document.getElementById('programsList');
            programsList.innerHTML = '';
            departmentData.programs.forEach(program => {
                const li = document.createElement('li');
                li.className = 'py-4';
                li.innerHTML = `
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                ${program.name}
                            </p>
                        </div>
                        <button onclick="openConfirmModal('removeProgram', '${program.id}')" class="text-red-500 hover:text-red-700">Remove</button>
                    </div>
                `;
                programsList.appendChild(li);
            });

            openModal('departmentProgramsModal');
        }

        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            const notificationMessage = document.getElementById('notificationMessage');
            const notificationIcon = document.getElementById('notificationIcon');

            notificationMessage.textContent = message;

            if (type === 'success') {
                notification.classList.add('bg-green-100', 'border-l-4', 'border-green-500', 'text-green-700');
                notificationIcon.innerHTML = '<svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
            } else if (type === 'error') {
                notification.classList.add('bg-red-100', 'border-l-4', 'border-red-500', 'text-red-700');
                notificationIcon.innerHTML = '<svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            }

            notification.classList.remove('hidden', 'translate-x-full');
            notification.classList.add('translate-x-0');

            setTimeout(() => {
                notification.classList.remove('translate-x-0');
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    notification.classList.add('hidden');
                    notification.classList.remove('bg-green-100', 'border-l-4', 'border-green-500', 'text-green-700', 'bg-red-100', 'border-red-500', 'text-red-700');
                }, 300);
            }, 3000);
        }

        function openConfirmModal(action, id) {
            const confirmModal = document.getElementById('confirmModal');
            const confirmMessage = document.getElementById('confirmMessage');
            const confirmButton = document.getElementById('confirmButton');

            if (action === 'removeProgram') {
                confirmMessage.textContent = 'Are you sure you want to remove this program?';
                confirmButton.onclick = () => removeProgram(id);
            } else if (action === 'removeDepartment') {
                confirmMessage.textContent = 'Are you sure you want to remove this department?';
                confirmButton.onclick = () => removeDepartment(id);
            }

            openModal('confirmModal');
        }

        function removeProgram(programId) {
            closeModal('confirmModal');
            fetch(`/admin/admin/programs/${programId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Program removed successfully.', 'success');
                    location.reload();
                } else {
                    showNotification('Failed to remove program.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred while removing the program.', 'error');
            });
        }

        function closeDepartmentProgramsModal() {
            closeModal('departmentProgramsModal');
        }

        function removeDepartment(departmentId) {
            closeModal('confirmModal');
            fetch(`/admin/admin/admin/departments/${departmentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Department removed successfully.', 'success');
                    location.reload();
                } else {
                    showNotification('Failed to remove department.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred while removing the department.', 'error');
            });
        }
    </script>
</x-admin-layout>