<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Archive') }}
        </h2>
    </x-slot>

    <div class="p-6 text-gray-900">
        <h3 class="text-lg font-medium">Archived Files</h3>
        <p class="mt-2">Here you can view your archived files. Click on any file card below to preview the document.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="fileGrid">
            @foreach($archivedClearances as $file)
                <div class="bg-white shadow-md rounded-lg p-4 border border-gray-200 hover:shadow-xl hover:scale-105 hover:bg-gray-50 cursor-pointer transition-all duration-300 transform relative" 
                     onclick="viewFile('{{ $file->file_path }}', '{{ basename($file->file_path) }}')">
                    <div class="absolute top-2 right-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-lg text-blue-600 hover:text-blue-800 transition-colors">{{ basename($file->file_path) }}</h4>
                    <p class="text-sm text-gray-600">Requirement: {{ $file->requirement->requirement ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-600">Archived Date: {{ $file->updated_at->format('Y-m-d H:i') }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg w-11/12 h-5/6 max-w-4xl flex flex-col">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 id="previewFileName" class="text-lg font-semibold text-gray-800"></h3>
                <button onclick="closePreviewModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="flex-1 p-4 overflow-auto">
                <iframe id="previewFrame" class="w-full h-full border-0" src=""></iframe>
            </div>
        </div>
    </div>

    <script>
        function viewFile(path, filename) {
            const previewModal = document.getElementById('previewModal');
            const previewFrame = document.getElementById('previewFrame');
            const previewFileName = document.getElementById('previewFileName');

            // production hosted
            const fileUrl = `/file-view/${path}`;
            previewFrame.src = fileUrl;

            // local hosted
            // const url = `{{ asset('storage') }}/${path}`;
            // previewFrame.src = url;
            previewFileName.textContent = filename;
            
            previewModal.classList.remove('hidden');
            previewModal.classList.add('flex');
        }

        function closePreviewModal() {
            const previewModal = document.getElementById('previewModal');
            const previewFrame = document.getElementById('previewFrame');
            
            previewModal.classList.add('hidden');
            previewModal.classList.remove('flex');
            previewFrame.src = '';
        }

        // Close preview modal when clicking outside
        document.addEventListener('click', function(event) {
            const previewModal = document.getElementById('previewModal');
            const isPreviewModalOpen = !previewModal.classList.contains('hidden');
            
            if (isPreviewModalOpen && !event.target.closest('.rounded-lg') && !event.target.closest('button')) {
                closePreviewModal();
            }
        });
    </script>
</x-app-layout>