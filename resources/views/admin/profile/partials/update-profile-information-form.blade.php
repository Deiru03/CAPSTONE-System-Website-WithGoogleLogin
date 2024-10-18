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

    <div class="profile-container" style="max-width: 1200px; margin: 0 auto;">
        <div class="profile-form">
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                @csrf
                @method('patch')

                <div class="flex items-start">
                    <div class="flex-grow grid grid-cols-2 gap-4">
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

                        <div>
                            <x-input-label for="user_type" :value="__('User Type')" />
                            <x-text-input id="user_type" name="user_type" type="text" class="mt-1 block w-full" :value="old('user_type', $user->user_type)" required autocomplete="user_type" disabled readonly />
                            <x-input-error class="mt-2" :messages="$errors->get('user_type')" />
                            <p class="text-sm text-gray-600 mt-2">{{ __('Only Admin can change your user type.') }}</p>
                        </div>

                        <div>
                            <x-input-label for="program" :value="__('Program')" />
                            <x-text-input id="program" name="program" type="text" class="mt-1 block w-full" :value="old('program', $user->program)" required autocomplete="program" />
                            <x-input-error class="mt-2" :messages="$errors->get('program')" />
                        </div>

                        <div>
                            <x-input-label for="position" :value="__('Position')" />
                            <select id="position" name="position" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="Permanent" {{ old('position', $user->position) === 'Permanent' ? 'selected' : '' }}>Permanent</option>
                                <option value="Temporary" {{ old('position', $user->position) === 'Temporary' ? 'selected' : '' }}>Temporary</option>
                                <option value="Part-Timer" {{ old('position', $user->position) === 'Part-Timer' ? 'selected' : '' }}>Part-Timer</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('position')" />
                        </div>

                        <div>
                            <x-input-label for="units" :value="__('Units')" />
                            <x-text-input id="units" name="units" type="number" class="mt-1 block w-full" :value="old('units', $user->units)" autocomplete="units" />
                            <x-input-error class="mt-2" :messages="$errors->get('units')" />
                        </div>
                    </div>

                    <div class="ml-8 flex-shrink-0">
                        <div class="profile-picture-section flex flex-col items-center">
                            <x-input-label for="profile_picture" :value="__('Profile Picture')" class="mb-2 text-lg font-semibold" />
                            <div class="mt-2 flex items-center justify-center w-48 h-48 bg-gray-100 rounded-full overflow-hidden shadow-lg">
                                @if ($user->profile_picture)
                                    <img src="{{ $user->profile_picture }}" alt="Profile Picture" class="w-full h-full object-cover" id="preview-image">
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

                    <script>
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
                    </script>
                </div>

                <div class="flex items-center justify-between mt-8 bg-white p-6 rounded-lg">
                    <div class="flex items-center gap-4">
                        <x-primary-button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 focus:ring-offset-blue-200 transition ease-in duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            {{ __('Save Changes') }}
                        </x-primary-button>

                        @if (session('status') === 'profile-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform scale-90"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="opacity-100 transform scale-100"
                                x-transition:leave-end="opacity-0 transform scale-90"
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-green-600 bg-green-100 px-4 py-2 rounded-full font-semibold"
                            >
                                <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('Profile Updated Successfully') }}
                            </p>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>