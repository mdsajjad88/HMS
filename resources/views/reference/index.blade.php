@extends('layouts.main')
@section('title', 'Reference Wise Patient Reports')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h3 class="text-center">Reference wise Patient Report</h3>
                <p class="d-inline-flex gap-1 form-control">
                    <a class="btn form-control" data-bs-toggle="collapse" href="#collapseExample" role="button"
                        aria-expanded="false" aria-controls="collapseExample">
                        <b>Filter</b>
                    </a>
                </p>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="start_date">Start Date</label>
                                <input type="date" id="start_date" class="form-control">
                            </div>
                            <div class="col-sm-3">
                                <label for="end_date">End Date</label>
                                <input type="date" id="end_date" class="form-control">
                            </div>
                            <div class="col-sm-3">
                                <label for="specific_reference">Specific Reference</label>
                                <select name="reference_id" id="reference_id" class="form-control">
                                    <option value="">Select a reference</option>
                                    @foreach ($references as $reference)
                                        <option value="{{ $reference->id }}">{{ ucfirst($reference->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                <table class="table table-striped" id="reference_wise_patient">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Reference</th>
                            <th>Patient Name</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th id="total_reference_count">0</th>
                            <th id="total_patient_count">0</th>
                        </tr>
                    </tfoot>
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
            $('#reference_wise_patient').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('references.index') }}",
                    data: function(d) {
                        d.reference_id = $('#reference_id').val();
                        d.end_date = $('#end_date').val();
                        d.start_date = $('#start_date').val();
                    }
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'reference_name_with_count',
                        name: 'reference_name_with_count'
                    },
                    {
                        data: 'patient_info',
                        name: 'patient_info',
                    }
                ],

                dom: '<"row"<"col-md-4"l><"col-md-4"B><"col-md-4"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
                buttons: [{
                        extend: 'copy',
                        text: 'Copy'
                    },
                    {
                        extend: 'csv',
                        text: 'CSV'
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        title: 'Reference Wise Patient Report',
                        messageTop: function() {
                            var start_date = $('#start_date').val();
                            var end_date = $('#end_date').val();

                            function formatDate(date) {
                                var d = new Date(date);
                                var day = ("0" + d.getDate()).slice(-2);
                                var month = ("0" + (d.getMonth() + 1)).slice(-
                                    2);
                                var year = d.getFullYear();
                                return year + '-' + month + '-' + day;
                            }

                            var formattedStartDate = start_date ? formatDate(start_date) : '---';
                            var formattedEndDate = end_date ? formatDate(end_date) : '---';

                            var dateRangeMessage = 'Date Range: ' + formattedStartDate + ' To ' +
                                formattedEndDate;

                            var table = $('#reference_wise_patient').DataTable();
                            var totalReference = table.page.info()
                                .recordsDisplay;

                            var totalPatients = calculatePatients(table);
                            var welcomeMessage = 'Total Reference: ' + totalReference +
                                "; Total Patients: " + totalPatients;
                            return `
                            <div style="display: flex; justify-content: space-between; width: 100%;">
                                <span>${dateRangeMessage}</span>
                                <span style="text-align: right; font-size: 14px;">${welcomeMessage}</span>
                            </div>`;
                        },
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'Reference Wise Patient Reports',
                        messageTop: function(doc) {
                            var start_date = $('#start_date').val();
                            var end_date = $('#end_date').val();

                            // Helper function to format the date
                            function formatDate(date) {
                                var d = new Date(date);
                                var day = ("0" + d.getDate()).slice(-2);
                                var month = ("0" + (d.getMonth() + 1)).slice(-2);
                                var year = d.getFullYear();
                                return year + '-' + month + '-' + day;
                            }

                            // Format the start and end date
                            var formattedStartDate = start_date ? formatDate(start_date) : '---';
                            var formattedEndDate = end_date ? formatDate(end_date) : '---';
                            var dateRangeMessage = 'Date Range: ' + formattedStartDate + ' To ' +
                                formattedEndDate;

                            // Get the total patients and references from the DataTable
                            var table = $('#reference_wise_patient').DataTable();
                            var totalPatients = calculatePatients(table);
                            var totalReference = table.rows({
                                page: 'current'
                            }).count();

                            // Construct the "Total Reference" and "Total Patients" message
                            var welcomeMessage = 'Total Reference: ' + totalReference +
                                ' | Total Patients: ' + totalPatients;

                            return `${dateRangeMessage} \n ${welcomeMessage}`;
                        },
                        customize: function(doc) {
                            doc.footer = {
                                text: 'Generated at: ' + new Date().toLocaleString(),
                                alignment: 'center',
                                fontSize: 8
                            };
                        }
                    },

                    {
                        extend: 'excel',
                        text: 'Excel'
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();
                    var totalReference = api.data().count();
                    $('#total_reference_count').text("Reference " + totalReference);

                    var totalPatients = calculatePatients(api);

                    $('#total_patient_count').text('Total Patient ' + totalPatients);

                }
            });

            $(document).on('change', '#reference_id, #start_date, #end_date', function() {
                $('#reference_wise_patient').DataTable().ajax.reload();
            });

            function calculatePatients(api) {
                var totalPatients = 0;
                api.column(2, {
                    page: 'current'
                }).data().each(function(value, index) {
                    if (value) {
                        var patients = value.split(',');

                        patients.forEach(function(patient) {
                            var phoneMatch = patient.match(/\(\d{11}\)/);

                            if (phoneMatch) {
                                var phoneNumber = phoneMatch[0].slice(1, -1);
                                if (phoneNumber.length === 11 && /^\d{11}$/.test(
                                        phoneNumber)) {
                                    totalPatients++;
                                }
                            }
                        });
                    }
                });

                return totalPatients;
            }

        });
    </script>
@endsection
