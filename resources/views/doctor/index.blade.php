@extends('layouts.app')
@section('title', 'Doctors')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

<div class="container-fluid">

    <div class="row">
        <div class="col-md-11"></div>
        <div class="col-md-1">
            <button class="doctorAdd btn btn-dark btn-sm m-1"><i class="fa-solid fa-plus"></i>Add</button>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <section id="doctorSection">
                <table class="table" id="doctorProfilesTable">
                    <thead>
                        <tr >
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Fee</th>
                            <th>Blood</th>
                            <th>Designation</th>
                            <th>Speciality</th>
                            <th class="text-center" >Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>

                </table>
            </section>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {

            $('#doctorProfilesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('doctor_profiles.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'first_name',
                        name: 'first_name'
                    },
                    {
                        data: 'last_name',
                        name: 'last_name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'mobile',
                        name: 'mobile'
                    },
                    {
                        data: 'fee',
                        name: 'fee'
                    },
                    {
                        data: 'blood_group',
                        name: 'blood_group'
                    },
                    {
                        data: 'designation',
                        name: 'designation'
                    },
                    {
                        data: 'specialist',
                        name: 'specialist'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                dom: '<"row"<"col-md-4"l><"col-md-4"B><"col-md-4"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>', // Layout definition
                buttons: [
            'copy','csv','print', 'excel','pdf', // Buttons configuration
        ],
        language: {
            searchPlaceholder: 'Search...', // Change search placeholder text

        },
        initComplete: function () {
            // Customize search input with Bootstrap styles
            var searchInput = $('.dataTables_filter input');
            searchInput.addClass('form-control form-control-sm');
            searchInput.attr('placeholder', 'Search...'); // Customize placeholder text
        }

            });

            function addNewDoctor() {
                $.ajax({
                    type: 'GET',
                    url: '/addDoctorView',
                    success: function(response) {
                        $('body').append(response);
                        $('#doctorModal').modal('show'); // Show modal

                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            // If validation errors exist, display them
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';

                            for (var key in errors) {
                                errorMessage += '- ' + errors[key].join('\n- ') +
                                '\n'; // Accumulate error messages
                            }
                            Swal.fire({
                                title: 'error!',
                                text: errorMessage,
                                icon: 'error', // 'success', 'error', 'warning', 'info', 'question'
                                confirmButtonText: 'OK'
                            });

                        } else {

                        }
                        return false;
                    }
                });
            }
            $('.doctorAdd').on('click', function() {
                addNewDoctor();
            });


            $(document).off('click').on('click', '.deleteDoctor', function() {
                var deleteButton = $(this);
                var id = deleteButton.data('id');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                Swal.fire({
                    icon: 'warning',
                    title: 'Are you sure?',
                    text: 'Want to delete doctor profile !',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/deleteDoctor/' +
                            id, // Replace with your actual delete route
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                // Handle success response, e.g., remove item from UI
                                $('#doctorProfilesTable').DataTable().ajax.reload();
                                Swal.fire({

                                    icon: 'info',
                                    text: 'Doctor Profile Deleted Successfully !',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000

                                })


                            },
                            error: function(xhr, status, error) {
                                // Handle error response
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    // If validation errors exist, display them
                                    var errors = xhr.responseJSON.errors;
                                    var errorMessage = '';

                                    for (var key in errors) {
                                        errorMessage += '- ' + errors[key].join(
                                            '\n- ') + '\n'; // Accumulate error messages
                                    }
                                    Swal.fire({
                                        title: 'error!',
                                        text: errorMessage,
                                        icon: 'error', // 'success', 'error', 'warning', 'info', 'question'
                                        confirmButtonText: 'OK',
                                        timer: 2000
                                    });

                                } else {

                                }
                                return false;
                            }
                        });
                    } else {
                        // Cancelled deletion
                        Swal.fire({
                            text: 'Deletion cancelled!!',
                            icon: 'info', // 'success', 'error', 'warning', 'info', 'question'
                            toast: true,
                            confirmButtonText: false,
                            showConfirmButton: false,
                            position: 'top-end',
                            timer: 2000
                        });

                    }

                })
            })

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
            $(document).on('click', '.editDoctor', function() {
                var doctorID = $(this).data('id');
                doctorProfileEdit(doctorID);

            })
            $(document).on('click', '.viewDoctor', function(){
                var id = $(this).data('id');
               $.ajax({
                    method: 'GET',
                    url: 'viewDoctor/'+id+'/'+1,
                    success:function(response){
                        $('body').append(response)
                        $('#doctorView').modal('show');
                    }

               });
            })

        })
    </script>
@endsection
