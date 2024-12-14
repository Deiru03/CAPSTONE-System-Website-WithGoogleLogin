<section>
    <style>
        .profile-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .profile-form {
            flex: 1;
            margin-right: 20px;
        }
        .profile-picture-section {
            width: 200px;
            text-align: center;
        }
        .profile-picture-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
    </style>

    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <!-- Notification -->
    <div id="notification" role="alert" class="hidden fixed top-0 right-0 m-6 p-4 rounded-lg shadow-lg transition-all duration-500 transform translate-x-full z-50">
        <div class="flex items-center">
            <div id="notificationIcon" class="flex-shrink-0 w-6 h-6 mr-3"></div>
            <div id="notificationMessage" class="text-sm font-medium"></div>
        </div>
    </div>

    <div class="profile-container" style="max-width: 1300px; margin: 0 auto;">
        <div class="profile-form">
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                @csrf
                @method('patch')

                <div class="flex items-start">
                    <div class="flex-grow grid grid-cols-2 gap-4">
                        <!-- Personal Information Section -->
                        {{-- <div class="col-span-2">
                            <h3 class="text-lg font-semibold text-gray-900 mt-3">Personal Information</h3>
                        </div> --}}

                        <!-- Name and Email Row -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div>
                                    <p class="text-sm mt-2 text-gray-800">
                                        {{ __('Your email address is unverified.') }}

                                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            {{ __('Click here to re-send the verification email.') }}
                                        </button>
                                    </p>

                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-2 font-medium text-sm text-green-600">
                                            {{ __('A new verification link has been sent to your email address.') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        {{-- <!-- Employment Information Section -->
                        <div class="col-span-2">
                            <h3 class="text-lg font-semibold text-gray-900 mt-3">Employment Information</h3>
                        </div> --}}

                         <!-- Position and Units Row -->
                         <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <x-input-label for="position" :value="__('Position')" class="text-base" />
                                <select id="position" name="position" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="Part-Time" {{ old('position', $user->position) === 'Part-Time' ? 'selected' : '' }}>Part-Time</option>
                                    <option value="Part-Time-FullTime" {{ old('position', $user->position) === 'Part-Time-FullTime' ? 'selected' : '' }}>Part-Time (Full-Time)</option>
                                    <option value="Permanent-Temporary" {{ old('position', $user->position) === 'Permanent-Temporary' ? 'selected' : '' }}>Permanent (Temporary)</option>
                                    <option value="Permanent-FullTime" {{ old('position', $user->position) === 'Permanent-FullTime' ? 'selected' : '' }}>Permanent (Full-Time)</option>
                                    <option value="Dean" {{ old('position', $user->position) === 'Dean' ? 'selected' : '' }}>Dean</option>
                                    <option value="Program-Head" {{ old('position', $user->position) === 'Program-Head' ? 'selected' : '' }}>Program Head</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('position')" />
                            </div>

                            <div class="col-span-1">
                                <x-input-label for="units" :value="__('Teaching Units')" class="text-base" />
                                <x-text-input id="units" name="units" type="number" class="mt-1 block w-full" :value="old('units', $user->units)" autocomplete="units" />
                                <x-input-error class="mt-2" :messages="$errors->get('units')" />
                                <div id="units-warning" class="mt-2 text-sm text-amber-600 hidden">
                                    {{ __('Note: Part-Time faculty members are required to specify their teaching units.') }}
                                </div>
                            </div>
                        </div>

                        <!-- School Information Section -->
                        {{-- <div class="col-span-2">
                            <h3 class="text-lg font-semibold text-gray-900 mt-3">School Information</h3>
                        </div> --}}

                        <!-- Department and Campus Row -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <x-input-label for="campus_id" :value="__('Campus')" />
                                <select id="campus_id" name="campus_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                    @if($user->user_type === 'Admin' && is_null($user->campus_id) ||
                                        $user->user_type === 'Program-Head' && is_null($user->campus_id) || 
                                        $user->user_type === 'Dean' && is_null($user->campus_id)) disabled @endif required>
                                    <option value="" disabled>Select a campus</option>
                                    @foreach($campuses as $campus)
                                        <option value="{{ $campus->id }}" {{ old('campus_id', $user->campus_id) == $campus->id ? 'selected' : '' }}>{{ $campus->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('campus_id')" />
                            </div>

                            <div class="col-span-1">
                                <x-input-label for="department_id" :value="__('College (Department)')" />
                                <select id="department_id" name="department_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                    @if($user->user_type === 'Admin' && is_null($user->campus_id) ||
                                        $user->user_type === 'Program-Head' && is_null($user->campus_id) || 
                                        $user->user_type === 'Dean' && is_null($user->campus_id)) disabled @endif required>
                                    <option value="" disabled>Select a College</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('department_id')" />
                            </div>
                        </div>
                        <!-- Program Row -->
                        <div class="col-span-1">
                            <x-input-label for="program_id" :value="__('Mother Unit (Program)')" class="text-lg font-semibold" />
                            <select id="program_id" name="program_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                @if($user->user_type === 'Admin' && is_null($user->campus_id) || 
                                    $user->user_type === 'Program-Head' && is_null($user->campus_id) || 
                                    $user->user_type === 'Dean' && is_null($user->campus_id)) disabled @endif required>
                                <option value="" disabled>Select a program</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('program_id')" />
                        </div>

                        <!-- Sub Programs Row CSS Alignment-->
                        <style>
                            #sub-programs-container {
                                margin-top: -1px;
                            }
                            .remove-sub-program {
                                background-color: transparent;
                                border: none;
                                cursor: pointer;
                                font-weight: bold;
                            }
                            .remove-sub-program:hover {
                                color: #e3342f; /* Darker red for hover */
                            }
                        </style>

                        <div class="col-span-1">
                            <x-input-label for="sub_programs" :value="__('All Programs Taught')" class="text-lg font-semibold"/>
                            <div id="sub-programs-container" class="space-y-1">
                                @foreach($user->subPrograms as $subProgram)
                                    <div class="flex items-center space-x-2">
                                        <select name="sub_program_ids[]" class="flex-1 mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" style="max-height: 200px; overflow-y: auto;">
                                            <option value="" disabled>Select a Program</option>
                                            @foreach($programs as $program)
                                                <option value="{{ $program->id }}" {{ $subProgram->program_id == $program->id ? 'selected' : '' }}>
                                                    {{ $program->department->campus->name }} - {{ $program->department->name }} - {{ $program->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="text-red-500 hover:text-red-700 remove-sub-program">
                                            Remove
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-sub-program" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">
                                Add Sub Program
                            </button>
                        </div>

                        <style>
                            select[name="sub_program_ids[]"] {
                                max-height: 200px;
                            }
                            select[name="sub_program_ids[]"] option {
                                padding: 8px;
                            }
                            /* For webkit browsers like Chrome/Safari */
                            select[name="sub_program_ids[]"]::-webkit-scrollbar {
                                width: 8px;
                            }
                            select[name="sub_program_ids[]"]::-webkit-scrollbar-track {
                                background: #f1f1f1;
                            }
                            select[name="sub_program_ids[]"]::-webkit-scrollbar-thumb {
                                background: #888;
                                border-radius: 4px;
                            }
                            select[name="sub_program_ids[]"]::-webkit-scrollbar-thumb:hover {
                                background: #555;
                            }
                        </style>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const subProgramsContainer = document.getElementById('sub-programs-container');
                                const addSubProgramButton = document.getElementById('add-sub-program');

                                function addRemoveListener(button) {
                                    button.addEventListener('click', function() {
                                        button.parentElement.remove();
                                    });
                                }

                                addSubProgramButton.addEventListener('click', function() {
                                    const subProgramDiv = document.createElement('div');
                                    subProgramDiv.classList.add('flex', 'items-center', 'mt-2');

                                    subProgramDiv.innerHTML = `
                                        <select name="sub_program_ids[]" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" style="max-height: 200px; overflow-y: auto;">
                                            <option value="" disabled>Select a sub-program</option>
                                            @foreach($programs as $program)
                                                <option value="{{ $program->id }}">{{ $program->department->campus->name }} - {{ $program->department->name }} - {{ $program->name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="ml-2 text-red-500 remove-sub-program">
                                            Remove
                                        </button>
                                    `;

                                    subProgramsContainer.appendChild(subProgramDiv);
                                    addRemoveListener(subProgramDiv.querySelector('.remove-sub-program'));
                                });

                                document.querySelectorAll('.remove-sub-program').forEach(addRemoveListener);
                            });
                        </script>
                        
                        {{-- <!-- Sub Program Row -->
                        <div class="col-span-1">
                            <x-input-label for="sub_program_id" :value="__('Sub Program')" class="text-lg font-semibold"/>
                            <select id="sub_program_id" name="sub_program_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                @if($user->user_type === 'Admin' && is_null($user->campus_id) || 
                                    $user->user_type === 'Program-Head' && is_null($user->campus_id) || 
                                    $user->user_type === 'Dean' && is_null($user->campus_id)) disabled @endif>
                                <option value="" selected>Select a sub-program</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ old('sub_program_id', $subProgram->program_id ?? '') == $program->id ? 'selected' : '' }}>
                                        {{ $program->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('sub_program_id')" />
                        </div> --}}

                        <!-- Role Information Section -->
                        {{-- <div class="col-span-2">
                            <h3 class="text-lg font-semibold text-gray-900 mt-3">Role Information</h3>
                        </div> --}}

                        <!-- User Type Section -->
                        <div class="col-span-2 grid grid-cols-2 gap-4" x-data="{ userType: '{{ old('user_type', $user->user_type) }}' }">
                            <div>
                                <x-input-label for="user_type" :value="__('User Type')" />
                                <select id="user_type" name="user_type" 
                                    x-model="userType"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                    required>
                                    @if(!($user->user_type === 'Admin' && is_null($user->campus_id) ||
                                        $user->user_type === 'Program-Head' && is_null($user->campus_id) || 
                                        $user->user_type === 'Dean' && is_null($user->campus_id)))
                                    <option value="Faculty" {{ old('user_type', $user->user_type) === 'Faculty' ? 'selected' : '' }}>Faculty</option>
                                    @endif
                                    <option value="Admin" {{ old('user_type', $user->user_type) === 'Admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="Dean" {{ old('user_type', $user->user_type) === 'Dean' ? 'selected' : '' }}>Dean</option>
                                    <option value="Program-Head" {{ old('user_type', $user->user_type) === 'Program-Head' ? 'selected' : '' }}>Program Head</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('user_type')" />
                                
                                <template x-if="userType === 'Admin'">
                                    <p class="text-sm text-gray-600 mt-2">{{ __('Always use your Admin-ID when switching from Faculty to Admin.') }}</p>
                                </template>
                                <template x-if="userType === 'Faculty'">
                                    <p class="text-sm text-gray-600 mt-2">{{ __('You are now in Faculty user type.') }}</p>
                                </template>
                                <template x-if="userType === 'Program-Head'">
                                    <p class="text-sm text-gray-600 mt-2">{{ __('You are now in Program Head user type.') }}</p>
                                </template>
                                <template x-if="userType === 'Dean'">
                                    <p class="text-sm text-gray-600 mt-2">{{ __('You are now in Dean user type.') }}</p>
                                </template>
                            </div>

                            <!-- Role-specific ID fields -->
                            <div>
                                <template x-if="userType === 'Admin'">
                                    <div>
                                        <x-input-label for="admin_id" :value="__('Admin ID')" />
                                        <x-text-input id="admin_id" name="admin_id" type="text" class="mt-1 block w-full" :value="old('admin_id', $user->admin_id_registered)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('admin_id')" />
                                        <p class="text-sm text-gray-600 mt-2">{{ __('Save your Admin-ID for future use when switching from Admin to Faculty.') }}</p>
                                    </div>
                                </template>

                                <template x-if="userType === 'Program-Head'">
                                    <div>
                                        <x-input-label for="program_head_id" :value="__('Program Head ID')" />
                                        <x-text-input id="program_head_id" name="program_head_id" type="text" class="mt-1 block w-full" :value="old('program_head_id', $user->program_head_id)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('program_head_id')" />
                                        <p class="text-sm text-gray-600 mt-2">{{ __('Save your Program Head ID for future use when switching roles.') }}</p>
                                    </div>
                                </template>

                                <template x-if="userType === 'Dean'">
                                    <div>
                                        <x-input-label for="dean_id" :value="__('Dean ID')" />
                                        <x-text-input id="dean_id" name="dean_id" type="text" class="mt-1 block w-full" :value="old('dean_id', $user->dean_id)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('dean_id')" />
                                        <p class="text-sm text-gray-600 mt-2">{{ __('Save your Dean ID for future use when switching roles.') }}</p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Picture Section -->
                    <div class="ml-8 flex-shrink-0">
                        <div class="profile-picture-section flex flex-col items-center">
                            <x-input-label for="profile_picture" :value="__('Profile Picture')" class="mb-2 text-lg font-semibold" />
                            <div class="mt-2 flex items-center justify-center w-48 h-48 bg-gray-100 rounded-full overflow-hidden shadow-lg">
                                @if ($user->profile_picture)
                                    @if (str_contains($user->profile_picture, 'http'))
                                        <img src="{{ $user->profile_picture }}" alt="Profile Picture" class="w-full h-full object-cover" id="preview-image">
                                    @else
                                        <img src="{{ url('/profile_pictures/' . basename($user->profile_picture)) }}" alt="Profile Picture" class="w-full h-full object-cover" id="preview-image">
                                    @endif
                                @else
                                    <svg class="w-full h-full text-gray-300" fill="currentColor" viewBox="0 0 24 24" id="default-image">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                @endif
                            </div>
                            <div class="mt-4 w-full">
                                <label for="profile_picture" class="flex flex-col items-center px-4 py-2 bg-white text-blue-500 rounded-lg shadow-lg tracking-wide uppercase border border-blue-500 cursor-pointer hover:bg-blue-500 hover:text-white transition duration-300 ease-in-out">
                                    <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                    </svg>
                                    <span class="mt-2 text-base leading-normal" id="file-name">Select a file</span>
                                    <input type='file' id="profile_picture" name="profile_picture" class="hidden" accept="image/*" />
                                </label>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
                        </div>
                    </div>
                </div>

                <!-- Save Changes Section -->
                <div class="flex items-center justify-between mt-8 bg-white p-6 rounded-lg">
                    <div class="flex items-center gap-4">
                        <x-primary-button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 focus:ring-offset-blue-200 transition ease-in duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            {{ __('Save Changes') }}
                        </x-primary-button>

                        @if (session('status') === 'profile-updated' && !$errors->any())
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform scale-90"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="opacity-100 transform scale-100"
                                x-transition:leave-end="opacity-0 transform scale-90"
                                x-init="setTimeout(() => show = false, 6000)"
                                class="text-sm text-green-600 bg-green-100 px-4 py-2 rounded-full font-semibold"
                            >
                                <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('Profile Updated Successfully') }}
                            </p>
                        @endif

                        @if ($errors->any() && session('status') !== 'profile-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform scale-90"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="opacity-100 transform scale-100"
                                x-transition:leave-end="opacity-0 transform scale-90"
                                x-init="setTimeout(() => show = false, 6000)"
                                class="text-sm text-red-600 bg-red-100 px-4 py-2 rounded-full font-semibold"
                            >
                                <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('There was an error updating the profile.') }}
                            </p>
                        @endif

                        @if ($noActiveClearance && $user->user_type !== 'Admin')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform scale-90"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="opacity-100 transform scale-100"
                                x-transition:leave-end="opacity-0 transform scale-90"
                                x-init="setTimeout(() => show = false, 7000)"
                                class="text-sm text-red-600 bg-red-100 px-4 py-2 rounded-full font-semibold"
                            >
                                <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('No active clearance found. Please contact your administrator or ') }}
                                <a href="{{ route('faculty.views.clearances') }}" class="text-blue-600 hover:text-blue-800 underline">
                                    {{ __('click here to get a copy of your clearance') }}
                                </a>.
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Scripts -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const departmentSelect = document.getElementById('department_id');
                        const programSelect = document.getElementById('program_id');
                        const programOptions = programSelect.querySelectorAll('option');
                        const positionSelect = document.getElementById('position');
                        const unitsInput = document.getElementById('units');
                        const unitsWarning = document.getElementById('units-warning');
                
                        function updateProgramOptions() {
                            const selectedDepartmentId = departmentSelect.value;
                            programOptions.forEach(option => {
                                if (option.value === "" || option.dataset.department === selectedDepartmentId) {
                                    option.style.display = '';
                                } else {
                                    option.style.display = 'none';
                                }
                            });
                            programSelect.value = "{{ old('program_id', $user->program_id) }}";
                        }

                        function checkPosition() {
                            if (positionSelect.value === 'Part-Time' || positionSelect.value === 'Part-Time-FullTime') {
                                unitsWarning.classList.remove('hidden');
                                unitsInput.setAttribute('required', 'required');
                            } else {
                                unitsWarning.classList.add('hidden');
                                unitsInput.removeAttribute('required');
                            }
                        }
                
                        departmentSelect.addEventListener('change', updateProgramOptions);
                        positionSelect.addEventListener('change', checkPosition);
                        updateProgramOptions();
                        checkPosition();
                    });

                    document.getElementById('profile_picture').addEventListener('change', function(e) {
                        var fileName = e.target.files[0].name;
                        document.getElementById('file-name').textContent = fileName;

                        var reader = new FileReader();
                        reader.onload = function(event) {
                            document.getElementById('preview-image').src = event.target.result;
                            document.getElementById('default-image').style.display = 'none';
                            document.getElementById('preview-image').style.display = 'block';
                        }
                        reader.readAsDataURL(e.target.files[0]);
                    });

                    document.addEventListener('DOMContentLoaded', function () {
                        @if (session('status') === 'profile-updated')
                            showNotificationModern('{{ __('Profile updated successfully.') }}', 'success');
                        @elseif ($errors->any())
                            showNotificationModern('{{ __('There was an error updating the profile.') }}', 'error');
                        @endif
                    });

                    function showNotificationModern(message, type) {
                        const notification = document.getElementById('notification');
                        const notificationMessage = document.getElementById('notificationMessage');
                        const notificationIcon = document.getElementById('notificationIcon');
            
                        notificationMessage.textContent = message;
            
                        // Reset classes
                        notification.className = 'hidden fixed top-0 right-0 m-6 p-4 rounded-lg shadow-lg transition-all duration-500 transform translate-x-full z-50';
                        notificationIcon.innerHTML = '';
            
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
                            }, 500);
                        }, 2000);
                    }
                </script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const oldCampusId = "{{ old('campus_id', $user->campus_id) }}";
                        const oldDepartmentId = "{{ old('department_id', $user->department_id) }}";
                        const oldProgramId = "{{ old('program_id', $user->program_id) }}";
                
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
            </form>
        </div>
    </div>
</section>