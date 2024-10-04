@extends('layouts.main')
@section('title', 'Patient visit')
@section('content')
<style>
    /* Ensure radio button container spans full width */
.radio-group {
    display: flex;
    justify-content: space-between; /* Distribute radio buttons evenly */
    align-items: center; /* Center items vertically */
    width: 100%; /* Full width */
    flex-wrap: wrap; /* Wrap to new lines if there isn't enough space */
}

/* Style each label to ensure it's flexible and centered */
.radio-group label {
    display: flex;
    align-items: center;
    justify-content: center; /* Center text within each label */
    flex: 1 1 auto; /* Allow flex to grow/shrink */
    margin: 0 5px; /* Spacing between buttons */
    text-align: center; /* Center text */
}

/* Adjust spacing between radio button and label text */
.radio-group input[type="radio"] {
    margin-right: 10px; /* Space between radio button and label text */
    /* Increase the size of the radio button */
    transform: scale(1.5); /* Scale the radio button to 1.5 times its original size */
    cursor: pointer; /* Change cursor to pointer to indicate clickable */
}
.select2-container {
    width: 100% !important;
}
.select2-container--default .select2-selection--multiple {
    width: 100% !important;
}
.select2-container--default .select2-selection--single {
    width: 100% !important;
}
.btn-xs {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    line-height: 1.5;
    border-radius: 0.2rem;
    display: inline-flex;
}
.actionBtn{
    min-width: 130px !important;
}
.visit-date{
    min-width: 92px !important;
}
</style>
    {{-- <div class="container-fluid">
        <div class="row">
            <div class="col-md-11"></div>
            <div class="col-md-1">
                <a href="#" class="btn btn-dark btn-sm m-1"><i class="fa-solid fa-plus"></i>Add</a>
            </div>
        </div>
    </div> --}}

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <table class="table table-striped data-table fs-9" id="nutritions_visitTable">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Patient Name</th>
                            <th>Doctor Name</th>
                            <th class="visit-date">Visit Date</th>
                            <th>Visit No</th>
                            <th>Session Visit?</th>
                            <th>S.V No</th>
                            <th>Problems</th>
                            <th>Nutritionist</th>
                            <th>Updated By</th>
                            <th class="actionBtn">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#nutritions_visitTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('nutritionist-visit.index') }}",
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'patient_name',
                        name: 'patient_name',
                    },
                    {
                        data: 'doctor_name',
                        name: 'doctor_name',
                    },
                    {
                        data: 'visit_date',
                        name: 'visit_date',
                    },
                    {
                        data: 'no_of_visit',
                        name: 'no_of_visit',
                    },
                    {
                        data: 'is_session_visite',
                        name: 'is_session_visite',
                        render: function(data) {
                            return data == 1 ? 'Yes' : 'No'; // Handles valid data
                        }
                    },
                    {
                        data: 'session_visite_count',
                        name: 'session_visite_count',
                    },
                    {
                        data: 'problems',
                        name: 'problems',
                    },
                    {
                        data: 'nutritionist',
                        name: 'nutritionist',
                        render: function(data) {
                            if (!data || data.trim() === '') {
                                return ' ';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'editor',
                        name: 'editor',
                        render: function(data) {
                            if (!data || data.trim() === '') {
                                return ' ';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                dom: '<"row"<"col-md-4"l><"col-md-4"B><"col-md-4"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
                buttons: [
                    'copy', 'csv', 'print', 'excel'
                ],
                order: [
                    [0, 'desc']
                ]
            });

        });
        $(document).ready(function() {
            $(document).on('click', '.deleteNuReport', function() {
                var id = $(this).data('id');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                Swal.fire({
                    icon: 'warning',
                    title: 'Are you sure?',
                    text: 'Want to delete this report !',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: 'nutritionist-visit/' + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                    .attr('content')
                            },
                            success: function(response) {
                                // Handle success response, e.g., remove item from UI
                                $('#nutritions_visitTable').DataTable().ajax
                                    .reload();
                                Swal.fire({

                                    icon: 'success',
                                    text: 'Report Deleted Successfully !',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000

                                })
                            },
                            error: function(xhr, status, error) {
                                // Handle error response
                                if (xhr.responseJSON && xhr.responseJSON
                                    .errors) {
                                    // If validation errors exist, display them
                                    var errors = xhr.responseJSON.errors;
                                    var errorMessage = '';

                                    for (var key in errors) {
                                        errorMessage += '- ' + errors[key]
                                            .join(
                                                '\n- ') +
                                            '\n'; // Accumulate error messages
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
        });
        $(document).off('click').on('click', '.editNuReport', function() {
            var editButton = $(this);
            var id = editButton.data('id');
            $.ajax({
                method: 'GET',
                url: 'nutritionist-visit/' + id + '/edit',
                success: function(response) {
                    $('body').append(response)
                    $('#nutriReportEditModal').modal('show'); // Show modal

                }
            })

        });
    </script>


@endsection
