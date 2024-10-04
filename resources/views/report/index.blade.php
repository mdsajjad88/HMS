@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <a href="javascript:void(0)" class="btn btn-success m-1" id="createNewReport">Create New Report</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col">
                <table class="table  data-table " id="reportTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient Name</th>
                            <th>Doctor Name</th>
                            <th>physical_improvement</th>
                            <th>comment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#reportTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('reportTableData') }}",
                columns: [{
                        data: 'id',
                        name: 'ID'
                    },
                    {
                        data: 'patient_name',
                        name: 'Name'
                    },
                    {
                        data: 'doctor_name',
                        name: 'Doctor Name'
                    },
                    {
                        data: 'physical_improvement',
                        name: 'physical_improvement'
                    },
                    {
                        data: 'comment',
                        name: 'comment'
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
        $(document).on('click', '.deleteReport', function(){
                console.log('hkas')
                alert('hlaskjdflk')
            })

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


    </script>
@endsection
