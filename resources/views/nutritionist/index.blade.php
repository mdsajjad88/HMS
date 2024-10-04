@extends('layouts.main')
@section('title', 'Nutritionist')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-11"></div>
            <div class="col-1"><button class="nutritionistAdd btn btn-dark btn-sm m-1"><i
                        class="fa-solid fa-plus"></i>Add</button></div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped fs-9" id="nutritionistTable">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Gender</th>
                            <th>Blood Group</th>
                            <th>Fee</th>
                            <th>Address </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            var nutritionist = $('#nutritionistTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('nutritionist.index') }}",
                columns: [{
                        data: null,

                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'mobile',
                        name: 'mobile'
                    },

                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'blood_group',
                        name: 'blood_group'
                    },
                    {
                        data: 'fee',
                        name: 'fee'
                    },
                    {
                        data: 'address',
                        name: 'address'
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
                    'copy', 'csv', 'print', 'excel', // Buttons configuration
                ],
                language: {
                    searchPlaceholder: 'Search...', // Change search placeholder text

                },
                order: [
                    [0, 'desc']
                ],
                initComplete: function() {
                    // Customize search input with Bootstrap styles
                    var searchInput = $('.dataTables_filter input');
                    searchInput.addClass('form-control form-control-sm');
                    searchInput.attr('placeholder', 'Search...'); // Customize placeholder text
                }

            });
        })

        function addNewNutritionist() {
            $.ajax({
                type: 'GET',
                url: '{{ route('nutritionist.create') }}',
                success: function(response) {
                    $('body').append(response);
                    $('#nutritionistModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#nutritionistModal').modal('show'); // Show modal

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
        $('.nutritionistAdd').on('click', function() {
            addNewNutritionist();
        });



        $(document).off('click').on('click', '.editNutritionist', function() {

            var editButton = $(this);
            var id = editButton.data('id');
            $.ajax({
                method: 'GET',
                url: 'nutritionist/' + id + '/edit',
                success: function(response) {
                    $('body').append(response)
                    $('#nutritionistEditModal').modal('show'); // Show modal

                }
            })
        });

        $(document).ready(function() {
            $(document).on('click', '.deleteNutritionist', function() {
                var deleteButton = $(this);
                var id = deleteButton.data('id');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                Swal.fire({
                    icon: 'warning',
                    title: 'Are you sure?',
                    text: 'Want to delete Nutritionist profile !',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'nutritionist/' +
                                id, // Replace with your actual delete route
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                // Handle success response, e.g., remove item from UI
                                $('#nutritionistTable').DataTable().ajax.reload();
                                Swal.fire({

                                    icon: 'info',
                                    text: 'Nutritionist Profile Deleted Successfully !',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000

                                });


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
        })
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.viewNutritionist', function() {
                var viewbtn = $(this);
                var id = viewbtn.data('id');

                $.ajax({
                    type: 'GET',
                    url: "nutritionist-profile/" + id + '/'+ 1,
                    success: function(response) {
                        // Assuming the response contains HTML content for the modal
                        $('body').append(response);
                        // $('#nutritionistProfile').modal({
                        //     backdrop: 'static',
                        //     keyboard: false
                        // });
                        $('#nutritionistProfile').modal('show'); // Show modal
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            // If validation errors exist, display them
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';

                            for (var key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    errorMessage += '- ' + errors[key].join('\n- ') +
                                    '\n'; // Accumulate error messages
                                }
                            }
                            Swal.fire({
                                title: 'Error!',
                                text: errorMessage,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            // Handle other types of errors or unexpected issues
                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseText || 'An unexpected error occurred.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                        return false;
                    }
                });
            });
        })
    </script>
@endsection
