<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Test Page') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">  
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium">Test Page</h3>
                    <p class="mt-2">This is a test page.</p>
                </div>
            </div>
        </div>
    </div>
    @vite(['resources/js/facult-js/test-page.js']) <!-- Include the JS file -->
</x-app-layout>