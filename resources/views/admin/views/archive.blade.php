<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Archive') }}
        </h2>
    </x-slot>

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
                    <div class="bg-white rounded-lg border border-gray-200 hover:border-blue-400 transition-colors">
                        <button onclick="openSideModal('{{ $userName }}')" class="w-full p-4">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 min-w-[2rem] text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                </svg>
                                <div class="text-left">
                                    <h4 class="font-medium text-gray-900">{{ $userName }}</h4>
                                    <p class="text-sm text-gray-500">{{ count($clearances) }} archived files</p>
                                </div>
                            </div>
                        </button>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Side Modal -->
        <div id="sideModal" class="fixed top-0 right-0 h-full w-96 bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 min-w-[1.5rem] text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                        </svg>
                        <h3 id="modalUserName" class="text-lg font-semibold text-gray-800"></h3>
                    </div>
                    <button onclick="closeSideModal()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6 min-w-[1.5rem]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div id="modalContent" class="space-y-3">
                    <!-- Content will be populated by JavaScript -->
                </div>
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
    </div>

    <script>
        const clearanceData = {
            @foreach($archivedClearances->groupBy('user.name') as $userName => $clearances)
                '{{ $userName }}': [
                    @foreach($clearances as $clearance)
                        {
                            filename: '{{ basename($clearance->file_path) }}',
                            path: '{{ $clearance->file_path }}'
                        },
                    @endforeach
                ],
            @endforeach
        };

        function openSideModal(userName) {
            const modal = document.getElementById('sideModal');
            const modalUserName = document.getElementById('modalUserName');
            const modalContent = document.getElementById('modalContent');
            
            modalUserName.textContent = userName;
            modalContent.innerHTML = '';

            const files = clearanceData[userName];
            files.forEach(file => {
                const fileElement = document.createElement('div');
                fileElement.className = 'flex items-center justify-between py-2 px-3 hover:bg-gray-50 rounded-md group';
                fileElement.innerHTML = `
                    <button onclick="viewFile('${file.path}', '${file.filename}')" class="flex items-center flex-grow mr-2">
                        <svg class="w-5 h-5 min-w-[1.25rem] text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="text-gray-600 group-hover:text-blue-600 transition-colors">${file.filename}</span>
                    </button>
                    <button onclick="restoreFile('${file.path}')" class="flex items-center px-3 py-1 text-sm text-blue-600 hover:bg-blue-50 rounded-md transition-colors">
                        <svg class="w-4 h-4 min-w-[1rem] mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Restore
                    </button>
                `;
                modalContent.appendChild(fileElement);
            });

            modal.classList.remove('translate-x-full');
        }

        function closeSideModal() {
            document.getElementById('sideModal').classList.add('translate-x-full');
        }

        function viewFile(path, filename) {
            const previewModal = document.getElementById('previewModal');
            const previewFrame = document.getElementById('previewFrame');
            const previewFileName = document.getElementById('previewFileName');
            
            const url = `{{ asset('storage') }}/${path}`;
            previewFrame.src = url;
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

        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            const sideModal = document.getElementById('sideModal');
            const previewModal = document.getElementById('previewModal');
            
            const isSideModalOpen = !sideModal.classList.contains('translate-x-full');
            const isPreviewModalOpen = !previewModal.classList.contains('hidden');
            
            if (isSideModalOpen && !event.target.closest('#sideModal') && !event.target.closest('button')) {
                closeSideModal();
            }
            
            if (isPreviewModalOpen && !event.target.closest('.rounded-lg') && !event.target.closest('button')) {
                closePreviewModal();
            }
        });

        function restoreFile(path) {
            // Implement restore logic here
            console.log('Restoring file:', path);
        }
    </script>
</x-admin-layout>