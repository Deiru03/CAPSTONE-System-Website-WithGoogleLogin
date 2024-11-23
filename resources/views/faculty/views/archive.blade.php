<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Archive') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-gray-50 rounded-lg shadow-sm">
        <div class="flex items-center mb-4">
            <svg class="w-6 h-6 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-800">Archived Files</h3>
        </div>
        <div class="flex justify-between items-center">
            <p class="mt-2 text-gray-600">Here you can view and manage your archived files organized by academic year and semester.</p>
            <form method="GET" action="{{ route('faculty.views.archive') }}" class="flex items-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search files..." class="border border-gray-300 rounded-md p-2 mr-2 w-64">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Search</button>
            </form>
        </div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="fileGrid">
            @foreach($archivedClearances->groupBy(['academic_year', 'semester']) as $year => $semesters)
                @foreach($semesters as $semester => $files)
                    <div class="bg-white rounded-xl border-2 border-gray-300 hover:border-blue-400 hover:shadow-md transition-all duration-300">
                        <div class="p-4" onclick="openFilesModal('{{ $year }}', '{{ $semester }}', {{ json_encode($files) }})">
                            <div class="flex items-center justify-between cursor-pointer">
                                <div class="flex items-center">
                                    <div class="bg-blue-50 p-2 rounded-lg mr-3">
                                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $year }} - Semester {{ $semester }}</h4>
                                        <p class="text-sm text-gray-500">{{ count($files) }} files</p>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>

    <!-- Files List Modal -->
    <div id="filesModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-40">
        <div class="bg-white rounded-xl w-11/12 max-w-3xl max-h-[90vh] flex flex-col shadow-lg">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 id="modalTitle" class="text-xl font-semibold text-gray-800"></h3>
                <button onclick="closeFilesModal()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-4 grid grid-cols-1 sm:grid-cols-2 gap-4 border-b" id="filesContainer">
                <!-- Files will be dynamically inserted here -->
            </div>
        </div>
    </div>

    <!-- File Preview Modal -->
    <div id="previewModal" class="fixed inset-0 bg-black bg-opacity-0 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl w-11/12 h-5/6 max-w-5xl flex flex-col shadow-lg border border-gray-500">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 id="previewFileName" class="text-lg font-semibold text-gray-800 truncate"></h3>
                <button onclick="closePreviewModal()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="flex-1 p-4 bg-gray-50">
                <iframe id="previewFrame" class="w-full h-full rounded-lg shadow-inner" src=""></iframe>
            </div>
        </div>
    </div>

    <script>
        function openFilesModal(year, semester, files) {
            const modal = document.getElementById('filesModal');
            const modalTitle = document.getElementById('modalTitle');
            const filesContainer = document.getElementById('filesContainer');
            
            modalTitle.textContent = `${year} - Semester ${semester}`;
            
            // Clear previous content
            filesContainer.innerHTML = '';
            
            // Add files to container
            files.forEach(file => {
                const fileElement = document.createElement('div');
                fileElement.className = 'p-4 bg-white rounded-lg shadow-md border-2 border-gray-300 hover:shadow-lg transition-shadow duration-200 cursor-pointer hover:border-blue-400';
                fileElement.onclick = () => viewFile(file.file_path, file.file_path.split('/').pop());
                
                fileElement.innerHTML = `
                    <div class="flex items-center border-b border-gray-200 pb-3">
                        <svg class="w-6 h-6 text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-800">${file.file_path.split('/').pop()}</p>
                            <p class="text-xs text-gray-500">Requirement: ${file.requirement ? file.requirement.requirement : 'N/A'}</p>
                            <p class="text-xs text-gray-400">${new Date(file.updated_at).toLocaleString()}</p>
                        </div>
                    </div>
                `;
                
                filesContainer.appendChild(fileElement);
            });
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeFilesModal() {
            const modal = document.getElementById('filesModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function viewFile(path, filename) {
            const previewModal = document.getElementById('previewModal');
            const previewFrame = document.getElementById('previewFrame');
            const previewFileName = document.getElementById('previewFileName');

            previewFrame.src = `/file-view/${path}`;
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

        // Close modals on outside click
        document.addEventListener('click', function(event) {
            const filesModal = document.getElementById('filesModal');
            const previewModal = document.getElementById('previewModal');
            
            if (event.target === filesModal) {
                closeFilesModal();
            }
            if (event.target === previewModal) {
                closePreviewModal();
            }
        });

        // Close modals on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeFilesModal();
                closePreviewModal();
            }
        });
    </script>
</x-app-layout>