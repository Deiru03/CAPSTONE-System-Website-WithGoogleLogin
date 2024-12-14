<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('System Overview') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl shadow-2xl mb-8 p-8">
                <h3 class="text-3xl font-bold text-white mb-4">Welcome to IQA ClearVault</h3>
                <p class="text-white/90 text-lg leading-relaxed">
                    Your comprehensive solution for managing Institutional Quality Assurance data and streamlining clearance processes. 
                    Experience efficient document management, secure data storage, and seamless collaboration.
                </p>
            </div>

            <!-- Key Features Grid -->
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <!-- Clearance Management -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-2xl hover:-translate-y-1 hover:bg-gradient-to-r hover:from-white hover:to-blue-50 transition-all transform duration-300">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h4 class="text-xl font-semibold ml-3">Clearance Management</h4>
                    </div>
                    <p class="text-gray-600">Streamline the process of verifying and managing faculty clearances with automated workflows and real-time status updates.</p>
                </div>

                <!-- Data Bank -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-2xl hover:-translate-y-1 hover:bg-gradient-to-r hover:from-white hover:to-blue-50 transition-all transform duration-300">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                        </svg>
                        <h4 class="text-xl font-semibold ml-3">Data Bank</h4>
                    </div>
                    <p class="text-gray-600">Centralized storage system with enhanced security features, data analysis capabilities, and comprehensive backup solutions.</p>
                </div>

                <!-- File Archiving -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-2xl hover:-translate-y-1 hover:bg-gradient-to-r hover:from-white hover:to-blue-50 transition-all transform duration-300">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2"/>
                        </svg>
                        <h4 class="text-xl font-semibold ml-3">File Archiving</h4>
                    </div>
                    <p class="text-gray-600">Efficient document preservation system with advanced search capabilities and organized file categorization.</p>
                </div>

                <!-- Analytics -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-2xl hover:-translate-y-1 hover:bg-gradient-to-r hover:from-white hover:to-blue-50 transition-all transform duration-300">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <h4 class="text-xl font-semibold ml-3">Analytics</h4>
                    </div>
                    <p class="text-gray-600">Data visualization and analytics tools for informed decision-making and performance tracking.</p>
                </div>

                <!-- Report Generation -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-2xl hover:-translate-y-1 hover:bg-gradient-to-r hover:from-white hover:to-blue-50 transition-all transform duration-300">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h4 class="text-xl font-semibold ml-3">Report Generation</h4>
                    </div>
                    <p class="text-gray-600">Automated report generation for clearance status monitoring and compliance tracking.</p>
                </div>

                <!-- Notifications -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-2xl hover:-translate-y-1 hover:bg-gradient-to-r hover:from-white hover:to-blue-50 transition-all transform duration-300">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <h4 class="text-xl font-semibold ml-3">Notifications</h4>
                    </div>
                    <p class="text-gray-600">Real-time alerts and notifications for document submissions, approvals, and status updates.</p>
                </div>

            </div>

            <!-- User Roles Section -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                <h4 class="text-2xl font-bold mb-6 text-gray-800">System Roles & Responsibilities</h4>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                @php
                    $userType = Auth::user()->user_type;
                @endphp

                <!-- Administrator Card -->
                <div class="p-6 border rounded-lg shadow-lg transform hover:scale-105 hover:shadow-2xl transition duration-300 {{ $userType == 'Admin' ? 'border-4 border-blue-500' : '' }}">
                    <div class="flex items-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-500 mr-2" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12a5 5 0 100-10 5 5 0 000 10z"/>
                            <path fill-rule="evenodd" d="M2 20a10 10 0 0120 0H2z" clip-rule="evenodd"/>
                        </svg>
                        <h5 class="font-semibold text-lg text-blue-600">Administrator</h5>
                    </div>
                    <ul class="list-disc list-inside text-gray-600">
                        <li>System management</li>
                        <li>User account control</li>
                        <li>Access rights management</li>
                        @if($userType == 'Admin')
                            <li>Manage clearances</li>
                            <li>Generate reports</li>
                            <li>Advanced settings access</li>
                        @endif
                    </ul>
                </div>

                <!-- Program Head Card -->
                <div class="p-6 border rounded-lg shadow-lg transform hover:scale-105 hover:shadow-2xl transition duration-300 {{ $userType == 'Program-Head' ? 'border-4 border-green-500' : '' }}">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 7H7v6h6V7z"/>
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v3h2V5h12v3h2V5a2 2 0 00-2-2H4zm0 7H2v5a2 2 0 002 2h3v-2H4v-5zm12 5h-3v2h3a2 2 0 002-2v-5h-2v5z" clip-rule="evenodd"/>
                        </svg>
                        <h5 class="font-semibold text-lg text-green-600">Program Head</h5>
                    </div>
                    <ul class="list-disc list-inside text-gray-600">
                        <li>Program oversight</li>
                        <li>Clearance approval</li>
                        <li>Document verification</li>
                        @if($userType == 'Program-Head')
                            <li>Manage program curricula</li>
                            <li>View Documents of Under Program</li>
                            <li>Can Leave Comment to your Faculty</li>
                        @endif
                    </ul>
                </div>

                <!-- Dean Card -->
                <div class="p-6 border rounded-lg shadow-lg transform hover:scale-105 hover:shadow-2xl transition duration-300 {{ $userType == 'Dean' ? 'border-4 border-purple-500' : '' }}">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-purple-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 7H7v6h6V7z"/>
                            <path d="M5 3a2 2 0 00-2 2v3h14V5a2 2 0 00-2-2H5z"/>
                            <path d="M5 12h10v5a2 2 0 01-2 2H7a2 2 0 01-2-2v-5z"/>
                        </svg>
                        <h5 class="font-semibold text-lg text-purple-600">Dean</h5>
                    </div>
                    <ul class="list-disc list-inside text-gray-600">
                        <li>Department management</li>
                        <li>Final clearance review</li>
                        <li>Policy enforcement</li>
                        @if($userType == 'Dean')
                            <li>Oversee All Colleges</li>
                            <li>View Under Colleges Documents </li>
                            <li>Analitics of Under Colleges</li>
                        @endif
                    </ul>
                </div>

                <!-- Faculty Card -->
                <div class="p-6 border rounded-lg shadow-lg transform hover:scale-105 hover:shadow-2xl transition duration-300 {{ $userType == 'Faculty' ? 'border-4 border-yellow-500' : '' }}">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 2a2 2 0 00-2 2v4h4V4a2 2 0 00-2-2z"/>
                            <path d="M6 9a2 2 0 00-1.995 1.85L4 11v5a2 2 0 002 2h8a2 2 0 002-2v-5a2 2 0 00-1.85-1.995L14 9H6z"/>
                        </svg>
                        <h5 class="font-semibold text-lg text-yellow-600">Faculty</h5>
                    </div>
                    <ul class="list-disc list-inside text-gray-600">
                        <li>Document submission</li>
                        <li>Clearance tracking</li>
                        <li>Profile management</li>
                        @if($userType == 'Faculty')
                            <li>Modify documents</li>
                            <li>Receive notifications</li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Quick Start Guide -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                <h4 class="text-2xl font-bold mb-6 text-gray-800">Getting Started</h4>
                <div class="space-y-4">
                    <div class="flex items-center p-4 border-l-4 border-blue-600 bg-gray-50 hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-100 hover:-translate-y-1 transition-all transform duration-300">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white mr-4">1</span>
                        <div>
                            <h5 class="font-semibold">Account Access</h5>
                            <p class="text-gray-600">Log in using your institutional credentials</p>
                        </div>
                    </div>
                    <div class="flex items-center p-4 border-l-4 border-blue-600 bg-gray-50 hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-100 hover:-translate-y-1 transition-all transform duration-300">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white mr-4">2</span>
                        <div>
                            <h5 class="font-semibold">Navigate Dashboard</h5>
                            <p class="text-gray-600">Access your personalized dashboard and features</p>
                        </div>
                    </div>
                    <div class="flex items-center p-4 border-l-4 border-blue-600 bg-gray-50 hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-100 hover:-translate-y-1 transition-all transform duration-300">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white mr-4">3</span>
                        <div>
                            <h5 class="font-semibold">Document Management</h5>
                            <p class="text-gray-600">Upload and manage your clearance requirements</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Support Section -->
            <div class="mt-8 text-center bg-white p-6 rounded-lg shadow-md">
                <h4 class="text-xl font-semibold mb-4">Need Assistance?</h4>
                <p class="text-gray-600">Our support team is ready to help at 
                    <a href="mailto:support@omsc.edu.ph" class="text-blue-600 hover:underline font-medium">support@omsc.edu.ph</a>
                </p>
                <p class="text-sm text-gray-500 mt-2">Available Monday to Friday, 8:00 AM - 5:00 PM</p>
            </div>
        </div>
    </div>
</x-admin-layout>