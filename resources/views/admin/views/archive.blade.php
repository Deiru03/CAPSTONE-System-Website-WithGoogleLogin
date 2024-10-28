<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Archive') }}
        </h2>
    </x-slot>

    <div class="p-6 text-gray-900">
        <h3 class="text-lg font-medium">Archive</h3>
        <p class="mt-2">Here you can view and manage archived files.</p>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Document Name</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($archivedClearances as $clearance)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $clearance->document_name }}</td>
                        <td class="py-2 px-4 border-b">
                            <button class="text-blue-500 hover:underline">Restore</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>