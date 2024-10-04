@extends('layouts.main')

@section('title', 'Patients')
@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-md-11"></div>
    <div class="col-md-1">
        <button class="addPatient btn btn-dark btn-sm m-1"><i class="fa-solid fa-plus"></i>Add</button>
    </div>
</div>
<div class="row">
    <div class="col">
        <section id="patientSection">
            <table id="patientTable" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>City</th>
                        <th>Added by</th>
                        <th>Action</th>
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
$(document).ready(function(){

    $('#patientTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('patient_profiles.index') }}",
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'first_name', name: 'first_name' },
            {
                data: 'patient_type_id',
                name: 'patient_type_id',
                render: function(data) {
                            if (data == 3) {
                                return '3 Month Session';
                            } else if (data == 33) {
                                return '3 Month Regular';
                            } else if (data == 6) {
                                return '6 Month Regular';
                            }
                            else if (data == 1) {
                                return 'not subscribed';
                            }
                            else if (data == null) {
                                return ' ';
                            }
                        },
            },
            { data: 'email', name: 'email' },
            { data: 'mobile', name: 'mobile' },
            { data: 'age', name: 'age' },
            { data: 'gender', name: 'gender' },


            { data: 'district_name', name: 'district_name' },
            { data: 'user_name', name: 'user_name' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        dom: '<"row"<"col-md-4"l><"col-md-4"B><"col-md-4"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>', // Layout definition
        buttons: [
            'copy','csv','print', 'excel','pdf'
        ],
        language: {
            searchPlaceholder: 'Search...', // Change search placeholder text

        },
        order: [[0, 'desc']]

    });



        function addNewPatient(){
            $.ajax({
                method: 'GET',
                url: '{{route("patient-profile.create")}}',
                cache: false,
                success: function(response) {
                    $('body').append(response);
                    $('#patientModal').modal({backdrop: 'static', keyboard: false});
                    $('#patientModal').modal('show'); // Show modal

                }
            })
        }
        $('.addPatient').on('click', function(){
            addNewPatient();

        });




    $(document).off('click').on('click', '.deletePatient', function() {
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
                url: 'deletePatient/' + id, // Replace with your actual delete route
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Handle success response, e.g., remove item from UI
                    $('#patientTable').DataTable().ajax.reload();
                    Swal.fire({

                    icon:'info',
                    text: 'Doctor Profile Deleted Successfully !',
                    toast: true,
                    position:'top-end',
                    showConfirmButton: false,
                    timer:2000

                    })


                },
                error: function(xhr, status, error) {
                    var errorMessage = '';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += xhr.responseJSON.message;
                    } else {
                        errorMessage += status;
                    }

                    Swal.fire({
                                icon: 'error',
                                title: 'Opps',
                                text: errorMessage,
                                confirmButtonText: 'OK',

                            });
                    }
            });
            } else {
                // Cancelled deletion
                Swal.fire({
                    text: 'Deletion cancelled!!',
                    icon: 'info', // 'success', 'error', 'warning', 'info', 'question'
                    toast:true,
                    confirmButtonText: false,
                    showConfirmButton: false,
                    position:'top-end',
                    timer:2000
                });

            }

            })
            })
            function patientProfileEdit(patientId) {
            $.ajax({
                method: 'GET',
                url: 'patient-profile/' + patientId + '/edit',
                success: function(response) {
                    $('body').append(response)
                    $('#updatePatientModal').modal('show'); // Show modal
                }
            })
        }
        $(document).on('click', '.editPatient', function(){

            var patientId = $(this).data('id');
            patientProfileEdit(patientId);
        })
        $(document).on('click', '.viewPatientProfile', function(){
            var id = $(this).data('id');
            $.ajax({
                method: 'GET',
                url: 'patient-profile/' + id,
                success: function(response) {
                    $('body').append(response)
                    $('#patientProfile').modal('show'); // Show modal
                }
            })
        })

});
</script>
@endsection
