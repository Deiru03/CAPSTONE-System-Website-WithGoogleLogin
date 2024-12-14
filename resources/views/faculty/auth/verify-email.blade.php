<x-guest-layout>
    <div class="mb-4 text-sm bg-white rounded-lg shadow-md p-6 border-l-4 border-indigo-500">
        <h2 class="text-xl font-bold text-indigo-600 mb-3">{{ __('Welcome to ClearVault! 🎉') }}</h2>
        <div class="text-gray-600">
            {{ __('To ensure the security of your account, we need to verify your email address. We\'ve sent a verification link to the email address you provided.') }}
        </div>

        <div class="bg-indigo-50 rounded-lg p-4 mt-4 border border-indigo-100">
            <h3 class="font-bold text-indigo-700 mb-2">📧 How to Find Your Verification Email:</h3>
            <ol class="space-y-3 text-gray-700 list-decimal list-inside">
                <li class="flex items-center w-full whitespace-nowrap" aria-label="Check your Primary Inbox">
                    <span class="bg-indigo-100 rounded-full p-1 mr-2">1️⃣</span>
                    Check your <span class="font-bold text-indigo-600 mx-1">Primary Inbox</span> for an email from ClearVault
                </li>
                <li class="flex items-center">
                    <span class="bg-indigo-100 rounded-full p-1 mr-2">2️⃣</span>
                    If not found, look in your <span class="font-bold text-indigo-600 mx-1">Spam/Junk folder</span>
                </li>
                <li class="flex items-center">
                    <span class="bg-indigo-100 rounded-full p-1 mr-2">3️⃣</span>
                    Click the blue verification link in the email
                </li>
            </ol>
        </div>

        <div class="mt-4 text-gray-600">
            <span class="font-bold">⏰ Tip:</span> The verification link should arrive within a few minutes. If you still can't find it, you can request a new one below.
        </div>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm bg-green-50 text-green-700 p-4 rounded-lg border border-green-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ __('We\'ve sent a new verification link to your email address. Please check both your inbox and spam folder. The email should arrive within a few minutes.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button class="flex items-center transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg hover:bg-indigo-700">
                    <svg class="w-4 h-4 mr-2 transition-transform duration-300 hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    {{ __('Send Another Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-md transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
