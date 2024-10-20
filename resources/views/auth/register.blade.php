<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="w-full max-w-4xl mx-auto bg-white p-1">
        @csrf

        <h2 class="text-2xl font-semibold mb-6 text-center text-gray-800">Create an Account</h2>

        <div class="flex flex-col sm:flex-row sm:space-x-4">
            <!-- User Type -->
            <div class="mb-4 w-full sm:w-1/3">
                <x-input-label for="user_type" :value="__('User Type')" class="text-sm font-medium text-gray-700" />
                <select id="user_type" name="user_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="Faculty" selected>Faculty</option>
                    <option value="Admin">Admin</option>
                </select>
                <x-input-error :messages="$errors->get('user_type')" class="mt-2" />
            </div>

            <!-- Position -->
            <div class="mb-4 w-full sm:w-1/3">
                <x-input-label for="position" :value="__('Position')" class="text-sm font-medium text-gray-700" />
                <select id="position" name="position" :value="old('position')" required autocomplete="position" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="Permanent">Permanent</option>
                    <option value="Temporary">Temporary</option>
                    <option value="Part-Timer">Part-Timer</option>
                </select>
                <x-input-error :messages="$errors->get('position')" class="mt-2" />
            </div>

            <!-- Units -->
            <div class="mb-4 w-full sm:w-1/3">
                <x-input-label for="units" :value="__('Units')" class="text-sm font-medium text-gray-700" />
                <x-text-input id="units" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-300 ease-in-out hover:bg-gray-50 hover:border-gray-400" type="number" name="units" :value="old('units')" autocomplete="units" title="Leave blank if not applicable or if you don't have units" />
                <x-input-error :messages="$errors->get('units')" class="mt-2" />
            </div>
        </div>

        <!-- Name -->
        <div class="mb-4">
            <x-input-label for="name" :value="__('Name')" class="text-sm font-medium text-gray-700" />
            <x-text-input id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700" />
            <x-text-input id="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Program -->
        {{-- <div class="mb-4">
            <x-input-label for="program" :value="__('Program')" class="text-sm font-medium text-gray-700" />
            <x-text-input id="program" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" type="text" name="program" :value="old('program')" required autocomplete="program" />
            <x-input-error :messages="$errors->get('program')" class="mt-2" />
        </div> --}}

        <!-- Department -->
        <div class="mb-4">
            <x-input-label for="department_id" :value="__('Department')" class="text-sm font-medium text-gray-700" />
            <select id="department_id" name="department_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                <option value="" disabled selected>Select a department</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
        </div>

        <!-- Program -->
        <div class="mb-4">
            <x-input-label for="program_id" :value="__('Program')" class="text-sm font-medium text-gray-700" />
            <select id="program_id" name="program_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                <option value="" disabled selected>Select a program</option>
                <!-- Options will be populated via JavaScript -->
            </select>
            <x-input-error :messages="$errors->get('program_id')" class="mt-2" />
        </div>

        <!-- Populate Programs -->
        <script>
            document.getElementById('department_id').addEventListener('change', function() {
                const departmentId = this.value;
                const programs = @json($departments->pluck('programs', 'id'));
                const programSelect = document.getElementById('program_id');
     
                programSelect.innerHTML = '<option value="" disabled selected>Select a program</option>';
                if (programs[departmentId]) {
                    programs[departmentId].forEach(program => {
                        const option = document.createElement('option');
                        option.value = program.id;
                        option.textContent = program.name;
                        programSelect.appendChild(option);
                    });
                }
            });
        </script>

        <!-- Password -->
        <div class="mb-4 relative">
            <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-700" />
            <div class="relative">
                <x-text-input id="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm pr-10" type="password" name="password" required autocomplete="new-password" />
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5" onclick="togglePasswordVisibility('password')">
                    <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-6 relative">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-medium text-gray-700" />
            <div class="relative">
                <x-text-input id="password_confirmation" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm pr-10" type="password" name="password_confirmation" required autocomplete="new-password" />
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5" onclick="togglePasswordVisibility('password_confirmation')">
                    <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <script>
            function togglePasswordVisibility(inputId) {
                var input = document.getElementById(inputId);
                if (input.type === "password") {
                    input.type = "text";
                } else {
                    input.type = "password";
                }
            }
        </script>

        <div class="flex items-center justify-between mb-6">
            <a class="text-sm text-indigo-600 hover:text-indigo-500 transition duration-150 ease-in-out" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4 px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
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

        <div class="mt-6">
            <a href="{{ route('google.login') }}" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition duration-150 ease-in-out">
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
</x-guest-layout>
