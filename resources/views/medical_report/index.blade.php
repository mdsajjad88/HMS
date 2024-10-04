@extends('layouts.main')

@section('title', 'Patient visit')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-11"></div>
            <div class="col-md-1">
                <a href="{{url('create/medical/report/')}}"  class="btn btn-dark btn-sm m-1"><i class="fa-solid fa-plus"></i>Add</a>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <table class="table table-striped data-table fs-9" id="reportTable">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Patient Name</th>
                            <th>Doctor Name</th>
                            <th>Contact</th>
                            <th>Better?</th>
                            <th>comment</th>
                            <th>Visit date</th>
                            <th>Visit No </th>
                            <th>Session Visite</th>
                            <th>S.V No</th>
                            <th>Problems</th>
                            <th class="added_by">Added by</th>
                            <th>Updated by</th>
                            <th>Actions</th>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#reportTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('medical-report.index') }}",
                columns: [
                    {
                        data: null,

                        render: function (data, type, row, meta) {
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
                        render: function(data) {
                            if (!data || data.trim() === '') {
                                return 'no name';
                            }
                            return data;
                        }

                    },
                    {
                        data: 'mobile',
                        name: 'mobile',
                    },
                    {
                        data: 'physical_improvement',
                        name: 'physical_improvement',
                        render: function(data) {
                            if (data == 1) {
                                return 'Yes';
                            } else if (data == 0) {
                                return 'No';
                            } else {
                                return 'First visit';
                            }
                        },

                    },

                    {
                        data: 'comment',
                        name: 'comment',
                    },
                    {
                        data: 'last_visited_date',
                        name: 'last_visited_date',
                    },
                    {
                        data: 'no_of_visite',
                        name: 'no_of_visite',
                    },

                    {
                        data: 'is_session_visite',
                        name: 'is_session_visite',

                        render: function(data) {
                            if (data == 1) {
                                return 'Yes';
                            } else{
                                return 'No';
                            }
                        }
                    },
                    {
                        data:'session_visite_count',
                        name:'session_visite_count',

                    },
                    {
                        data: 'problems',
                        name: 'problems',

                    },
                    {
                        data: 'user_name',
                        name: 'user_name',

                    },
                    {
                        data: 'editor_name',
                        name: 'editor_name',
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
                dom: '<"row"<"col-md-4"l><"col-md-4"B><"col-md-4"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>', // Layout definition
                buttons: [
            'copy','csv','print', 'excel','pdf' // Buttons configuration
        ],
        order: [[0, 'desc']]
            });

        });


        $(document).ready(function(){
            $(document).off('click').on('click', '.editReport', function(){
            var id = $(this).data('id');
                $.ajax({
                    url:'medical-report/'+id +'/edit',
                    method:'GET',
                    success:function(respons){
                        $('body').append(respons);
                        $('#reportEditModal').modal('show');
                    },
                });
            });
        });

        $(document).ready(function(){
            $(document).on('click', '.deleteReport', function(){
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
                            url: 'medical-report/'+id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                // Handle success response, e.g., remove item from UI
                                $('#reportTable').DataTable().ajax.reload();
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
@endsection
