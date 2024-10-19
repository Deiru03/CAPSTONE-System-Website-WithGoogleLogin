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

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Clearance Status -->
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <h3 class="text-lg font-bold mb-2">Clearance Status</h3>
                    <div class="h-32">
                        <canvas id="clearanceStatusChart"></canvas>
                    </div>
                    <div class="mt-2 text-sm text-gray-600 flex justify-between">
                        <span>Pending: {{ $clearancePending }}</span>
                        <span>Complete: {{ $clearanceComplete }}</span>
                        <span>Return: {{ $clearanceReturn }}</span>
                    </div>
                </div>

                <!-- Faculty Status -->
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <h3 class="text-lg font-bold mb-2">Faculty Status</h3>
                    <div class="h-32">
                        <canvas id="facultyStatusChart"></canvas>
                    </div>
                    <div class="mt-2 text-sm text-gray-600 flex justify-between">
                        <span>Permanent: {{ $facultyPermanent }}</span>
                        <span>Part-Time: {{ $facultyPartTime }}</span>
                        <span>Temporary: {{ $facultyTemporary }}</span>
                    </div>
                </div>

                <!-- User Type Distribution -->
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <h3 class="text-lg font-bold mb-2">User Types</h3>
                    <div class="h-32">
                        <canvas id="userTypeChart"></canvas>
                    </div>
                    <div class="mt-2 text-sm text-gray-600 flex justify-between">
                        <span>Admin: {{ $facultyAdmin }}</span>
                        <span>Faculty: {{ $facultyFaculty }}</span>
                    </div>
                </div>

                <!-- Overall Analytics -->
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <h3 class="text-lg font-bold mb-2">Overall Analytics</h3>
                    <div class="h-32">
                        <canvas id="overallAnalyticsChart"></canvas>
                    </div>
                    <div class="mt-2 text-sm text-gray-600 grid grid-cols-2 gap-2">
                        <span>Users: {{ $TotalUser }}</span>
                        <span>Clearances: {{ $clearanceTotal }}</span>
                        <span>Checklists: {{ $clearanceChecklist }}</span>
                        <span>Faculty: {{ $facultyAdmin + $facultyFaculty }}</span>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Clearance Status Chart
                    new Chart(document.getElementById('clearanceStatusChart'), {
                        type: 'doughnut',
                        data: {
                            labels: ['Pending', 'Complete', 'Return'],
                            datasets: [{
                                data: [{{ $clearancePending }}, {{ $clearanceComplete }}, {{ $clearanceReturn }}],
                                backgroundColor: ['#FCD34D', '#10B981', '#F97316']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });

                    // Faculty Status Chart
                    new Chart(document.getElementById('facultyStatusChart'), {
                        type: 'bar',
                        data: {
                            labels: ['Permanent', 'Part-Timer', 'Temporary'],
                            datasets: [{
                                data: [{{ $facultyPermanent }}, {{ $facultyPartTime }}, {{ $facultyTemporary }}],
                                backgroundColor: ['#3B82F6', '#10B981', '#EF4444']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    display: false
                                },
                                x: {
                                    display: false
                                }
                            }
                        }
                    });

                    // User Type Chart
                    new Chart(document.getElementById('userTypeChart'), {
                        type: 'pie',
                        data: {
                            labels: ['Admin', 'Faculty'],
                            datasets: [{
                                data: [{{ $facultyAdmin }}, {{ $facultyFaculty }}],
                                backgroundColor: ['#3B82F6', '#10B981']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });

                    // Overall Analytics Chart
                    new Chart(document.getElementById('overallAnalyticsChart'), {
                        type: 'polarArea',
                        data: {
                            labels: ['Users', 'Clearances', 'Checklists', 'Faculty'],
                            datasets: [{
                                data: [{{ $TotalUser }}, {{ $clearanceTotal }}, {{ $clearanceChecklist }}, {{ $facultyAdmin + $facultyFaculty }}],
                                backgroundColor: ['#3B82F6', '#10B981', '#FCD34D', '#8B5CF6']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                r: {
                                    display: false
                                }
                            }
                        }
                    });
                });
            </script>
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
