<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Archive') }}
        </h2>
    </x-slot>

    <div class="p-6 text-gray-900">
        <h3 class="text-lg font-medium">Archived Files</h3>
        <p class="mt-2">Here you can view your archived files.</p>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">File Name</th>
                    <th class="py-2 px-4 border-b">Requirement</th>
                    <th class="py-2 px-4 border-b">Archived Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($archivedClearances as $file)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ basename($file->file_path) }}</td>
                        <td class="py-2 px-4 border-b">{{ $file->requirement->requirement ?? 'N/A' }}</td>
                        <td class="py-2 px-4 border-b">{{ $file->updated_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>