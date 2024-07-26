<div class="modal fade" id="doctorView" tabindex="-1" aria-labelledby="doctorViewLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content ">
            <div class="modal-body modalHeader" id="printableArea">
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
                                <option value="1">This Month </option>
                                <option value="previous">Previous Months </option>
                                <option value="6">6 Months</option>
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
                    <div class="col-4"><label for="total_therapy">Total patient</label></div>
                    <div class="col-8">
                        <h3 name="total_patient" id="total_patient"> </h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <label for="bd_medicine" class="form-label">Total BD Medicine</label>
                    </div>
                    <div class="col-3">
                        <h3 id="bd_medicine" class="d-flex"></h3>

                    </div>
                    <div class="col-3">
                        <p class="d-flex"> Avg. <span id="avg_bd_medicine">00</span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="us_medicine" class="form-label">Total US Medicine</label>
                    </div>
                    <div class="col-3">
                        <h3 id="us_medicine" class="d-flex"></h3>
                    </div>
                    <div class="col-3">
                        <p class="d-flex"> Avg. <span id="avg_us_medicine">00</span></p>
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
                            Ozone therapy(<span id="no_of_ozone_therapy"></span>), Hijama therapy (<span id="no_of_hijama_therapy"></span>), <br> Acupuncture(<span id="on_of_acupuncture"></span>), Physiotherapy(<span id="no_of_physiotherapy"></span>), <br> Coffee enemas(<span id="no_of_coffee_anema"></span>), Phototherapy(<span id="no_of_phototherapy"></span>), <br> Sauna therapy(<span id="no_of_sauna"></span>),
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

            var selectedProblemIds = selectedProblem.map(function(problem) {
                return problem.id;
            });
            var filteredProblems = allProblems.filter(function(problem) {
                return selectedProblemIds.includes(problem.id);
            });
            $.each(filteredProblems, function(key, problem) {
                problemsSelect.append(problem.name + ', ');
            });


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
            var total_patient = "<?php echo $total_patient; ?>";
            var bd_medicine = "<?php echo $bd_medicine ?>";
            var us_medicine = "<?php echo $us_medicine ?>";

            $("#bd_medicine").text(bd_medicine);
            $("#us_medicine").text(us_medicine);

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
