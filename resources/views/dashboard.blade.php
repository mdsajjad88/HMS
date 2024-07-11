<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded homeBtn">
                        Home
                    </button>
                    <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded doctorAdd">
                        Add Doctor
                    </button>
                    <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded showDoctor">
                        Our Doctor
                    </button>
                    <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded addPatient">
                        Add Patient
                    </button>


                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <div id="doctorSection">
                    <table id="doctorTable" class="table table-bordered text-center">

                    </table>
                </div>

                <section id="patientSection">
                    <table id="patientTable" class="table table-bordered text-center">

                    </table>
                </section>

            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        function addNewDoctor() {
            $.ajax({
                type: 'GET',
                url: '/addDoctorView',
                success: function(response) {
                    $('body').append(response);
                    $('#doctorModal').modal('show'); // Show modal

                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors (optional)
                    alert(error);
                }
            });
        }

        $('.doctorAdd').click(function() {
            addNewDoctor();
        });


        function doctorProfileEdit(doctorID) {
            $.ajax({
                method: 'GET',
                url: '/editDoctor/' + doctorID,
                success: function(response) {
                    $('body').append(response)
                    $('#doctorEditModal').modal('show'); // Show modal

                }
            })
        }
        function patientProfileEdit(patientId) {
            $.ajax({
                method: 'GET',
                url: '/editPatient/' + patientId,
                success: function(response) {
                    $('body').append(response)
                    $('#updatePatientModal').modal('show'); // Show modal
                }
            })
        }

        $(document).off('click').on('click', '#editDoctor', function() {
            var doctorID = $(this).data('id');
            doctorProfileEdit(doctorID);

        })
        function addNewPatient(){
            $.ajax({
                method: 'GET',
                url: '/addPatient',
                success: function(response) {
                    $('body').append(response)
                    $('#patientModal').modal('show'); // Show modal

                }
            })
        }
        $('.addPatient').click(function(){
            addNewPatient();
        })

       $('.showDoctor').click(function() {
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
                            'title': 'Gender',
                            'data': 'gender'
                        },
                        {
                            'title': 'Blood',
                            'data': 'blood_group'
                        },
                        {
                            'title': 'Address',
                            'data': 'address'
                        },
                        {
                            'title': 'Designation',
                            'data': 'designation'
                        },
                        {
                            'title': 'Speciality',
                            'data': 'specialist'
                        },
                        {
                            'title': 'Action',
                            'data': null,
                            render: function(data, type, row) {
                                return `<button data-id="${row.id}" id='editDoctor' class='btn btn-info'> <i class="fa-solid fa-pen-to-square"></i>Edit</button>`;
                            }
                        },
                        {
                            'title': 'Delete',
                            'data': null,
                            render: function(data, type, row) {
                                return `<button data-id="${row.id}" id='deleteDoctor' class='btn btn-danger'> <i class="fa-solid fa-trash"></i>Delete</button>`;
                            },
                        },
                    ]
                });
            }

            // Disable doctor button, enable patient button
            $('.showDoctor').prop('disabled', true);
            $('.showPatient').prop('disabled', false);
        });

        // default datatable
                var table = $('#patientTable').DataTable({
                    ajax: "{{ url('/getPatient') }}",
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
                            'title': 'Gender',
                            'data': 'gender'
                        },
                        {
                            'title': 'Address',
                            'data': 'address'
                        },
                        {
                            'title': 'Blood Group',
                            'data': 'blood_group'
                        },
                        {
                            'title': 'Status',
                            'data': 'marital_status'
                        },
                        {
                            'title': 'Action',
                            'data': null,
                            render: function(data, type, row) {
                                return `<button data-id="${row.id}" id='editPatient' class='btn btn-info'> <i class="fa-solid fa-pen-to-square"></i>Edit</button>`;
                            }
                        }
                    ]
                });

                $(document).on('click', '#editPatient',  function(){
                    var patientId = $(this).data('id');
                    patientProfileEdit(patientId);
                });

        $('.homeBtn').click(function() {
            $.ajax({
                type: 'GET',
                url: '{{ url("/dashboard") }}', // Replace with your route to the home/dashboard
                success: function(response) {
                    // Assuming response is HTML content of the home/dashboard view
                    $('body').html(response); // Replace the entire body content with the response
                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors (optional)
                    console.error(error);
                    alert('An error occurred while loading the home/dashboard.');
                }
            });
        });
        $(document).on('click', '#deleteDoctor', function(e) {
        e.preventDefault(); // Prevent the default action (form submission)

        var deleteButton = $(this);
        var id = deleteButton.data('id');

        // Show confirmation dialog
        if (confirm("Are you sure you want to delete this item?")) {
            // Proceed with deletion
            $.ajax({
                url: '/deleteDoctor/' + id, // Replace with your actual delete route
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Handle success response, e.g., remove item from UI
                    $('#doctorTable').DataTable().ajax.reload();
                    deleteButton.closest('.item-container').remove();
                    alert('Doctor Profile deleted successfully!');
                },
                error: function(xhr) {
                    // Handle error response
                    alert('Error deleting item. Please try again.');
                }
            });
        } else {
            // Cancelled deletion
            alert('Deletion cancelled!! Please try again');
        }
    });


    });
</script>
