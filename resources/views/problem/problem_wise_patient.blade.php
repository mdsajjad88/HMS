@extends('layouts.main')
@section('title', 'Diseases Wise Patient Reports')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h2>Diseases Wise Patient Reports</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped data-table fs-9" id="diseases_wise_patient_table">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Diseases Name</th>
                            <th>Patient Name</th>

                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated by DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#diseases_wise_patient_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('problem.wise.patient') }}",
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
