<!-- Modal -->
<div id="doctorModal" class="fixed inset-0 z-50 overflow-auto bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white rounded-lg w-full md:w-1/2 lg:w-2/3 xl:w-1/2 p-8">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b-2 border-gray-200 pb-4 mb-4">
                <h2 class="text-lg font-bold">Add Department</h2>
                <button id="closeModal" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div id="modalBody">
                <!-- Content loaded via AJAX will be placed here -->
            </div>
        </div>
    </div>
</div>
