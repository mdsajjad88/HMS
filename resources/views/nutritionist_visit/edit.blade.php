<div class="modal fade" id="nutriReportEditModal" tabindex="-1" aria-labelledby="nutritionistEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modalHeader">
                <h5 class="modal-title" id="nutritionistEditModalLabel">Edit Patient Report By Nutritionist</h5>
                <button type="button" class="btn-close" id="closeModal" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Form -->
                <form id="reportEditByNu" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <!-- Hidden Input -->
                        <input type="hidden" id="visit-id" name="id">

                        <!-- Problems -->
                        <div class="col-11">
                            <label for="problem" class="form-label">Problems <span id="star">*</span></label>
                            <select name="problem_id[]" id="problems" class="multipleProblem form-control" multiple required></select>
                        </div>
                        <div class="col-1">
                            <label for="problemadd" class="form-label"></label>
                            <button class="btn btn-primary addnewproblem mt-2">Add</button>
                        </div>

                        <!-- Type of Consultant -->
                        <div class="col-12">
                            <label for="type_of_consultant" class="form-label">Type Of Nutritionist Consultation <span id="star">*</span></label>
                            <select name="type_of_consultant" id="type_of_consultant" class="form-control">
                                <option value="">Select an option</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="53">53</option>
                                <option value="54">54</option>
                                <option value="544">544</option>
                                <option value="55">55</option>
                                <option value="65">65</option>
                                <option value="75">75</option>
                                <option value="58">58</option>
                                <option value="59">59</option>
                                <option value="599">599</option>
                                <option value="5999">5999</option>
                                <option value="5565">5565</option>
                                <option value="567">567</option>
                                <option value="5777">5777</option>
                            </select>
                        </div>

                        <!-- Challenges Faced -->
                        <div class="col-11">
                            <label for="challanced_faced" class="form-label">Reasons why unable to maintain diet/Challenges faced <span id="star">*</span></label>
                            <select id="challanced_faced" name="challanced_faced[]" class="form-control  multipleChallenge" required multiple>

                            </select>
                        </div>
                        <div class="col-1">
                            <label for="chanllegeAdd" class="form-label"></label>
                            <button class="btn btn-primary chanllegeAdd mt-2">Add</button>
                        </div>
                        <div class="col-12">
                            <div class="text-center">(1 = Very Low), (2 = Low), (3 = Medium), (4 = High), (5 = Very High)</div>
                        </div>

                        <!-- Diet Plan Status -->
                        <div class="col-12 p-2">
                            <label for="diet_plan_status" class="form-label">Adherence to given diet plan <span id="star">*</span></label>
                            <div class="radio-group">
                                <label><input type="radio" name="diet_plan_status" value="1" required> 1 </label>
                                <label><input type="radio" name="diet_plan_status" value="2" required> 2</label>
                                <label><input type="radio" name="diet_plan_status" value="3" required> 3</label>
                                <label><input type="radio" name="diet_plan_status" value="4" required> 4</label>
                                <label><input type="radio" name="diet_plan_status" value="5" required> 5</label>
                            </div>
                        </div>

                        <!-- Diet Plan Satisfaction -->
                        <div class="col-12 p-2">
                            <label for="diet_plan_satisfaction" class="form-label">Diet Plan Satisfaction <span id="star">*</span></label>
                            <div class="radio-group">
                                <label><input type="radio" name="diet_plan_satisfaction" value="1" required> 1</label>
                                <label><input type="radio" name="diet_plan_satisfaction" value="2" required> 2</label>
                                <label><input type="radio" name="diet_plan_satisfaction" value="3" required> 3</label>
                                <label><input type="radio" name="diet_plan_satisfaction" value="4" required> 4</label>
                                <label><input type="radio" name="diet_plan_satisfaction" value="5" required> 5</label>
                            </div>
                        </div>
                        <div class="col-12 p-2">
                            <label for="treatment_satisfaction" class="form-label">Treatment Satisfaction <span id="star">*</span></label>
                                <div class="radio-group">
                                    <label><input type="radio" name="treatment_satisfaction" value="1" required> 1</label>
                                    <label><input type="radio" name="treatment_satisfaction" value="2" required> 2</label>
                                    <label><input type="radio" name="treatment_satisfaction" value="3" required> 3</label>
                                    <label><input type="radio" name="treatment_satisfaction" value="4" required> 4</label>
                                    <label><input type="radio" name="treatment_satisfaction" value="5" required> 5</label>
                                </div>
                        </div>

                        <!-- Suggestion for Improvement -->
                        <div class="col-12">
                            <label for="suggetion_for_improvement" class="form-label">Suggestion for improvement/Adjustments <span id="star">*</span></label>
                            <textarea name="suggetion_for_improvement" id="suggetion_for_improvement" rows="2" class="form-control"></textarea>
                        </div>

                        <!-- Visit Duration -->
                        <div class="col-12">
                            <label for="visit_duration" class="form-label">Visit Duration (Minutes) <span id="star">*</span></label>
                            <input type="number" class="form-control" id="visit_duration" name="visit_duration" placeholder="Enter the total visit time in minutes" required>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer modalFooter d-print-none">
                            <button type="reset" class="btn btn-secondary">Reset</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.addnewproblem').click(function(){
            $.ajax({
                    type: 'GET',
                    url: '{{ route("problems.create") }}',
                    success: function(respons) {
                        $('body').append(respons);
                        $('#problemCreating').modal('show');
                    }
                })
        });
        $('.chanllegeAdd').click(function(){
            $.ajax({
                    type: 'GET',
                    url: '{{ route("challenges.create") }}',
                    success: function(respons) {
                        $('body').append(respons);
                        $('#challengeCreating').modal('show');
                    }
                })
        });
        $('#problems').empty();
        $('#challanced_faced').empty();
        var visit = @json($report);
        $('#visit-id').val(visit.id);
        $('#type_of_consultant').val(visit.type_of_consultant).trigger('change');
        $('#challanced_faced').val(visit.challanced_faced).trigger('change');
        $('input[name="diet_plan_status"][value="' + visit.diet_plan_status + '"]').prop('checked', true);
        $('input[name="diet_plan_satisfaction"][value="' + visit.diet_plan_satisfaction + '"]').prop('checked', true);
        $('input[name="treatment_satisfaction"][value="' + visit.treatment_satisfaction + '"]').prop('checked', true);
        $('#suggetion_for_improvement').val(visit.suggetion_for_improvement);
        $('#visit_duration').val(visit.visit_duration);
        // Initialize select2 for problems
        $('#problems').select2({
            placeholder: "Select problems",
            allowClear: true
        });
        $('#challanced_faced').select2({
            placeholder: "Select problems",
            allowClear: true
        });

        // Initialize select2 for type_of_consultant
        // Populate the problems dropdown
        var selectedProblems = @json($selectedProblems);
        var problems = @json($problems);
        var challenges = @json($challenges);
        var selectChallenges = @json($selectChallenge);
        $.each(problems, function(index, problem) {
            $('#problems').append('<option value="' + problem.id + '">' + problem.name + '</option>');
        });
        $.each(challenges, function(index, challenge) {
            $('#challanced_faced').append('<option value="' + challenge.id + '">' + challenge.name + '</option>');
        });
        // Set selected values
        $('#problems').val(selectedProblems).trigger('change');
        $('#challanced_faced').val(selectChallenges).trigger('change');

        $('#reportEditByNu').off('submit').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            var asd = $(".treatment").val();
            var submitBtn = $(this).find('button[type="submit"]');
            submitBtn.prop('disabled', true);

            var form = $('#reportEditByNu')[0];
            var formData = new FormData(form);

            // Get the nutritionist ID from the hidden input
            var id = $('#visit-id').val();

            // Construct the URL with the ID
            var url = "{{ route('nutritionist-visit.update', ':id') }}".replace(':id', id);
            $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,

                    contentType: false, // Ensure to set these options for FormData
                    processData: false,
                    success: function(response) {
                        $('#closeModal').click();
                        $('#nutritions_visitTable').DataTable().ajax.reload();

                        Swal.fire({
                            icon: 'success',
                            title: 'Success!!',
                            text: 'Report updated successfully',
                            confirmButtonText: 'OK',
                            timer: 2000
                        });
                    },
                    error: function(xhr, status, error) {
                        submitBtn.prop('disabled', false); // Re-enable the button

                        var errorMessage = '';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage += xhr.responseJSON.message;
                        } else {
                            errorMessage += status;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops',
                            text: errorMessage,
                            confirmButtonText: 'OK',
                        });
                    }
                });
                submitBtn.prop('disabled', false);
            })
    });
</script>
