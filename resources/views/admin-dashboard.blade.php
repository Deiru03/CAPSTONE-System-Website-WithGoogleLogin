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
                        <h3 class="text-lg font-bold">Check My Faculty</h3>
                        <p class="text-2xl">{{ $managedFacultyCount }}</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50 transition-transform duration-300 ease-in-out transform hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </a>
                <!-- My Files Card -->
                <a href="{{ route('admin.views.college') }}" class="bg-blue-500 text-white p-4 rounded-lg shadow relative hover:bg-blue-600 transition duration-300 ease-in-out cursor-pointer transform hover:scale-105 hover:shadow-lg">
                    <div>
                        <h3 class="text-lg font-bold">College</h3>
                        <p class="text-2xl">{{ $collegeCount ?? 0 }}</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50 transition-transform duration-300 ease-in-out transform hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
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
                <a href="{{ route('admin.profile.edit') }}" class="bg-emerald-500 text-white p-4 rounded-lg shadow relative hover:bg-emerald-600 transition duration-300 ease-in-out cursor-pointer transform hover:scale-105 hover:shadow-lg">
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
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Clearance Status -->
                <div class="bg-white p-4 rounded-lg shadow-lg border-2 border-indigo-200">
                    <h3 class="text-lg font-bold mb-2">Clearance Status</h3>
                    <div class="h-48">
                        <canvas id="clearanceStatusChart"></canvas>
                    </div>
                    <div class="mt-2 text-sm text-gray-600 flex justify-between">
                        <span>Pending: {{ $clearancePending }}</span>
                        <span>Complete: {{ $clearanceComplete }}</span>
                        <span>In Progress: {{ $clearanceReturn }}</span>
                    </div>
                </div>

                <!-- Faculty Status -->
                <div class="bg-white p-4 rounded-lg shadow-lg border-2 border-indigo-200">
                    <h3 class="text-lg font-bold mb-2">Faculty Status</h3>
                    <div class="h-48">
                        <canvas id="facultyStatusChart"></canvas>
                    </div>
                    <div class="mt-2 text-sm text-gray-600 relative">
                        <button 
                            id="facultyButton"
                            class="w-full py-2 text-blue-500 hover:underline"
                            onmouseenter="showFacultyPopup()"
                            onmouseleave="hideFacultyPopup()"
                        >
                            View Faculty Breakdown
                        </button>
                        
                        <div 
                            id="facultyPopup"
                            class="hidden absolute left-0 top-full mt-2 bg-white border border-gray-200 rounded-lg shadow-lg p-4 z-10 w-72"
                        >
                            <div class="grid grid-cols-1 gap-2">
                                <div class="flex justify-between">
                                    <span class="font-medium">Permanent (Full-Time):</span>
                                    <span>{{ $facultyPermanentFT }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Permanent (Part-Time):</span>
                                    <span>{{ $facultyPermanentPT }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Temporary:</span>
                                    <span>{{ $facultyTemporary }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Part-Time:</span>
                                    <span>{{ $facultyPartTime }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Dean:</span>
                                    <span>{{ $usersDean }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Program Head:</span>
                                    <span>{{ $usersPH }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                function showFacultyPopup() {
                    const popup = document.getElementById('facultyPopup');
                    popup.classList.remove('hidden');
                }

                function hideFacultyPopup() {
                    const popup = document.getElementById('facultyPopup');
                    popup.classList.add('hidden');
                }
                </script>

                <!-- User Type Distribution -->
                <div class="bg-white p-4 rounded-lg shadow-lg border-2 border-indigo-200">
                    <h3 class="text-lg font-bold mb-2">User Types</h3>
                    <div class="h-48">
                        <canvas id="userTypeChart"></canvas>
                    </div>
                    <div class="mt-2 text-sm text-gray-600 flex justify-between">
                        <span>Admin: {{ $facultyAdmin }}</span>
                        <span>Dean: {{ $facultyDean }}</span>
                        <span>Program Head: {{ $facultyPH }}</span>
                        <span>Faculty: {{ $facultyFaculty }}</span>
                    </div>
                </div>

                <!-- Overall Analytics -->
                <div class="bg-white p-4 rounded-lg shadow-lg border-2 border-indigo-200">
                    <h3 class="text-lg font-bold mb-2">Overall Analytics</h3>
                    <div class="h-48">
                        <canvas id="overallAnalyticsChart"></canvas>
                    </div>
                    <div class="mt-2 text-sm text-gray-600 relative">
                        <button 
                            id="analyticsButton"
                            class="w-full py-2 text-blue-500 hover:underline"
                            onmouseenter="showAnalyticsPopup()"
                            onmouseleave="hideAnalyticsPopup()"
                        >
                            View Analytics Breakdown
                        </button>
                        
                        <!-- Tooltip/Popup Content -->
                        <div 
                            id="analyticsPopup"
                            class="hidden absolute left-0 top-full mt-2 bg-white border border-gray-200 rounded-lg shadow-lg p-4 z-10 w-72"
                        >
                            <div class="grid grid-cols-1 gap-2">
                                <div class="flex justify-between">
                                    <span class="font-medium">Users:</span>
                                    <span>{{ $TotalUser }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Clearances:</span>
                                    <span>{{ $clearanceTotal }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Checklists:</span>
                                    <span>{{ $clearanceChecklist }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Faculty:</span>
                                    <span>{{ $facultyAdmin + $facultyFaculty }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Completed Clearances (This Month):</span>
                                    <span>{{ $completedClearancesThisMonth }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">New Users (This Month):</span>
                                    <span>{{ $newUsersThisMonth }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Recent Logins (This Month):</span>
                                    <span>{{ $recentLogins }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                    function showAnalyticsPopup() {
                        const popup = document.getElementById('analyticsPopup');
                        popup.classList.remove('hidden');
                    }

                    function hideAnalyticsPopup() {
                        const popup = document.getElementById('analyticsPopup');
                        popup.classList.add('hidden');
                    }
                    </script>
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
                            labels: ['Dean', 'Program Head', 'Permanent-FullTime', 'Permanent-PartTime', 'Temporary', 'Part-Timer'],
                            datasets: [{
                                data: [{{ $usersDean }}, {{ $usersPH }}, {{ $facultyPermanentFT }}, {{ $facultyPermanentPT }}, {{ $facultyTemporary }}, {{ $facultyPartTime }}],
                                backgroundColor: ['#3B82F6', '#10B981', '#EF4444', '#F59E0B', '#8B5CF6', '#EC4899']
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
                                    beginAtZero: true,
                                    display: true
                                },
                                x: {
                                    display: true
                                }
                            }
                        }
                    });

                    // User Type Chart
                    new Chart(document.getElementById('userTypeChart'), {
                        type: 'pie',
                        data: {
                            labels: ['Admin', 'Faculty', 'Dean', 'Program Head'],
                            datasets: [{
                                data: [{{ $facultyAdmin }}, {{ $facultyFaculty }}, {{ $facultyDean }}, {{ $facultyPH }}],
                                backgroundColor: ['#3B82F6', '#10B981', '#F97316', '#8B5CF6']
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
                        type: 'line',
                        data: {
                            labels: ['Users', 'Clearances', 'Checklists', 'Faculty', 'Completed Clearances', 'New Users', 'Recent Logins'],
                            datasets: [{
                                data: [{{ $TotalUser }}, {{ $clearanceTotal }}, {{ $clearanceChecklist }}, {{ $facultyAdmin + $facultyFaculty }}, {{ $completedClearancesThisMonth }}, {{ $newUsersThisMonth }}, {{ $recentLogins }}],
                                backgroundColor: ['#3B82F6', '#10B981', '#FCD34D', '#8B5CF6', '#EC4899', '#F59E0B', '#34D399']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'right'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            if (context.raw !== null) {
                                                label += context.raw;
                                            }
                                            return label;
                                        }
                                    }
                                }
                            },
                            scales: {
                                r: {
                                    display: true
                                }
                            }
                        }
                    });
                });
            </script>
        </div>
    </div>
    <div class="py-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

             <!-- Managed Users Section -->
             <div class="mt-8 bg-white p-6 rounded-lg shadow-lg border border-gray-200 relative">
                <h3 class="text-lg font-bold mb-4">Users You Manage</h3>
                <p class="text-sm text-gray-600 mb-4">Click on a user to view and check their clearance details.</p>
                <button onclick="window.open('{{ route('admin.generateReport') }}', '_blank')" class="absolute top-4 right-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Generate Report
                </button>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($managedUsers as $user)
                        @php
                            $userClearance = $user->userClearances->first();
                            $latestUpload = $userClearance ? $userClearance->uploadedClearances
                                ->where('is_archived', false)
                                ->sortByDesc('created_at')
                                ->first() : null;
                            
                            $hasComplied = false;
                            if ($latestUpload) {
                                $feedback = $latestUpload->requirement->feedback
                                    ->where('user_id', $user->id)
                                    ->where('is_archived', false)
                                    ->first();
                                $hasComplied = $feedback && 
                                    $feedback->signature_status == 'Resubmit' && 
                                    $latestUpload->created_at > $feedback->updated_at;
                            }
                        @endphp
                        <a href="{{ route('admin.clearances.show', $user->id) }}" class="flex items-center space-x-4 p-4 rounded-lg shadow hover:bg-gray-100 transition duration-300
                            @if($hasComplied)
                                bg-blue-50
                            @elseif($user->clearances_status == 'complete')
                                bg-green-50
                            @elseif($user->clearances_status == 'pending') 
                                bg-yellow-50
                            @elseif($user->clearances_status == 'return')
                                bg-red-50
                            @else
                                bg-gray-50
                            @endif">
                            @if (str_contains($user->profile_picture, 'http'))
                                <img src="{{ $user->profile_picture }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover">
                            @elseif ($user->profile_picture)
                                <img src="{{ url('/profile_pictures/' . basename($user->profile_picture)) }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover">
                            @else
                                <img src="{{ url('/images/default-profile.png') }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover">
                            @endif
                            <div class="min-w-0 flex-1">
                                <h4 class="text-lg font-semibold truncate">{{ $user->name }}</h4>
                                <p class="text-sm text-gray-500 truncate max-w-full">{{ $user->email }}</p>
                                <p class="text-sm font-medium
                                    @if($hasComplied)
                                        text-blue-600
                                    @elseif($user->clearances_status == 'complete')
                                        text-green-600
                                    @elseif($user->clearances_status == 'pending')
                                        text-yellow-600
                                    @elseif($user->clearances_status == 'return')
                                        text-red-600
                                    @else
                                        text-gray-600
                                    @endif
                                ">
                                    @if($hasComplied)
                                        Return Complied
                                    @elseif($user->clearances_status == 'pending')
                                        In Progress
                                    @elseif($user->clearances_status == 'complete')
                                        Complied
                                    @elseif($user->clearances_status == 'return')
                                        Resubmit
                                    @else
                                        {{ ucfirst($user->clearances_status) }}
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500 mb-2">
                                    @if($latestUpload)
                                        Recent: {{ ucfirst($latestUpload->created_at->format('m/d/Y')) }}
                                    @else
                                        Recent: N/A
                                    @endif
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
