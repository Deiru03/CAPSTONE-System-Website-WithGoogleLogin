<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Archive') }}
        </h2>
    </x-slot>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="p-6 bg-gray-50 rounded-lg shadow-sm">
        <div class="flex items-center mb-4">
            <svg class="w-6 h-6 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-800">Archived Files</h3>
        </div>
        <p class="mt-2 text-gray-600">Here you can view and manage archived files.</p>

        @if($archivedClearances->isEmpty())
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="text-gray-500">No archived files found.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                @foreach($archivedClearances->groupBy('user.name') as $userName => $clearances)
                    <div class="bg-white rounded-xl border border-gray-200 hover:border-red-400 hover:shadow-md transition-all duration-300">
                        <button onclick="openUserModal('{{ $userName }}')" class="w-full p-5">
                            <div class="flex items-center">
                                <div class="bg-red-50 p-3 rounded-lg mr-4">
                                    <svg class="w-8 h-8 min-w-[2rem] text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <h4 class="font-semibold text-gray-900 text-lg">{{ $userName }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">{{ count($clearances) }} archived files</p>
                                </div>
                            </div>
                        </button>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- User Files Modal -->
        <div id="userModal" class="fixed inset-0 bg-black bg-opacity-20 hidden items-center justify-center z-10">
            <div class="bg-white rounded-xl w-11/12 max-w-3xl max-h-[90vh] flex flex-col">
                <div class="flex justify-between items-center p-4 border-b">
                    <h3 id="userModalTitle" class="text-xl font-semibold text-gray-800"></h3>
                    <button onclick="closeUserModal()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto p-4" id="yearSemesterGrid">
                    <!-- Year/Semester grid will be populated here -->
                </div>
            </div>
        </div>

        <!-- Files List Modal -->
        <div id="filesModal" class="fixed inset-0 bg-black bg-opacity-0 hidden items-center justify-center z-20">
            <div class="bg-white rounded-lg w-11/12 max-w-3xl max-h-[90vh] flex flex-col">
                <div class="flex justify-between items-center p-3 border-b">
                    <h3 id="filesModalTitle" class="text-lg font-semibold text-gray-800"></h3>
                    <button onclick="closeFilesModal()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto p-3" id="filesList">
                    <!-- Files list will be populated here -->
                </div>
            </div>
        </div>

        <!-- Preview Modal -->
        <div id="previewModal" class="fixed inset-0 bg-black bg-opacity-30 hidden items-center justify-center z-30">
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
    </div>

    <script>
        const clearanceData = {
            @foreach($archivedClearances->groupBy('user.name') as $userName => $clearances)
                '{{ $userName }}': {
                    @foreach($clearances->groupBy(['academic_year', 'semester']) as $year => $semesters)
                        '{{ $year }}': {
                            @foreach($semesters as $semester => $files)
                                '{{ $semester }}': [
                                    @foreach($files as $file)
                                        {
                                            filename: '{{ basename($file->file_path) }}',
                                            path: '{{ $file->file_path }}'
                                        },
                                    @endforeach
                                ],
                            @endforeach
                        },
                    @endforeach
                },
            @endforeach
        };

        function openUserModal(userName) {
            const modal = document.getElementById('userModal');
            const modalTitle = document.getElementById('userModalTitle');
            const yearSemesterGrid = document.getElementById('yearSemesterGrid');
            
            modalTitle.textContent = userName;
            yearSemesterGrid.innerHTML = '';

            const userClearances = clearanceData[userName];
            const grid = document.createElement('div');
            grid.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4';

            for (const year in userClearances) {
                for (const semester in userClearances[year]) {
                    const card = document.createElement('div');
                    card.className = 'bg-white rounded-xl border border-gray-200 hover:border-blue-400 hover:shadow-md transition-all duration-300';
                    card.innerHTML = `
                        <button onclick="openFilesModal('${userName}', '${year}', '${semester}')" class="w-full p-4">
                            <div class="flex items-center">
                                <div class="bg-blue-50 p-3 rounded-lg mr-3">
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <h4 class="font-semibold text-gray-900">${year} - Semester ${semester}</h4>
                                    <p class="text-sm text-gray-500">${userClearances[year][semester].length} files</p>
                                </div>
                            </div>
                        </button>
                    `;
                    grid.appendChild(card);
                }
            }

            yearSemesterGrid.appendChild(grid);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function openFilesModal(userName, year, semester) {
            const modal = document.getElementById('filesModal');
            const modalTitle = document.getElementById('filesModalTitle');
            const filesList = document.getElementById('filesList');
            
            modalTitle.textContent = `${year} - Semester ${semester}`;
            filesList.innerHTML = '';

            const files = clearanceData[userName][year][semester];
            files.forEach(file => {
                const fileElement = document.createElement('div');
                fileElement.className = 'bg-white rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer transition-all duration-200 mb-2';
                fileElement.innerHTML = `
                    <div class="p-3" onclick="viewFile('${file.path}', '${file.filename}')">
                        <div class="flex items-center">
                            <div class="bg-gray-50 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-700">${file.filename}</p>
                                <p class="text-xs text-gray-500">Last modified: ${new Date(file.updated_at).toLocaleString()}</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                `;
                filesList.appendChild(fileElement);
            });

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeUserModal() {
            const modal = document.getElementById('userModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function closeFilesModal() {
            const modal = document.getElementById('filesModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
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

        function deleteFile(path) {
            if (confirm('Are you sure you want to permanently delete this file? This action cannot be undone.')) {
                fetch('/admin/archive/delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ path: path })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const fileElement = document.querySelector(`[onclick="deleteFile('${path}')"]`).closest('.bg-white');
                        fileElement.remove();
                        alert('File deleted successfully');
                        
                        if (document.getElementById('filesList').children.length === 0) {
                            window.location.reload();
                        }
                    } else {
                        alert('Error deleting file: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting file');
                });
            }
        }

        // Close modals on outside click
        document.addEventListener('click', function(event) {
            const userModal = document.getElementById('userModal');
            const filesModal = document.getElementById('filesModal');
            const previewModal = document.getElementById('previewModal');
            
            if (event.target === userModal) {
                closeUserModal();
            }
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
                closeUserModal();
                closeFilesModal();
                closePreviewModal();
            }
        });
    </script>
</x-admin-layout>