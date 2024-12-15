<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clearances') }}
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-indigo-200">
                <div class="p-8 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-indigo-700 border-b-2 border-indigo-200 pb-2">Clearances Management</h3>
                    @if($userClearance)
                        <div class="flex items-center mb-6 bg-green-100 p-4 rounded-lg shadow-md">
                            <svg class="w-8 h-8 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-lg font-semibold text-green-700">You have an active clearance.</p>
                                <p class="text-sm text-green-600">Here you can view and manage your clearances efficiently.</p>
                            </div>
                        </div>
                        <div class="bg-white p-2">
                            {{-- <a href="{{ route('faculty.generateClearanceReport') }}" class="inline-flex items-center px-4 py-2 {{ $userInfo->clearances_status === 'complete' ? 'bg-green-500 hover:bg-green-600' : 'bg-yellow-500 hover:bg-yellow-600' }} text-white text-sm font-medium rounded-md transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                Generate Clearance Slip
                            </a> --}}
                            {{-- <span class="mx-2"></span>
                            <a href="{{ route('faculty.clearanceChecklist', $userClearance->shared_clearance_id) }}" target="_blank" class="inline-flex items-center px-4 py-2 {{ $userInfo->clearances_status === 'complete' ? 'bg-green-500 hover:bg-green-600' : 'bg-yellow-500 hover:bg-yellow-600' }} text-white text-sm font-medium rounded-md transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 7H7v6h6V7z" />
                                    <path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v10a2 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v10H5V5z" clip-rule="evenodd" />
                                </svg>
                                Download My Checklist PDF
                            </a> --}}
                            <span class="mx-2"></span>
                            <a href="{{ route('faculty.clearances.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-md transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                View Existing Checklists
                            </a>
                        </div>
                        {{-- TESTING --}}
                        {{-- @include('faculty.views.clearances.clearance-show', ['userClearance' => $userClearance, 'isInclude' => true]) --}}
                    @else
                        <div class="flex items-center mb-6 bg-blue-100 p-4 rounded-lg shadow-md">
                            <svg class="w-8 h-8 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-lg font-semibold text-blue-700">No active clearance found.</p>
                                <p class="text-sm text-blue-600">To get started, please obtain a copy of your clearance from the shared clearances list.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>            
        </div>
    </div>
    @if($userClearance)
        {{-- @include('faculty.views.clearances.clearance-show', ['userClearance' => $userClearance, 'isInclude' => true]) --}}
        @include('faculty.views.clearances.clearance-show', ['userClearance' => $userClearance, 'isInclude' => true, 'bodyClass' => 'is-clearance-show'])
    @else
        <div class="mb-6">
            <div class="container mx-auto px-8 py-12">
                <div class="text-center">
                    <i class="fas fa-file-alt text-6xl text-indigo-500 mb-6"></i>
                    <h2 class="text-4xl font-bold mb-4 text-indigo-800">
                        No Clearances Available
                    </h2>
                    <p class="text-xl text-gray-700 mb-8">
                        It looks like you haven't obtained a copy of your clearance yet.
                    </p>
                    <a href="{{ route('faculty.clearances.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-full transition duration-300 ease-in-out transform hover:scale-105">
                        Get Your Clearance
                    </a>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
