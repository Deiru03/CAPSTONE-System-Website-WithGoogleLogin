<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Clearance Check') }}
        </h2>
    </x-slot>

    <div class="py-12">     
        <h3 class="text-3xl font-semibold mb-4 text-blue-600">User Clearance Check</h3>
        <div class="overflow-x-auto">

            <form method="GET" action="{{ route('admin.clearance.search') }}" class="mb-4">
                <input type="text" name="query" placeholder="Search requirements..." value="{{ request('query') }}" class="border rounded p-2 mr-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
            </form>
            
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr>
                        <th class="py-3 px-4 text-left text-blue-600">User ID</th>
                        <th class="py-3 px-4 text-left text-blue-600">User Name</th>
                        <th class="py-3 px-4 text-left text-blue-600">Requirement</th>
                        {{-- <th class="py-3 px-4 text-left text-blue-600">Uploaded</th> --}}
                        <th class="py-3 px-4 text-left text-blue-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userClearances as $userClearance)
                        @foreach($userClearance->sharedClearance->clearance->requirements as $requirement)
                            @if(str_contains($requirement->requirement, $query))
                                <tr>
                                    <td class="border px-4 py-3">{{ $userClearance->user->id }}</td>
                                    <td class="border px-4 py-3">{{ $userClearance->user->name }}</td>
                                    <td class="border px-4 py-3">{{ $requirement->requirement }}</td>
                                   {{-- <td class="border px-4 py-3">
                                        @php
                                            $uploaded = $userClearance->uploadedClearances->where('requirement_id', $requirement->id)->isNotEmpty();
                                        @endphp

                                        @if($uploaded)
                                            <span class="text-green-500">Uploaded</span>
                                        @else
                                            <span class="text-red-500">Not Uploaded</span>
                                        @endif
                                    </td> --}}
                                    <td class="border px-4 py-3">
                                        <a href="{{ route('admin.clearances.show', $userClearance->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition-colors duration-300">View Details</a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>