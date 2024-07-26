@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <a href="javascript:void(0)" class="btn btn-success m-1" id="patientTestCreate">New Test </a>
            </div>
        </div>
        <table class="table" id="patientTest">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>status</th>
                    <th>amount</th>
                    <th>action</th>
                </tr>
            </thead>
        </table>
    </div>

@endsection
@section('scripts')
<script>

    $(document).ready(function(){
     $('#patientTest').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('patient-medical-tests.index') }}",
                columns: [
                    {
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
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
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
                    'copy', 'csv', 'print' // Buttons configuration
                ],



    });

    $('#patientTestCreate').on('click', function(){
                $.ajax({
                    url:'{{route("patient-medical-tests.create")}}',
                    method:'GET',
                    success:function(respons){
                        $('body').append(respons);
                        $('#patientTestCreateModal').modal('show');
                    },
                });
            });

})

</script>
@endsection
