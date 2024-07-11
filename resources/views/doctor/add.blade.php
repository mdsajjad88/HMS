

<script src="{{asset('assets/js/main.js')}}"></script>
{{-- bootstrap modal --}}
<!-- Bootstrap Modal -->
<div class="modal fade" id="doctorModal" tabindex="-1" aria-labelledby="doctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modalHeader">
                <h5 class="modal-title" id="doctorModalLabel">Add New Doctor</h5>
                <button type="button" class="btn-close" id="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Form -->
                <form id="addNewDoctor" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <!-- First Name -->
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name" required>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter valid email address" required>
                        </div>

                        <!-- Mobile -->
                        <div class="col-md-6">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="number" class="form-control contact_no" id="mobile" name="mobile" placeholder="Enter contact no" required>
                            <small id="contact_no_res"></small>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- BMDC Number -->
                        <div class="col-md-6">
                            <label for="bmdc_number" class="form-label">BMDC Number</label>
                            <input type="text" class="form-control" id="bmdc_number" name="bmdc_number" placeholder="Enter BMDC number">
                        </div>

                        <!-- Blood Group -->
                        <div class="col-md-6">
                            <label for="blood_group" class="form-label">Blood Group</label>
                            <select class="form-select" id="blood_group" name="blood_group" required>
                                <option value="">Select Blood Group</option>
                                <option value="A+">A+</option>
                                <option value="B+">B+</option>
                                <option value="AB+">AB+</option>
                                <option value="O+">O+</option>
                                <option value="A-">A-</option>
                                <option value="B-">B-</option>
                                <option value="AB-">AB-</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>

                        <!-- Date of Birth -->
                        <div class="col-md-6">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                        </div>

                        <!-- NID -->
                        <div class="col-md-6">
                            <label for="nid" class="form-label">NID</label>
                            <input type="text" class="form-control" id="nid" name="nid" placeholder="Enter NID no" required >
                        </div>

                        <!-- Specialist -->
                        <div class="col-md-6">
                            <label for="specialist" class="form-label">Specialist</label>
                            <input type="text" class="form-control" id="specialist" name="specialist" placeholder="Enter doctor specialist" required>
                        </div>

                        <!-- Fee -->
                        <div class="col-md-6">
                            <label for="fee" class="form-label">Fee</label>
                            <input type="number" class="form-control" id="fee" name="fee" placeholder="Enter doctor fee" required>
                        </div>

                        <!-- Designation -->
                        <div class="col-md-6">
                            <label for="designation" class="form-label">Designation</label>
                            <input type="text" class="form-control" id="designation" name="designation" placeholder="Enter doctor designation" required>
                        </div>

                        <!-- Consultant Type -->
                        <div class="col-md-6">
                            <label for="consultant_type" class="form-label">Consultant Type</label>
                            <input type="text" class="form-control" id="consultant_type" name="consultant_type" placeholder="Enter consultant type">
                        </div>

                        <!-- Photo -->
                        {{-- <div class="col-md-6">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control " id="photo" name="photo">
                        </div> --}}

                        <!-- Address -->
                        <div class="col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="2" placeholder="Enter doctor address"></textarea>
                        </div>

                        <!-- Description -->
                        <div class="col-md-6">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="2" placeholder="Enter comments"></textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="modal-footer modalFooter">

                        <button type="reset" class="btn btn-secondary" >Reset</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- btm ende --}}

