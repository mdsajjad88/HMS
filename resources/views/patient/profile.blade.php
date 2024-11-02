
    <div class="modal fade" id="patientProfile" tabindex="-1" role="dialog" aria-labelledby="patientProfileLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="row modalHeader" style="text-align: center">
                    <div class="text-center">
                        <h4 class="modal-title">Patient Profile Summary</h4>
                    </div>
                </div>
                <div class="modal-body p-5">
                    <div class="row">

                        <div class="col-6">Patient name</div>
                        <div class="col-6" > <b id="patientName"></b> </div>
                    </div>
                    <div class="row mt-1">

                        <div class="col-6">First visit Date</div>
                        <div class="col-6" id="firstVisit"></div>

                    </div>
                    <div class="row mt-1">

                        <div class="col-6">Last visit Date</div>
                        <div class="col-6" id="lastVisit"></div>

                    </div>
                    <div class="row mt-1">

                        <div class="col-6">No of visit</div>
                        <div class="col-6" id="no_of_visit"></div>

                    </div>
                    <div class="row mt-1">

                        <div class="col-6">Subscription start date </div>
                        <div class="col-6" id="subscript_date"></div>

                    </div>
                    <div class="row mt-1">

                        <div class="col-6">Subscription visit </div>
                        <div class="col-6" id="subscription_visit"></div>

                    </div>
                    <div class="row mt-1">
                        <div class="col"><h4><u><b>Doctor seen:</b></u> </h4></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-2"></div>
                        <div class="col-8">
                            <table class="table" id="doctorTable">
                                <thead>
                                    <tr>
                                        <th>Doctor Name</th>
                                        <th>Visit count</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="col-2"></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col"><h4><u><b>Medicine given:</b></u></h4></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-2"></div>
                        <div class="col-8">
                            <table class="table">
                                <tr>
                                    <th>BD (total)</th>
                                    <th id="bd_total"></th>
                                    <th>Avg. per visit</th>

                                    <th id="bd_avg_per_visit">Avg. per visit</th>
                                </tr>
                                <tr>
                                    <th>US (total)</th>
                                    <th id="us_total"></th>
                                    <th>Avg. per visit</th>

                                    <th id="us_avg_per_visit">Avg. per visit</th>
                                </tr>
                            </table>
                        </div>
                        <div class="col-2"></div>

                    </div>

                    <div class="row mt-4">
                        <div class="col-2"></div>
                        <div class="col-4">Test given (total)</div>
                        <div class="col-4" id="total_test"></div>
                        <div class="col-2"></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-2"></div>
                        <div class="col-4">Total therapies given</div>
                        <div class="col-4" id="total_therapy"></div>
                        <div class="col-2"></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-2"></div>
                        <div class="col-4">Physical Improvement Summary (Yes/Total)</div>
                        <div class="col-2"><span id="physical_improvment_yes"></span> / <span id="physical_improvment_total"></span></div>
                        <div class="col-3"><p>Percentage <b><span id="physical_improvment_percent"></span></b></p></div>
                        <div class="col-2"></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col"><h4><u><b>Problems:</b></u></h4></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-2"></div>
                        <div class="col-8">
                            <table class="table" id="problemTable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Count</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="col-2"></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col"><h4><u><b>Comments:</b></u></h4></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-2"></div>
                        <div class="col-8">
                            <table class="table" id="commentTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Comment</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="col-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            // Clear previous content
            $('#patientName').empty();
            $('#firstVisit').empty();
            $('#no_of_visit').empty();
            $('#subscript_date').empty();
            $('#subscription_visit').empty();
            $('#bd_total').empty();
            $('#us_total').empty();
            $('#bd_avg_per_visit').empty();
            $('#us_avg_per_visit').empty();
            $('#total_test').empty();
            $('#total_therapy').empty();
            $('#physical_improvment_yes').empty();
            $('#physical_improvment_total').empty();
            $('#commentTable tbody').empty();
            $('#doctorTable tbody').empty();
            $('#problemTable tbody').empty();
            $('#physical_improvment_percent').empty();

            // Retrieve data passed from Blade
            var profile = @json($patientProfile);
            var firstVisit = @json($firstVisit);
            var no_of_visit = @json($noOfVisit);
            var reports = @json($reports);
            var lastReport = @json($lastReport);
            var subscript = @json($subscript);
            var bd_medicine = @json($bd_medicine);
            var us_medicine = @json($us_medicine);
            var no_of_test = @json($no_of_test);
            var totalImprovements = @json($total_improvement);
            var yesImprovements = @json($yes_improvement);
            var totalTherapy = @json($totalTherapy);
            var problems = @json($problems);

            // Fill in the profile details
            $('#patientName').text(profile.first_name);
            $('#firstVisit').text(firstVisit.last_visited_date);
            $('#lastVisit').text(firstVisit.last_visited_date);
            $('#no_of_visit').text(no_of_visit);

            if(subscript){
                $('#subscript_date').text(subscript.subscript_date);
            }
            else{
                $('#subscript_date').text('No subscription');
            }
            $('#subscription_visit').text(lastReport.session_visite_count);
            $('#bd_total').text(bd_medicine);
            $('#us_total').text(us_medicine);
            $('#bd_avg_per_visit').text((bd_medicine / no_of_visit).toFixed(2));
            $('#us_avg_per_visit').text((us_medicine / no_of_visit).toFixed(2));
            $('#total_test').text(no_of_test);
            $('#total_therapy').text(totalTherapy);
            $('#physical_improvment_yes').text(yesImprovements);
            $('#physical_improvment_total').text(totalImprovements);
            var parcent = (yesImprovements / totalImprovements) * 100;
            $('#physical_improvment_percent').text(parcent.toFixed(2) + "%");

            // Populate comments
            $.each(reports, function(index, item) {
                var commentText = item.comment ? item.comment : "no comment";
                var newRow = '<tr>' +
                    '<td>' + item.last_visited_date + '</td>' +
                    '<td>' +commentText + '</td>' +
                    '</tr>';
                $('#commentTable tbody').append(newRow);
            });

            // Collect and populate doctor information
            var doctors = [];
            $.each(reports, function(index, report) {
                if (report.doctor) {
                    var doctor = report.doctor;
                    if (!doctors.find(d => d.id === doctor.id)) {
                        doctors.push({
                            id: doctor.id,
                            name: doctor.name,
                            visit_count: reports.filter(r => r.doctor && r.doctor.id === doctor.id).length
                        });
                    }
                }
            });

            $.each(doctors, function(index, doctor) {
                var addRow = '<tr>' +
                    '<td>' + doctor.name + '</td>' +
                    '<td>' + doctor.visit_count + '</td>' +
                    '</tr>';
                $('#doctorTable tbody').append(addRow);
            });
            $.each(problems, function(index, problem) {
                var row = $('<tr>');
                row.append($('<td>').text(problem.name)); // Problem Name
                row.append($('<td>').text(problem.problem_count)); // Problem Count
                $('#problemTable tbody').append(row); // Append row to the table
            });
        });
    </script>
</body>
</html>
