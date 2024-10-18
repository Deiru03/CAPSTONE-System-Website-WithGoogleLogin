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

                <div class="grid grid-cols-2 gap-4">
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

                <div class="flex items-center gap-4 mt-6">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'profile-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </div>

        <div class="profile-picture-section">
            <x-input-label for="profile_picture" :value="__('Profile Picture')" />
            <input type="file" id="profile_picture" name="profile_picture" class="mt-1 block w-full">
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />

            @if ($user->profile_picture)
                <img src="{{ $user->profile_picture }}" alt="Profile Picture" class="mt-2 profile-picture-preview">
            @endif
        </div>
    </div>
</section>