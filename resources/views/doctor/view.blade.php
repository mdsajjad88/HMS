<div class="modal fade" id="doctorView" tabindex="-1" aria-labelledby="doctorViewLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content ">
            <div class="modal-body modalHeader p-5" id="printableArea">
                <div class="row" style="text-align: center">
                    <div class="text-center">
                        <h5 class="modal-title mb-0" id="doctorName"></h5>
                    </div>


                    <div class="row">
                        <div class="col-6">
                            <h5 class="modal-title mb-0">Report Details :</h5>
                        </div>
                        <div class="col-6 d-print-none">
                            <select name="days" id="days" class="form-control">
                                <option value="1">Last 30 Days </option>
                                <option value="2">Last 60 Days</option>
                                <option value="9">Last 90 Days</option>
                                <option value="12">1 Year</option>
                                <option value="all">All Time</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="text-center">
                        <span id="startDate"></span>
                        to
                        <span id="endDate"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4"><label for="total_patient">Total patient</label></div>
                    <div class="col-8">
                        <h3 name="total_patient" id="total_patient"> </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4"><label for="total_therapy">Total Visite's</label></div>
                    <div class="col-8">
                        <h3 name="total_visite" id="total_visite"> </h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <label for="bd_medicine" class="form-label">Total BD Medicine</label>
                    </div>
                    <div class="col-2">
                        <h3 id="bd_medicine" class="d-flex"></h3>
                    </div>

                    <div class="col-3">
                        <p class="d-flex">BD per patient Avg. : <span id="avg_bd_pro"></span></p>
                    </div>
                    <div class="col-3">
                        <p class="d-flex">Overall proportion. : <span id="bd_overall"></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="us_medicine" class="form-label">Total US Medicine</label>
                    </div>
                    <div class="col-2">
                        <h3 id="us_medicine" class="d-flex"></h3>
                    </div>

                    <div class="col-3">
                        <p class="d-flex">US per patient Avg. : <span id="avg_us_pro"></span></p>
                    </div>
                    <div class="col-3">
                        <p class="d-flex">Overall proportion. : <span id="us_overall"></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="us_medicine" class="form-label">Total Test</label>
                    </div>
                    <div class="col-8">
                        <h3 id="no_of_test" class="d-flex"></h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4 d-flex align-items-center">
                        <div>
                            <label for="total_therapy">Total Therapy</label>
                        </div>
                    </div>
                    <div class="col-8 d-flex align-items-center">
                        <h3 id="total_therapy" class="mb-0 me-2"></h3>
                        <small style="text-align: justify">
                            Ozone therapy(<span id="no_of_ozone_therapy"></span>), Hijama therapy (<span id="no_of_hijama_therapy"></span>),  Acupuncture(<span id="on_of_acupuncture"></span>), Physiotherapy(<span id="no_of_physiotherapy"></span>),  Coffee enemas(<span id="no_of_coffee_anema"></span>), Phototherapy(<span id="no_of_phototherapy"></span>),  Sauna therapy(<span id="no_of_sauna"></span>),
                        </small>
                    </div>

                </div>
                <div class="row">
                    <div class="col-4 d-flex align-items-center">
                        <div>
                            <label for="total_problem">Total Problems</label>
                        </div>
                    </div>
                    <div class="col-8 d-flex align-items-center">
                        <h3 id="total_problem" class="mb-0 me-2"></h3>
                        <small id="allProblems">

                        </small>
                    </div>

                </div>
            </div>
            <div class="modal-footer modalFooter">
                <button type="button" class="btn btn-primary" id="printModal">Print</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
            </div>
        </div>

    </div>
</div>




