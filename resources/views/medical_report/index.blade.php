@extends('layouts.app')

@section('title', 'Medical report')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-11"></div>
            <div class="col-md-1">
                {{-- <a  class="btn btn-success btn-sm m-1" id="createNewReport">Create New Report</a> --}}
                <a href="{{url('create/medical/report')}}"  class="btn btn-dark btn-sm m-1" id="createNewReport"><i class="fa-solid fa-plus"></i>Add</a>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <table class="table  data-table " id="reportTable">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Patient Name</th>
                            <th>Doctor Name</th>
                            <th>Improvement</th>
                            <th>comment</th>
                            <th>Visite No </th>
                            <th>Last Visite</th>
                            <th>Problems</th>
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
                columns: [{
                        data: 'id',
                        name: 'ID'
                    },
                    {
                        data: 'patient_name',
                        name: 'patient_name'
                    },
                    {
                        data: 'doctor_name',
                        name: 'doctor_name'
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
                        }
                    },
                    {
                        data: 'comment',
                        name: 'comment'
                    },
                    {
                        data: 'no_of_visite',
                        name: 'no_of_visite'
                    },
                    {
                        data: 'last_visited_date',
                        name: 'last_visited_date'
                    },
                    {
                        data: 'problems',
                        name: 'problems'
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



            });

            $('#createNewReport').click(function(){
                var id = $(this).data('id');
                $.ajax({
                    url:'{{route("medical-report.create")}}',
                    method:'GET',
                    success:function(respons){
                        $('body').append(respons);
                        $('#reportCreateModal').modal('show');
                    },
                });
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
                            url: '/medical-report/'+id,
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
