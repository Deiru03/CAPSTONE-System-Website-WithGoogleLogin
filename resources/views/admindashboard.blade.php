<x-admin-layout>
    <x-slot name="header">
        {{ __('Dashboard') }} <!-- Set the header content here -->
    </x-slot>

    <!-- Existing Content -->
    <div class="bg-white overflow-hidden">
        <div class="p-1 text-gray-900">
            {{ __("") }}
        </div>
    </div>
    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Faculty Card -->
                <a href="{{ route('admin.views.faculty') }}" class="bg-green-500 text-white p-4 rounded-lg shadow relative hover:bg-green-600 transition duration-300 ease-in-out cursor-pointer transform hover:scale-105 hover:shadow-lg">
                    <div>
                        <h3 class="text-lg font-bold">Total Users</h3>
                        <p class="text-2xl">{{ $TotalUser }}</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50 transition-transform duration-300 ease-in-out transform hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </a>
                <!-- Clearance Card -->
                <a href="{{ route('admin.views.clearances') }}" class="bg-purple-500 text-white p-4 rounded-lg shadow relative hover:bg-purple-600 transition duration-300 ease-in-out cursor-pointer transform hover:scale-105 hover:shadow-lg">
                    <div>
                        <h3 class="text-lg font-bold">Checklist Created</h3>
                        <p class="text-2xl">{{ $clearanceChecklist }}</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50 transition-transform duration-300 ease-in-out transform hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </a>
                <!-- My Files Card -->
                <a href="{{ route('admin.views.myFiles') }}" class="bg-blue-500 text-white p-4 rounded-lg shadow relative hover:bg-blue-600 transition duration-300 ease-in-out cursor-pointer transform hover:scale-105 hover:shadow-lg">
                    <div>
                        <h3 class="text-lg font-bold">My Files</h3>
                        <p class="text-2xl">10</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50 transition-transform duration-300 ease-in-out transform hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </a>
                <!-- Shared Files Card -->
                <a href="{{ route('admin.views.submittedReports') }}" class="bg-orange-500 text-white p-4 rounded-lg shadow relative hover:bg-orange-600 transition duration-300 ease-in-out cursor-pointer transform hover:scale-105 hover:shadow-lg">
                    <div>
                        <h3 class="text-lg font-bold">Submitted Reports</h3>
                        <p class="text-2xl">{{ $submittedReportsCount ?? 0 }}</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50 transition-transform duration-300 ease-in-out transform hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Example Card 1 -->
                <a href="" class="bg-emerald-500 text-white p-4 rounded-lg shadow relative hover:bg-emerald-600 transition duration-300 ease-in-out cursor-pointer transform hover:scale-105 hover:shadow-lg">
                    <div>
                        <h3 class="text-lg font-bold">Profile</h3>
                        <p class="text-2xl"></p>
                        
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50 transition-transform duration-300 ease-in-out transform hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <!-- SVG Path -->
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </a>

                <!-- Example Card 2 -->
                <a href="{{ route('admin.clearance.manage') }}" class="bg-fuchsia-500 text-white p-4 rounded-lg shadow relative hover:bg-fuchsia-600 transition duration-300 ease-in-out cursor-pointer transform hover:scale-105 hover:shadow-lg">
                    <div>
                        <h3 class="text-lg font-bold">Manage Clearance</h3>
                        <p class="text-2xl"></p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50 transition-transform duration-300 ease-in-out transform hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </a>

                {{-- <a href="{{route('admin.clearance.manage')}}" class="bg-orange-500 text-white p-4 rounded-lg shadow relative hover:bg-orange-600 transition duration-300 ease-in-out cursor-pointer transform hover:scale-105 hover:shadow-lg">
                    <div>
                        <h3 class="text-lg font-bold">Share Clearances</h3>
                        <p class="text-2xl"></p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50 transition-transform duration-300 ease-in-out transform hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                    </svg>
                </a> --}}

                <!-- Add more cards as needed -->
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- 
         
                    --}}
                <!-- Clearance Status -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold mb-4">Clearance Status</h3>
                    <div class="flex justify-between items-center mb-4">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-yellow-500">{{ $clearancePending }}</div>
                            <div class="text-sm text-gray-600">Pending</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-500">{{ $clearanceComplete }}</div>
                            <div class="text-sm text-gray-600">Complete</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-orange-700">{{ $clearanceReturn }}</div>
                            <div class="text-sm text-gray-600">Return</div>
                        </div>
                    </div>
                    <div class="relative pt-1">
                        <div class="flex mb-2 items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-yellow-600 bg-yellow-200">
                                    Pending
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-semibold inline-block text-yellow-600">
                                    {{ number_format(($clearancePending / ($clearancePending + $clearanceComplete + $clearanceReturn)) * 100, 1) }}%
                                </span>
                            </div>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-yellow-200">
                            <div style="width:{{ ($clearancePending / ($clearancePending + $clearanceComplete + $clearanceReturn)) * 100 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-yellow-500"></div>
                        </div>
                    </div>
                </div>

                <!-- Faculty Status -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold mb-4">Faculty Status</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-1/4 text-sm font-medium text-gray-600">Permanent</div>
                            <div class="w-3/4">
                                <div class="relative pt-1">
                                    <div class="overflow-hidden h-2 text-xs flex rounded bg-blue-200">
                                        <div style="width:{{ ($facultyPermanent / ($facultyPermanent + $facultyPartTime + $facultyTemporary)) * 100 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-1/4 text-right text-sm font-medium text-gray-600">{{ $facultyPermanent }}</div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-1/4 text-sm font-medium text-gray-600">Part-Timer</div>
                            <div class="w-3/4">
                                <div class="relative pt-1">
                                    <div class="overflow-hidden h-2 text-xs flex rounded bg-green-200">
                                        <div style="width:{{ ($facultyPartTime / ($facultyPermanent + $facultyPartTime + $facultyTemporary)) * 100 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-1/4 text-right text-sm font-medium text-gray-600">{{ $facultyPartTime }}</div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-1/4 text-sm font-medium text-gray-600">Temporary</div>
                            <div class="w-3/4">
                                <div class="relative pt-1">
                                    <div class="overflow-hidden h-2 text-xs flex rounded bg-red-200">
                                        <div style="width:{{ ($facultyTemporary / ($facultyPermanent + $facultyPartTime + $facultyTemporary)) * 100 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-1/4 text-right text-sm font-medium text-gray-600">{{ $facultyTemporary }}</div>
                        </div>
                    </div>
                </div>

                <!-- User Type Distribution -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold mb-4">User Types</h3>
                    <div class="flex items-center justify-center space-x-8 mb-6">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-100 text-blue-600 text-2xl font-bold mb-2">
                                {{ $facultyAdmin }}
                            </div>
                            <p class="text-sm font-medium text-gray-600">Admin</p>
                        </div>
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 text-green-600 text-2xl font-bold mb-2">
                                {{ $facultyFaculty }}
                            </div>
                            <p class="text-sm font-medium text-gray-600">Faculty</p>
                        </div>
                    </div>
                    <div class="mt-6">
                        <div class="bg-gray-200 h-4 rounded-full overflow-hidden">
                            @php
                                $totalUsers = $facultyAdmin + $facultyFaculty;
                                $adminPercentage = ($facultyAdmin / $totalUsers) * 100;
                            @endphp
                            <div class="h-full bg-blue-600" style="width: {{ $adminPercentage }}%"></div>
                        </div>
                        <div class="flex justify-between mt-2 text-sm text-gray-600">
                            <span>{{ number_format($adminPercentage, 1) }}% Admin</span>
                            <span>{{ number_format(100 - $adminPercentage, 1) }}% Faculty</span>
                        </div>
                    </div>
                </div>

                    <!-- Overall Analytics -->
                    <div class="bg-white p-6 rounded-lg shadow-lg col-span-2">
                    <h3 class="text-xl font-bold mb-4">Overall Analytics</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-blue-100 p-4 rounded-lg text-center">
                            <div class="text-3xl font-bold text-blue-600">{{ $TotalUser }}</div>
                            <div class="text-sm text-gray-600">Total Users</div>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg text-center">
                            <div class="text-3xl font-bold text-green-600">{{ $clearanceTotal }}</div>
                            <div class="text-sm text-gray-600">Total Clearances</div>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded-lg text-center">
                            <div class="text-3xl font-bold text-yellow-600">{{ $clearanceChecklist }}</div>
                            <div class="text-sm text-gray-600">Clearance Checklists</div>
                        </div>
                        <div class="bg-purple-100 p-4 rounded-lg text-center">
                            <div class="text-3xl font-bold text-purple-600">{{ $facultyAdmin + $facultyFaculty }}</div>
                            <div class="text-sm text-gray-600">Total Faculty</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Add New Content Here -->
            
            {{-- 
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Example Status Table 1 -->
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-bold">Profile Status</h3>
                    <table class="min-w-full mt-4">
                        <thead>
                            <tr>
                                <th class="text-left">Status</th>
                                <th class="text-left">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-blue-500">Active</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-red-500">Inactive</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Example Status Table 2 -->
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-bold">Messages Status</h3>
                    <table class="min-w-full mt-4">
                        <thead>
                            <tr>
                                <th class="text-left">Type</th>
                                <th class="text-left">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-green-500">Read</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-yellow-500">Unread</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>  --}}
            <!-- End of New Content -->

            
            <!-- End of Existing Content -->
        </div>
    </div>
</x-admin-layout>