<script>
    $(document).ready(function() {

        function printModal() {
            var printContent = document.getElementById('printableArea').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContent;

            window.print();

            document.body.innerHTML = originalContents;
            location.reload(); // Reload the page to reinitialize Bootstrap modal
        }
        $('#printModal').on('click', function() {
            printModal();
        })
        $("#doctorName").empty();
        var doctor = '<?php echo $doctor->first_name . ' ' . $doctor->last_name; ?>';
        $("#doctorName").append('Dr. ' + doctor);
        function valueSetting(){
            var problemsSelect = $('#allProblems');
            problemsSelect.empty();

            var selectedProblem = @json($problems);
            var allProblems = @json($allProblems);
            var counting = @json($problemCounts);

            var problemCounts = {}; // Object to store counts by problem ID

            // Fill problemCounts object
            $.each(counting, function(problemId, count) {
                problemCounts[problemId] = count;
            });

            // Build the HTML to display problem counts
            var html = '';
            $.each(allProblems, function(index, problem) {
                var problemId = problem.id;
                var problemName = problem.name;
                $(`#problem_${problemId}`).empty();
                html += `<span> ${problemName} (<span id="problem_${problemId}">${problemCounts[problemId] || 0}</span>) </span>, `;
            });

            problemsSelect.html(html);


            $("#total_patient").empty();
            $('#no_of_test').text("<?php echo $no_of_test; ?>");
            $('#no_of_medicine').text("<?php echo $no_of_medicine; ?>");
            $('#no_of_ozone_therapy').text("<?php echo $no_of_ozone_therapy; ?>");
            $('#no_of_hijama_therapy').text("<?php echo $no_of_hijama_therapy; ?>");
            $('#on_of_acupuncture').text("<?php echo $on_of_acupuncture; ?>");
            $('#no_of_sauna').text("<?php echo $no_of_sauna; ?>");
            $('#no_of_physiotherapy').text("<?php echo $no_of_physiotherapy; ?>");
            $('#no_of_coffee_anema').text("<?php echo $no_of_coffee_anema; ?>");
            $('#no_of_phototherapy').text("<?php echo $no_of_phototherapy; ?>");
            $('#total_problem').text("<?php echo $totalProblems; ?>");
            $('#days').val("<?php echo $days; ?>");
            $('#total_visite').text('<?php echo $total_visite ?>');
            $('#startDate').val('')
            $('#startDate').text("<?php echo $startDate; ?>");
            $('#endDate').text('<?php echo $endDate; ?>');

            var no_of_ozone_therapy = parseInt("<?php echo $no_of_ozone_therapy; ?>");
            var no_of_hijama_therapy = parseInt("<?php echo $no_of_hijama_therapy; ?>");
            var on_of_acupuncture = parseInt("<?php echo $on_of_acupuncture; ?>");
            var no_of_sauna = parseInt("<?php echo $no_of_sauna; ?>");
            var no_of_physiotherapy = parseInt("<?php echo $no_of_physiotherapy; ?>");
            var no_of_coffee_anema = parseInt("<?php echo $no_of_coffee_anema; ?>");
            var no_of_phototherapy = parseInt("<?php echo $no_of_phototherapy; ?>");
            var total_patient = parseFloat(("<?php echo $total_patient; ?>"), 2);
            var bd_medicine = parseFloat(("<?php echo $bd_medicine; ?>"));
            var us_medicine = parseFloat(("<?php echo $us_medicine; ?>"));
            var medicine = bd_medicine + us_medicine;
            if (medicine === 0) {
                bd_avg = " 0.00";
                us_avg = " 0.00";
                bd_avg_pro = " 0.00";
                us_avg_pro = " 0.00";
                bd_overall = " 0.00%";
                us_overall = " 0.00%";
            } else {
                bd_overall = ((bd_medicine/medicine)*100).toFixed(2)+"%";
                us_overall = ((us_medicine/medicine)*100).toFixed(2)+"%";
                bd_avg_pro = (bd_medicine/total_patient).toFixed(2);
                us_avg_pro = (us_medicine/total_patient).toFixed(2);
            }
            $("#bd_medicine").text(bd_medicine);
            $("#us_medicine").text(us_medicine);
            $('#avg_bd_pro').text(bd_avg_pro);
            $('#avg_us_pro').text(us_avg_pro);
            $('#bd_overall').text(bd_overall);
            $('#us_overall').text(us_overall);

            $("#total_patient").text(total_patient);
            $('#total_therapy').text(no_of_ozone_therapy + no_of_hijama_therapy + on_of_acupuncture + no_of_sauna +
                no_of_physiotherapy + no_of_coffee_anema + no_of_phototherapy);

        }

        valueSetting();

        $(document).off('change').on('change', '#days', function() {

            var day = $(this).val();
            var id = "<?php echo $id; ?>";

            $.ajax({
                method: 'GET',
                url: 'viewDoctor/' + id + '/' + day,
                success: function(response) {
                    $('body').append(response)
                    $('#doctorView').modal('show');
                    $('#startDate').text("<?php echo $startDate; ?>");
                    $('#endDate').text('<?php echo $endDate; ?>');
                    valueSetting();

                }

            });
        })

    });
</script>
