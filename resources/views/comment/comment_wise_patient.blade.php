@extends('layouts.main')
@section('title', 'Comment Wise Patient Reports')
@section('content')
    <style>
        .c_name {
            min-width: 155px;
        }
        .select2-container {
            width: 100% !important;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h2 class="text-center">Comment Wise Patient Reports</h2>
            </div>
        </div>
        <p class="d-inline-flex gap-1 form-control">
            <a class="btn form-control" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                aria-controls="collapseExample">
                <b>Filter</b>
            </a>
        </p>
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <!-- Filter Form -->
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
                        <label for="comment_id">Specific Comment</label>
                        <select name="comment_id" id="specific_comment" class="form-control select2">
                            <!-- corrected select2 typo -->
                            <option value="">Select a Comment</option>
                            @foreach ($comments as $comment)
                                <option value="{{ $comment->id }}">{{ $comment->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped data-table fs-9" id="comment_wise_patient_table">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th class="c_name">Comment Name</th>
                            <th>Description</th>
                            <th>Patient Name</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th id="total_comment_count">0</th>
                            <th></th>
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
            var table = $('#comment_wise_patient_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('comment.wise.patient') }}",
                    data: function(d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.comment_id = $('#specific_comment').val();
                    }
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'comment_name_with_count',
                        name: 'comment_name_with_count',
                    },
                    {
                        data: 'comment_description',
                        name: 'comment_description',
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
                        title: 'Comment Wise Patient Reports',
                        messageTop: function() {
                            var start_date = $('#start_date').val();
                            var end_date = $('#end_date').val();

                            function formatDate(date) {
                                var d = new Date(date);
                                var day = ("0" + d.getDate()).slice(-2);
                                var month = ("0" + (d.getMonth() + 1)).slice(-
                                    2); // Months are zero-based
                                var year = d.getFullYear();
                                return year + '-' + month + '-' + day;
                            }

                            var formattedStartDate = start_date ? formatDate(start_date) : '---';
                            var formattedEndDate = end_date ? formatDate(end_date) : '---';

                            var dateRangeMessage = 'Date Range: ' + formattedStartDate + ' To ' +
                                formattedEndDate;
                            var table = $('#comment_wise_patient_table').DataTable();

                            var totalComments = table.rows({
                                page: 'current'
                            }).count();
                            var totalPatients = calculatePatients(table);
                            var welcomeMessage = 'Total Comment: ' + totalComments +
                                "; Total Patients: " + totalPatients;
                            return `
                            <div style="display: flex; justify-content: space-between; width: 100%;">
                                <span>${dateRangeMessage}</span>
                                <span style="text-align: right; font-size: 14px;">${welcomeMessage}</span>
                            </div>`;
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
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'Comment Wise Patient Reports',
                        messageTop: function() {
                            var start_date = $('#start_date').val();
                            var end_date = $('#end_date').val();

                            function formatDate(date) {
                                var d = new Date(date);
                                var day = ("0" + d.getDate()).slice(-2);
                                var month = ("0" + (d.getMonth() + 1)).slice(-
                                    2); // Months are zero-based
                                var year = d.getFullYear();
                                return year + '-' + month + '-' + day;
                            }

                            var formattedStartDate = start_date ? formatDate(start_date) : '---';
                            var formattedEndDate = end_date ? formatDate(end_date) : '---';

                            var dateRangeMessage = 'Date Range: ' + formattedStartDate + ' To ' +
                                formattedEndDate;
                            var table = $('#comment_wise_patient_table').DataTable();

                            var totalComments = table.rows({
                                page: 'current'
                            }).count();
                            var totalPatients = calculatePatients(table);
                            var welcomeMessage = 'Total Comment: ' + totalComments +
                                "; Total Patients: " + totalPatients;
                            return `
                                ${dateRangeMessage} \n
                                Total Comment: ${totalComments} | Total Patients: ${totalPatients} \n
                            `;
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
                    var totalComments = api.data().count();
                    $('#total_comment_count').text("Comment " + totalComments);
                    var totalPatients = calculatePatients(api);
                    $('#total_patient_count').text('Total Patient ' + totalPatients);
                }
            });

            $(document).on('change', '#start_date, #end_date, #specific_comment', function() {
                $('#comment_wise_patient_table').DataTable().ajax.reload();
            });
            $('#specific_comment').select2({
                placeholder: "Select comments",
            });

            function calculatePatients(api) {
                var totalPatients = 0;

                api.column(3, {
                    page: 'current'
                }).data().each(function(value, index) {
                    if (value) {
                        var patients = value.split(',');

                        patients.forEach(function(patient) {
                            var phoneMatch = patient.match(/\((\d{11})\/\d{4}-\d{2}-\d{2}\)/);
                            if (phoneMatch) {
                                var phoneNumber = phoneMatch[1];

                                if (phoneNumber.length === 11 && /^\d{11}$/.test(phoneNumber)) {
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
