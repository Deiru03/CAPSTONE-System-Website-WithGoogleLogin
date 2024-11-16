<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="w-full bg-white p-1 rounded-lg ">
        @csrf

        @if ($errors->any())
        <div class="mb-4 p-4 rounded-md bg-red-50 border border-red-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">There were errors with your submission:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <h2 class="text-2xl font-semibold mb-4 text-center text-gray-800">Create an Account</h2>

        <div class="grid grid-cols-3 gap-3 mb-4">
            <!-- User Type -->
            <div>
                <x-input-label for="user_type" :value="__('User Type')" class="text-xs font-medium text-gray-700" />
                <select id="user_type" name="user_type" class="mt-1 block w-full text-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" onchange="toggleAdminIdField()">
                    <option value="Faculty" {{ old('user_type') === 'Faculty' ? 'selected' : '' }}>Faculty</option>
                    <option value="Admin" {{ old('user_type') === 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Program-Head" {{ old('user_type') === 'Program-Head' ? 'selected' : '' }}>Program Head</option>
                    <option value="Dean" {{ old('user_type') === 'Dean' ? 'selected' : '' }}>Dean</option>
                </select>
                @error('user_type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Position -->
            <div>
                <x-input-label for="position" :value="__('Position')" class="text-xs font-medium text-gray-700" />
                <select id="position" name="position" :value="old('position')" required autocomplete="position" class="mt-1 block w-full text-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                    <option value="Part-Timer" {{ old('position') == 'Part-Timer' ? 'selected' : '' }}>Part-Timer</option>
                    <option value="Temporary" {{ old('position') == 'Temporary' ? 'selected' : '' }}>Temporary</option>
                    <option value="Permanent-PartTime" {{ old('position') == 'Permanent-PartTime' ? 'selected' : '' }}>Permanent (Part-Time)</option>
                    <option value="Permanent-FullTime" {{ old('position') == 'Permanent-FullTime' ? 'selected' : '' }}>Permanent (Full-Time)</option>
                    <option value="Dean" {{ old('position') == 'Dean' ? 'selected' : '' }}>Dean</option>
                    <option value="Program-Head" {{ old('position') == 'Program-Head' ? 'selected' : '' }}>Program-Head</option>
                </select>
                @error('position')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Units -->
            <div>
                <x-input-label for="units" :value="__('Units')" class="text-xs font-medium text-gray-700" />
                <x-text-input id="units" class="mt-1 block w-full text-sm" type="number" name="units" :value="old('units')"  />
                @error('units')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

             <!-- Admin ID (conditionally displayed) -->
             <div id="admin_id_field" style="display: none;">
                <x-input-label for="admin_id" :value="__('Admin ID')" class="text-xs font-medium text-gray-700" />
                <x-text-input id="admin_id" class="mt-1 block w-full text-sm" type="text" name="admin_id" :value="old('admin_id')" />
                @error('admin_id')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Program Head ID (conditionally displayed) -->
            <div id="program_head_id_field" style="display: none;">
                <x-input-label for="program_head_id" :value="__('Program Head ID')" class="text-xs font-medium text-gray-700" />
                <x-text-input id="program_head_id" class="mt-1 block w-full text-sm" type="text" name="program_head_id" :value="old('program_head_id')" />
                @error('program_head_id')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Dean ID (conditionally displayed) -->
            <div id="dean_id_field" style="display: none;">
                <x-input-label for="dean_id" :value="__('Dean ID')" class="text-xs font-medium text-gray-700" />
                <x-text-input id="dean_id" class="mt-1 block w-full text-sm" type="text" name="dean_id" :value="old('dean_id')" />
                @error('dean_id')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <script>
                function toggleAdminIdField() {
                    const userType = document.getElementById('user_type').value;
                    const adminIdField = document.getElementById('admin_id_field');
                    const programHeadIdField = document.getElementById('program_head_id_field');
                    const deanIdField = document.getElementById('dean_id_field');
                    
                    // Hide all fields first
                    adminIdField.style.display = 'none';
                    programHeadIdField.style.display = 'none';
                    deanIdField.style.display = 'none';
                    
                    // Show relevant field based on user type
                    if (userType === 'Admin') {
                        adminIdField.style.display = 'block';
                    } else if (userType === 'Program-Head') {
                        programHeadIdField.style.display = 'block';
                    } else if (userType === 'Dean') {
                        deanIdField.style.display = 'block';
                    }
                }

                // Call the function on page load to handle initial state
                document.addEventListener('DOMContentLoaded', toggleAdminIdField);
            </script>
        </div>

        <!-- Name and Email -->
        <div class="grid grid-cols-2 gap-3 mb-4">
            <div>
                <x-input-label for="name" :value="__('Name')" class="text-xs font-medium text-gray-700" />
                <x-text-input id="name" class="mt-1 block w-full text-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-xs font-medium text-gray-700" />
                <x-text-input id="email" class="mt-1 block w-full text-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Department and Program -->
        <div class="grid grid-cols-2 gap-3 mb-4">
            <div>
                <x-input-label for="campus_id" :value="__('Campus')" class="text-xs font-medium text-gray-700" />
                <select id="campus_id" name="campus_id" required class="mt-1 block w-full text-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                    <option value="" disabled selected>Select your campus</option>
                    @foreach($campuses as $campus)
                        <option value="{{ $campus->id }}" {{ old('campus_id') == $campus->id ? 'selected' : '' }}>
                            {{ $campus->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <x-input-label for="department_id" :value="__('Department')" class="text-xs font-medium text-gray-700" />
                <select id="department_id" name="department_id" required class="mt-1 block w-full text-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                    <option value="" disabled>Select your department</option>
                </select>
            </div>
            
            <div class="col-span-2">
                <x-input-label for="program_id" :value="__('Program')" class="text-xs font-medium text-gray-700" />
                <select id="program_id" name="program_id" required class="mt-1 block w-full text-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                    <option value="" disabled>Select your program</option>
                </select>
            </div>
        </div>

        <!-- Password and Confirm Password -->
        <div class="grid grid-cols-2 gap-3 mb-4">
            <div class="relative">
                <x-input-label for="password" :value="__('Password')" class="text-xs font-medium text-gray-700" />
                <div class="relative" x-data="{ show: false }">
                    <x-text-input id="password" 
                        class="mt-1 block w-full text-sm pr-10"
                        x-bind:type="show ? 'text' : 'password'"
                        name="password"
                        required 
                        autocomplete="new-password" />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button type="button" @click="show = !show" class="focus:outline-none">
                            <template x-if="!show">
                                <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </template>
                            <template x-if="show">
                                <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </template>
                        </button>
                    </div>
                </div>
                <p id="password-hint" class="text-xs text-gray-600 mt-1">Password must be at least 8 characters long, include a letter, a number, and a special character.</p>
                {{-- @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror --}}
            </div>
            <!-- Confirm Password -->
            <div class="relative">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-xs font-medium text-gray-700" />
                <div class="relative" x-data="{ show: false }">
                    <x-text-input id="password_confirmation"
                        class="mt-1 block w-full text-sm pr-10"
                        x-bind:type="show ? 'text' : 'password'"
                        name="password_confirmation"
                        required 
                        autocomplete="new-password" />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button type="button" @click="show = !show" class="focus:outline-none">
                            <template x-if="!show">
                                <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </template>
                            <template x-if="show">
                                <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </template>
                        </button>
                    </div>
                </div>
                {{-- @error('password_confirmation')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror --}}
            </div>
        </div>

        <script>
            function validateForm() {
                let isValid = true;
                const password = document.getElementById('password').value;
                const passwordConfirmation = document.getElementById('password_confirmation').value;
                const email = document.getElementById('email').value;
                const adminIdField = document.getElementById('admin_id_field');
                const adminId = document.getElementById('admin_id') ? document.getElementById('admin_id').value : null;

                // Validate password
                if (password !== passwordConfirmation) {
                    alert('Passwords do not match.');
                    isValid = false;
                }

                // Validate email
                if (!email.includes('@')) {
                    alert('Please enter a valid email address.');
                    isValid = false;
                }

                // Validate admin ID if visible
                if (adminIdField.style.display === 'block' && !adminId) {
                    alert('Admin ID is required for Admin user type.');
                    isValid = false;
                }

                // Add more validation checks as needed

                return isValid;
            }

            function toggleAdminIdField() {
                const userType = document.getElementById('user_type').value;
                const adminIdField = document.getElementById('admin_id_field');
                adminIdField.style.display = userType === 'Admin' ? 'block' : 'none';
            }
            toggleAdminIdField();

            document.getElementById('department_id').addEventListener('change', function() {
                const departmentId = this.value;
                const programs = @json($departments->pluck('programs', 'id'));
                const programSelect = document.getElementById('program_id');
 
                programSelect.innerHTML = '<option value="" disabled>Select a program</option>';
                if (programs[departmentId]) {
                    programs[departmentId].forEach(program => {
                        const option = document.createElement('option');
                        option.value = program.id;
                        option.textContent = program.name;
                        option.selected = program.id == {{ old('program_id') }}; // Preserve selected program
                        programSelect.appendChild(option);
                    });
                }
            });
        </script>

        <script>
            function validatePassword(password) {
                const hint = document.getElementById('password-hint');
                const lengthRequirement = password.length >= 8;
                const letterRequirement = /[a-zA-Z]/.test(password);
                const numberRequirement = /\d/.test(password);
                const specialCharRequirement = /[!@#$%^&*(),.?":{}|<>]/.test(password);
        
                if (lengthRequirement && letterRequirement && numberRequirement && specialCharRequirement) {
                    hint.textContent = 'Password meets all requirements.';
                    hint.classList.remove('text-gray-600');
                    hint.classList.add('text-green-600');
                } else {
                    hint.textContent = 'Password must be at least 8 characters long, include a letter, a number, and a special character.';
                    hint.classList.remove('text-green-600');
                    hint.classList.add('text-gray-600');
                }
            }
            // Trigger change event to populate programs on page load
            document.getElementById('department_id').dispatchEvent(new Event('change'));
        </script>

        <div class="flex items-center justify-between mb-4">
            <a class="text-md text-blue-600 hover:text-blue-600" href="{{ route('login') }}">
                {{ __('Sign In') }}
            </a>
            <x-primary-button class="ml-3 px-4 py-2 text-sm bg-blue-600 hover:bg-blue-700">
                {{ __('Register') }}
            </x-primary-button>
        </div>

        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">Or continue with</span>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('google.login') }}" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Google
            </a>
        </div>
    </form>

    <script>
        function togglePasswordVisibility(inputId) {
            var input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const oldCampusId = "{{ old('campus_id') }}";
            const oldDepartmentId = "{{ old('department_id') }}";
            const oldProgramId = "{{ old('program_id') }}";

            if (oldCampusId) {
                document.getElementById('campus_id').value = oldCampusId;
                loadDepartments(oldCampusId, oldDepartmentId);
            }

            if (oldDepartmentId) {
                loadPrograms(oldDepartmentId, oldProgramId);
            }
        });

        document.getElementById('campus_id').addEventListener('change', function() {
            const campusId = this.value;
            loadDepartments(campusId);
        });

        document.getElementById('department_id').addEventListener('change', function() {
            const departmentId = this.value;
            loadPrograms(departmentId);
        });

        function loadDepartments(campusId, selectedDepartmentId = null) {
            const departmentSelect = document.getElementById('department_id');
            departmentSelect.innerHTML = '<option value="" disabled selected>Select your department</option>';

            if (campusId) {
                fetch(`/departments/${campusId}`)
                    .then(response => response.json())
                    .then(departments => {
                        departments.forEach(department => {
                            const option = document.createElement('option');
                            option.value = department.id;
                            option.textContent = department.name;
                            if (selectedDepartmentId && selectedDepartmentId == department.id) {
                                option.selected = true;
                            }
                            departmentSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching departments:', error));
            }
        }

        function loadPrograms(departmentId, selectedProgramId = null) {
            const programSelect = document.getElementById('program_id');
            programSelect.innerHTML = '<option value="" disabled selected>Select your program</option>';

            if (departmentId) {
                fetch(`/programs/${departmentId}`)
                    .then(response => response.json())
                    .then(programs => {
                        programs.forEach(program => {
                            const option = document.createElement('option');
                            option.value = program.id;
                            option.textContent = program.name;
                            if (selectedProgramId && selectedProgramId == program.id) {
                                option.selected = true;
                            }
                            programSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching programs:', error));
            }
        }
    </script>
</x-guest-layout>