{{-- <div id="doctorModal" class="fixed inset-0 z-50 overflow-auto bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white rounded-lg w-full md:w-1/2 lg:w-2/3 max-w-4xl mt-40 mb-10 overflow-auto max-h-screen">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b-2 border-gray-200 pb-4 p-5 mb-4 modalHeader">
                <h2 class="text-lg font-bold">Add Doctor</h2>
                <button id="closeModal" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div id="modalBody" class="pl-5 pr-5">


                <!-- Form -->
                <form id="addNewDoctor" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- First Name -->
                        <div class="">
                            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" name="first_name" id="first_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter First Name" required>
                        </div>

                        <!-- Last Name -->
                        <div class="">
                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter last Name" required>
                        </div>

                        <!-- Email -->
                        <div class="">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter valid email address" required>
                        </div>

                        <!-- Mobile -->
                        <div class="">
                            <label for="mobile" class="block text-sm font-medium text-gray-700">Mobile</label>
                            <input type="text" name="mobile" id="mobile" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter contact no">
                        </div>

                        <!-- Gender -->
                        <div >
                            <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                            <select name="gender" id="gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- BMDC Number -->
                        <div>
                            <label for="bmdc_number" class="block text-sm font-medium text-gray-700">BMDC Number</label>
                            <input type="text" name="bmdc_number" id="bmdc_number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter BMDC number ">
                        </div>

                        <!-- Blood Group -->
                        <div>
                            <label for="blood_group" class="block text-sm font-medium text-gray-700">Blood Group</label>
                            <select name="blood_group" id="blood_group" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">Select Gender</option>
                                <option value="A+">A+</option>
                                <option value="B+">B+</option>
                                <option value="AB+">AB+</option>
                                <option value="O+">O+</option>
                                <option value="A-">A-</option>
                                <option value="B-">B-</option>
                                <option value="AB-">AB-</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>


                        <!-- Date of Birth -->
                        <div >
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <!-- NID -->
                        <div >
                            <label for="nid" class="block text-sm font-medium text-gray-700">NID</label>
                            <input type="text" name="nid" id="nid" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter NID no">
                        </div>

                        <!-- Specialist -->
                        <div >
                            <label for="specialist" class="block text-sm font-medium text-gray-700">Specialist</label>
                            <input type="text" name="specialist" id="specialist" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter doctor specialist">
                        </div>

                        <!-- Fee -->
                        <div >
                            <label for="fee" class="block text-sm font-medium text-gray-700">Fee</label>
                            <input type="number" name="fee" id="fee" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter doctor fee">
                        </div>

                        <!-- Designation -->
                        <div >
                            <label for="designation" class="block text-sm font-medium text-gray-700">Designation</label>
                            <input type="text" name="designation" id="designation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter doctor designation">
                        </div>

                        <!-- Consultant Type -->
                        <div >
                            <label for="consultant_type" class="block text-sm font-medium text-gray-700">Consultant Type</label>
                            <input type="text" name="consultant_type" id="consultant_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter consultant type">
                        </div>

                        <div >
                            <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                            <input type="file" name="photo" id="photo" class="mt-1 block w-full border-gray-800  p-1 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea name="address" id="address" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter doctor address"></textarea>
                        </div>

                        <!-- Description -->
                        <div >
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter comments"></textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-4 mb-3 flex justify-end">
                        <button type="submit" class="inline-block bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
                            Save
                        </button>
                        <a href="#" class="inline-block bg-gray-300 text-gray-700 px-4 py-2 rounded-md ml-2 hover:bg-gray-400 focus:outline-none focus:bg-gray-400">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}

<script>
    $(document).ready(function(){
        function showDoctor(){
        $('#patientSection').hide(); // Hide patient section
            $('#doctorSection').show(); // Show doctor section

            if (!$.fn.DataTable.isDataTable('#doctorTable')) {
                var table = $('#doctorTable').DataTable({
                    ajax: "{{ url('/getDoctor') }}",
                    columns: [{
                            'title': 'First Name',
                            "data": "first_name"
                        },
                        {
                            'title': 'E-mail',
                            'data': 'email'
                        },
                        {
                            'title': 'Contact No',
                            'data': 'mobile'
                        },
                        {
                            'title': 'Doctor Fee',
                            'data': 'fee'
                        },
                        {
                            'title': 'Action',
                            'data': null,
                            render: function(data, type, row) {
                                return `<button data-id="${row.id}" id='editDoctor' class='btn btn-info'> <i class="fa-solid fa-pen-to-square"></i>Edit</button>`;
                            }
                        }
                    ]
                });
            }

            // Disable doctor button, enable patient button
            $('.showDoctor').prop('disabled', true);
            $('.showPatient').prop('disabled', false);
       }
        $('#addNewDoctor').off('submit').on('submit', function(e){
            e.preventDefault(); // Prevent default form submission

            var form = $('#addNewDoctor')[0];
            var formData = new FormData(form);

            $.ajax({
                method: 'POST',
                url: '/addDoctor',
                data: formData,
                contentType: false, // Ensure to set these options for FormData
                processData: false,
                success: function(respons) {
                    $('#addNewDoctor')[0].reset();
                    if(respons.success){
                        alert(respons.success)
                        $('#closeModal').click();
                        $('#doctorTable').DataTable().ajax.reload();

                    }
                    if(respons.error){
                        alert(respons.error)
                    }
                },
                error: function(xhr, status, error) {
                // Handle error response
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    // If validation errors exist, display them
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = '';

                    for (var key in errors) {
                        errorMessage += '- ' + errors[key].join('\n- ') + '\n'; // Accumulate error messages
                    }

                   alert(errorMessage)
                }
                return false;
                }
            });
        })

    })
</script>



