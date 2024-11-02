@extends('layouts.main')
@section('title', 'Comment Wise Patient Reports')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h2>Comment Wise Patient Reports</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped data-table fs-9" id="comment_wise_patient_table">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Comment Name</th>
                            <th>Description</th>
                            <th>Patient Name</th>
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
            $('#comment_wise_patient_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('comment.wise.patient') }}",
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',

                    },
                    {
                        data: 'description',
                        name: 'description',

                    },
                    {
                        data: 'patient_info', // Use the new patient_info column
                        name: 'patient_info',
                    },

                ],

                dom: '<"row"<"col-md-4"l><"col-md-4"B><"col-md-4"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>', // Layout definition
                buttons: [
                    'copy', 'csv', 'print', 'excel', 'pdf' // Buttons configuration
                ],
                order: [
                    [0, 'desc']
                ]
            });
        });
    </script>
@endsection
