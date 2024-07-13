@extends('layouts.app')
@section('content')
<div class="container">
<div class="row">
    <div class="col-md-11"></div>
    <div class="col-md-1">
        <button class="addPatient btn btn-primary btn-sm m-1"><i class="fa-solid fa-plus"></i>Add</button>
    </div>
</div>
<div class="row">
    <div class="col">
        <section id="patientSection">
            <table id="patientTable" class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Mobile</th>

                        <th>Blood</th>

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
            { data: 'id', name: 'id' },
            { data: 'first_name', name: 'first_name' },
            { data: 'last_name', name: 'last_name' },
            { data: 'email', name: 'email' },
            { data: 'mobile', name: 'mobile' },
            { data: 'blood_group', name: 'blood_group' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        dom: '<"row"<"col-md-4"l><"col-md-4"B><"col-md-4"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>', // Layout definition
        buttons: [
            'copy','csv','print' // Buttons configuration
        ],
        language: {
            searchPlaceholder: 'Search...', // Change search placeholder text

        },

    });



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
                url: '/deletePatient/' + id, // Replace with your actual delete route
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
                // Handle error response
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    // If validation errors exist, display them
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = '';

                    for (var key in errors) {
                        errorMessage += '- ' + errors[key].join('\n- ') + '\n'; // Accumulate error messages
                    }
                    Swal.fire({
                        title: 'error!',
                        text: errorMessage,
                        icon: 'error', // 'success', 'error', 'warning', 'info', 'question'
                        confirmButtonText: 'OK',
                        timer:2000
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
                url: '/editPatient/' + patientId,
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

});
</script>
@endsection
