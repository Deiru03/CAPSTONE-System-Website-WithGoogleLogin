<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clearances') }}
        </h2>
    </x-slot>
    <head>
        <!-- Other head elements -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <div class="mb-4 flex justify-center space-x-6">
        <a href="{{ route('admin.clearance.check') }}" class="bg-blue-500 text-white font-bold py-4 px-8 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            <span class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3 animate-bounce" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                <span class="text-xl">Check Faculty Clearances Checklist</span>
            </span>
        </a>
        @if(Auth::user()->user_type === 'Admin')
            <a href="{{ route('admin.clearance.manage') }}" class="bg-green-500 text-white font-bold py-4 px-8 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3 animate-spin" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    <span class="text-xl">Manage Clearances Checklist</span>
                </span>
            </a>
        @endif
    </div>
    <div class="py-10">
        <h2 class="text-3xl font-bold mb-4 text-indigo-600 border-b pb-2">Clearance Management</h2>
        <p class="text-gray-600 mb-6">Here you can view and manage faculty clearances efficiently.</p>
        {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-green-100 p-4 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                <h3 class="text-lg font-semibold text-green-700 mb-2">Complete</h3>
                <p class="text-3xl font-bold text-green-800">{{ $clearance->where('clearances_status', 'complete')->count() }}</p>
            </div>
            <div class="bg-yellow-100 p-4 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                <h3 class="text-lg font-semibold text-yellow-700 mb-2">Pending</h3>
                <p class="text-3xl font-bold text-yellow-800">{{ $clearance->where('clearances_status', 'pending')->count() }}</p>
            </div>
            <div class="bg-blue-100 p-4 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                <h3 class="text-lg font-semibold text-blue-700 mb-2">Checklist Copies</h3>
                @php
                    $totalUsers = $clearance->count();
                    $usersWithCopy = $clearance->filter(function($user) {
                        return $user->userClearances->where('is_active', true)->isNotEmpty();
                    })->count();
                @endphp
                <p class="text-3xl font-bold text-blue-800">
                    {{ $usersWithCopy }}/{{ $totalUsers }}
                </p>
                <p class="text-sm text-blue-600 mt-1">
                    {{ number_format(($usersWithCopy / ($totalUsers ?: 1)) * 100, 1) }}% have copies
                </p>
            </div>
        </div> --}}
    
    
        <!-- Add this after your existing statistics cards -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Clearance Status Chart -->
            <div class="bg-white p-4 rounded-lg shadow-lg border-2 border-indigo-200">
                <h3 class="text-lg font-bold mb-2">Clearance Status</h3>
                <div class="h-52">
                    <canvas id="clearanceStatusChart"></canvas>
                </div>
                <div class="mt-2 text-sm text-gray-600 flex justify-between">
                    <span>In Progress: {{ $clearance->where('clearances_status', 'pending')->count() }}</span>
                    <span>Completed: {{ $clearance->where('clearances_status', 'complete')->count() }}</span>
                    <span>Resubmit: {{ $clearance->where('clearances_status', 'return')->count() }}</span>
                </div>
            </div>

            <!-- Checklist Distribution Chart -->
            <div class="bg-white p-4 rounded-lg shadow-lg border-2 border-indigo-200">
                <h3 class="text-lg font-bold mb-2">Checklist Distribution</h3>
                <div class="h-52">
                    <canvas id="checklistChart"></canvas>
                </div>
                @php
                    $totalUsers = $clearance->count();
                    $usersWithCopy = $clearance->filter(function($user) {
                        return $user->userClearances->where('is_active', true)->isNotEmpty();
                    })->count();
                    $usersWithoutCopy = $totalUsers - $usersWithCopy;
                @endphp
                <div class="mt-2 text-sm text-gray-600 flex justify-between">
                    <span>With Copy: {{ $usersWithCopy }}</span>
                    <span>Without Copy: {{ $usersWithoutCopy }}</span>
                </div>
            </div>

            <!-- Recent Activity Chart -->
            <div class="bg-white p-4 rounded-lg shadow-lg border-2 border-indigo-200">
                <h3 class="text-lg font-bold mb-2">Recent Activities</h3>
                <div class="h-48">
                    <canvas id="activityChart"></canvas>
                </div>
                <div class="mt-4 text-sm text-gray-600">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <span class="font-semibold">Total Activities:</span> 
                            {{ $totalActivities }}
                        </div>
                        <div>
                            <span class="font-semibold">Today's Activities:</span> 
                            {{ end($activityData) }}
                        </div>
                    </div>
                    
                    <!-- Hover trigger area -->
                    <div class="relative group">
                        <div class="cursor-pointer text-blue-600 hover:text-blue-800 mt-2">
                            Hover to see breakdown
                        </div>
                        
                        <!-- Hidden breakdown that shows on hover -->
                        <div class="absolute left-0 mt-1 bg-white shadow-lg rounded-lg p-3 invisible group-hover:visible 
                                transition-all duration-300 opacity-0 group-hover:opacity-100 z-10 w-64 border border-gray-200">
                            <span class="font-semibold">Activity Breakdown:</span>
                            <ul class="mt-1 space-y-1">
                                @foreach($activityBreakdown as $type => $count)
                                    <li class="flex justify-between">
                                        <span>{{ $type }}:</span>
                                        <span>{{ $count }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this before closing body tag -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Clearance Status Chart
        new Chart(document.getElementById('clearanceStatusChart'), {
            type: 'doughnut',
            data: {
                labels: ['In-Progress', 'Completed', 'Resubmit'],
                datasets: [{
                    data: [
                        {{ $clearance->where('clearances_status', 'pending')->count() }},
                        {{ $clearance->where('clearances_status', 'complete')->count() }},
                        {{ $clearance->where('clearances_status', 'return')->count() }}
                    ],
                    backgroundColor: ['#FCD34D', '#10B981', '#F97316'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });

        // Checklist Distribution Chart
        new Chart(document.getElementById('checklistChart'), {
            type: 'pie',
            data: {
                labels: ['With Copy', 'Without Copy'],
                datasets: [{
                    data: [{{ $usersWithCopy }}, {{ $usersWithoutCopy }}],
                    backgroundColor: ['#3B82F6', '#EF4444'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });
            // Recent Activity Chart with real submitted reports data
            new Chart(document.getElementById('activityChart'), {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: 'Submitted Reports',
                        data: @json($activityData),
                        borderColor: '#8B5CF6',
                        tension: 0.4,
                        fill: true,
                        backgroundColor: 'rgba(139, 92, 246, 0.1)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Activities: ${context.raw}`;
                                },
                                title: function(context) {
                                    return context[0].label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            },
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeInOutQuart'
                    }
                }
            });
        });
    </script>
        

         <!-- Search and Filter Form -->
         <form method="GET" action="{{ route('admin.views.clearances') }}" class="mb-4 flex items-center">
            <input type="text" name="search" placeholder="Search by name, email, program, or status..." value="{{ request('search') }}" class="border rounded p-2 mr-2 w-1/2">
            <select name="sort" class="border rounded p-2 mr-2 w-40">
                <option value="" disabled {{ request('sort') ? '' : 'selected' }}>Sort by Name</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A to Z</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z to A</option>
            </select>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Apply</button>
        </form>
    
        <div class="overflow-x-auto">
            <div class="max-h-[600px] overflow-y-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-200 text-gray-700 sticky top-0">
                        <tr>
                            <th class="py-2 px-3 text-left text-xs">ID</th>
                            <th class="py-2 px-3 text-left text-xs">Name</th>
                            <th class="py-2 px-3 text-left text-xs">Email</th>
                            <th class="py-2 px-3 text-left text-xs">Campus</th>
                            <th class="py-2 px-3 text-left text-xs">College</th>
                            <th class="py-2 px-3 text-left text-xs">Program</th>
                            <th class="py-2 px-3 text-center text-xs">Clearance Status</th>
                            <th class="py-2 px-3 text-left text-xs">Checked By</th>
                            <th class="py-2 px-3 text-left text-xs">Last Updated</th>
                            <th class="py-2 px-3 text-left text-xs">Checklist<br>Copy</th>
                            <th class="py-2 px-3 text-left text-xs">Last<br>Uploaded</th>
                            <th class="py-2 px-3 text-left text-xs">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($clearance as $user)
                        <tr class="hover:bg-gray-50" onclick="window.location.href='{{ route('admin.clearances.show', $user->id) }}'">
                            <td class="py-2 px-3 text-xs">{{ $user->id }}</td>
                            <td class="py-2 px-3 text-xs">{{ $user->name }}</td>
                            <td class="py-2 px-3 text-xs max-w-[150px] break-words">{{ $user->email }}</td>
                            <td class="py-2 px-3 text-xs">{{ $user->campus->name ?? 'N/A' }}</td>
                            <td class="py-2 px-3 text-xs">{{ $user->department->name ?? 'N/A' }}</td>
                            <td class="py-2 px-3 text-xs max-w-[150px] break-words">{{ $user->program ?? 'N/A' }}</td>
                            <td class="py-2 px-3 clearances_status text-center text-xs">
                                @if($user->clearances_status == 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        In Progress
                                    </span>
                                @elseif($user->clearances_status == 'complete')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Complied
                                    </span>
                                @else
                                    {{ $user->clearances_status }}
                                @endif
                            </td>
                            <td class="py-2 px-3 checked_by text-xs">{{ $user->checked_by }}</td>
                            <td class="py-2 px-3 last_clearance_update text-xs">
                                {{ $user->last_clearance_update ? \Carbon\Carbon::parse($user->last_clearance_update)->format('M d, Y H:i') : 'N/A' }}
                            </td>
                            {{-- User has checklist --}}
                            <td class="py-2 px-3 checked_by text-xs">
                                    @if($user->userClearances->where('is_active', true)->first())
                                        @php
                                            $activeClearance = $user->userClearances->where('is_active', true)->first();
                                        @endphp
                                        <span class="text-green-600">
                                            {{ $activeClearance->sharedClearance->clearance->document_name }}
                                        </span>
                                    @else
                                        <span class="text-red-500">No checklist<br>assigned or copy</span>
                                    @endif
                            </td>
                            <td class="py-2 px-3 last_clearance_update text-xs">
                                @php
                                    $latestUpload = $user->userClearances
                                        ->flatMap->uploadedClearances
                                        ->where('is_archived', false)
                                        ->sortByDesc('created_at')
                                        ->first();
                                @endphp
                                {{ $latestUpload ? $latestUpload->created_at->format('M d, Y H:i') : 'N/A' }}
                            </td>
                            <td class="py-2 px-3 text-xs" onclick="event.stopPropagation()">
                                <button onclick="openModal({{ $user->id }})" class="text-blue-500 hover:text-blue-700 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Total Users and Pagination -->
        <div class="flex justify-between items-center mt-4">
            <div>
                <span class="text-sm text-gray-600">Total Users: {{ $clearance->total() }}</span>
            </div>
            <div>
                {{ $clearance->links() }}
            </div>
        </div>
        
        {{-- Edit Modal for Clearance Checklist Modification --}}
        <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden z-10">
            <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
                <h3 class="text-2xl font-bold mb-6 text-gray-800 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Clearance
                </h3>
                
                <!-- Current Clearance Info -->
                <div id="currentClearanceInfo" class="mb-4 p-3 bg-blue-50 rounded-md hidden">
                    <p class="text-sm text-blue-600">Current Active Clearance:</p>
                    <p id="currentClearanceName" class="font-medium text-blue-800"></p>
                </div>
        
                <!-- No Clearance Message -->
                <div id="noClearanceMessage" class="text-red-500 mb-4 hidden">
                    This user does not have a clearance copy yet.
                </div>
        
                <form id="editForm" method="post" action="{{ route('admin.clearance.assign') }}">
                    @csrf
                    <input type="hidden" name="id" id="editId">
                    <div class="mb-4">
                        <label for="editSharedClearance" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ isset($activeClearance) ? 'Change Clearance' : 'Assign Clearance' }}
                        </label>
                        <select name="shared_clearance_id" id="editSharedClearance" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">Select a clearance</option>
                            @foreach($sharedClearances as $sharedClearance)
                                <option value="{{ $sharedClearance->id }}">
                                    {{ $sharedClearance->clearance->document_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

    <!-- Notification -->
    <div id="notification" 
        class="z-50 fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-md shadow-lg transform transition-all duration-500 opacity-0 translate-y-[-100%] pointer-events-none">
    </div>

    <!-- Script to handle modal and notification -->
    <script>
        function openModal(id) {
            console.log('Opening modal for user ID:', id);
            document.getElementById('editId').value = id;
            
            // Get user data
            const users = @json($users);
            const user = users.find(u => u.id === parseInt(id));
            
            if (!user) {
                console.error('User not found:', id);
                return;
            }

            // Get active clearance if exists
            const activeClearance = user.user_clearances.find(uc => uc.is_active);
            
            if (activeClearance) {
                document.getElementById('noClearanceMessage').classList.add('hidden');
                document.getElementById('currentClearanceInfo').classList.remove('hidden');
                document.getElementById('currentClearanceName').textContent = 
                    activeClearance.shared_clearance.clearance.document_name;
                document.getElementById('editSharedClearance').value = activeClearance.shared_clearance_id;
            } else {
                document.getElementById('noClearanceMessage').classList.remove('hidden');
                document.getElementById('currentClearanceInfo').classList.add('hidden');
                document.getElementById('editSharedClearance').value = '';
            }
            
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // Single form submission handler
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('{{ route("admin.clearance.assign") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    closeModal();
                    showNotification(data.message, 'success');
                    if (data.userClearance) {
                        updateTableRow(data.userClearance);
                    }
                    // Optional: reload the page
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showNotification(data.message || 'Error updating clearance', 'error');
                }
            })
            .catch(error => {
                console.error('Error updating clearance:', error);
                showNotification(error.message || 'An unexpected error occurred.', 'error');
            });
        });

        function showNotification(message, type = 'success') {
            const notification = document.getElementById('notification');
            if (!notification) {
                console.error('Notification element not found');
                return;
            }
            
            notification.textContent = message;
            notification.classList.remove('bg-green-500', 'bg-red-500');
            notification.classList.add(type === 'success' ? 'bg-green-500' : 'bg-red-500');
            
            // Show notification
            notification.style.transform = 'translateY(0)';
            notification.style.opacity = '1';
            
            // Hide after 3 seconds
            setTimeout(() => {
                notification.style.transform = 'translateY(-100%)';
                notification.style.opacity = '0';
            }, 3000);
        }

        function updateTableRow(userClearance) {
            const row = document.querySelector(`tr[data-id="${userClearance.id}"]`);
            if (row) {
                // Update any relevant fields in the table row
                // Example: row.querySelector('.shared_clearance').textContent = userClearance.shared_clearance_id;
            } else {
                console.error('Row not found for user ID:', userClearance.id);
            }
        }
    </script>


</x-admin-layout>