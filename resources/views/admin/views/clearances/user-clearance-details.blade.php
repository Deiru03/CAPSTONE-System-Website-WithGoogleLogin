<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Clearance Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Display User ID and Name --}}
                    <div class="mb-6">
                        <h3 class="text-xl ">ID: <strong>{{ $userClearance->user->id }}</strong></h3>
                        <h3 class="text-xl ">Name: <strong>{{ $userClearance->user->name }}</strong></h3>
                        <h3 class="text-xl ">Position: <strong>{{ $userClearance->user->position }}</strong></h3>
                        <h3 class="text-xl ">Unit: <strong>{{ $userClearance->user->units }}</strong></h3>
                        <h3 class="text-xl ">Program: <strong>{{ $userClearance->user->program }}</strong></h3>
                        <h3 class="text-xl ">Email: <strong>{{ $userClearance->user->email }}</strong></h3>
                    </div>

                    <h3 class="text-2xl font-semibold mb-4">{{ $userClearance->sharedClearance->clearance->document_name }}</h3>
                    <div class="overflow-x-auto shadow-md rounded-lg">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requirement</th>
                                    <!--<th class="py-2 px-3 text-center">Upload Status</th>-->
                                    <th class="py-3 px-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Uploaded Files</th>
                                    <th class="py-3 px-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Signature Status</th>
                                    <th class="py-3 px-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Feedback</th>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($userClearance->sharedClearance->clearance->requirements as $requirement)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">{{ $requirement->requirement }}</td>
                                       {{-- <td class="border px-4 py-2">
                                            @if($userClearance->uploadedClearanceFor($requirement->id))
                                                <span class="text-green-500">Uploaded</span>
                                            @else
                                            <div class="w-full flex justify-center text-center">
                                                <span class="text-red-500 text-center">No Attachment File</span>
                                            </div>
                                            @endif
                                        </td> --}}
                                        <td class="px-4 py-3">
                                            @foreach($userClearance->uploadedClearances->where('user_id', $userClearance->user->id) as $uploaded)
                                                @if($uploaded->requirement_id == $requirement->id)
                                                    <div class="flex items-center justify-center space-x-2">
                                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V8l-6-6H4zm2 2h8v4h4v10H6V6z"></path>
                                                        </svg>
                                                        <a href="{{ asset('storage/' . $uploaded->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline text-sm">
                                                            {{ basename($uploaded->file_path) }}
                                                        </a>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </td>
                                           {{-- @foreach($userClearance->uploadedClearances as $uploaded)
                                                @if($uploaded->requirement_id == $requirement->id)
                                                    <a href="{{ asset('storage/' . $uploaded->file_path) }}" target="_blank" class="text-blue-500 hover:underline">
                                                        {{ basename($uploaded->file_path) }}
                                                    </a><br>
                                                @endif
                                            @endforeach
                                        </td>--}} <!-- Pang DEBUG lng sa lahat ng user Overall Upload -->
                                        <td class="px-4 py-3 text-center">
                                        @if($userClearance->uploadedClearanceFor($requirement->id) && $userClearance->uploadedClearanceFor($requirement->id)->status == 'signed')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Signed</span>
                                        @elseif($userClearance->uploadedClearanceFor($requirement->id) && $userClearance->uploadedClearanceFor($requirement->id)->status == 'return ')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Return</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">On Check</span>
                                        @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            @php
                                                $hasFeedback = false;
                                            @endphp
                                            @foreach($userClearance->uploadedClearances as $uploaded)
                                                @foreach($uploaded->feedback as $feedback)
                                                    <div class="bg-yellow-100 text-yellow-800 p-3 rounded-md mb-2 shadow-sm border-l-4 border-yellow-500 text-sm">
                                                        <p><strong>Feedback:</strong> {{ $feedback->message }}</p>
                                                    </div>
                                                    @php
                                                        $hasFeedback = true;
                                                    @endphp
                                                @endforeach
                                            @endforeach
                                            @if(!$hasFeedback)
                                                <div class="text-gray-500 italic text-sm">No comments yet.</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full transition-colors duration-200 text-xs font-semibold shadow-sm">
                                                Actions Document
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-admin-layout>