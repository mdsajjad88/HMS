@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Medical Tests</h1>
        <a href="javascript:void(0)" class="btn btn-success mb-2" id="createNewTest">Create New Test</a>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Types</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create New Medical Test</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createForm">
                        @csrf
                        <!-- Add form fields as needed -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveBtn">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    @foreach($medicalTests as $test)
    <div class="modal fade" id="editModal{{$test->id}}" tabindex="-1" role="dialog" aria-labelledby="editModal{{$test->id}}Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModal{{$test->id}}Label">Edit Medical Test</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm{{$test->id}}">
                        @csrf
                        @method('PUT')
                        <!-- Populate form fields with current data -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateBtn{{$test->id}}">Update</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Delete Modal -->
    @foreach($medicalTests as $test)
    <div class="modal fade" id="deleteModal{{$test->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{$test->id}}Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModal{{$test->id}}Label">Delete Medical Test</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this medical test?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="deleteBtn{{$test->id}}">Delete</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <script type="text/javascript">
        $(function () {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('medical-tests.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'types', name: 'types'},
                    {data: 'description', name: 'description'},
                    {data: 'price', name: 'price'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#createNewTest').click(function () {
                $('#saveBtn').text("Create");
                $('#createForm').trigger("reset");
                $('#createModal').modal('show');
            });

            $('#saveBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Saving...');

                $.ajax({
                    data: $('#createForm').serialize(),
                    url: "{{ route('medical-tests.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#createForm').trigger("reset");
                        $('#createModal').modal('hide');
                        table.draw();
                        toastr.success('Medical test created successfully.');
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Save');
                    }
                });
            });


            // Edit functionality
            table.on('click', '.edit', function () {
                var id = $(this).data("id");

                $.get("{{ route('medical-tests.index') }}" + '/' + id + '/edit', function (data) {
                    $('#updateBtn'+id).text("Update");
                    $('#editForm'+id).trigger("reset");
                    // Populate modal fields with current data
                    $('#editModal'+id).modal('show');
                })
            });

            // Update functionality
            table.on('click', '.update', function (e) {
                e.preventDefault();
                var id = $(this).data("id");
                $('#updateBtn'+id).html('Updating...');

                $.ajax({
                    data: $('#editForm'+id).serialize(),
                    url: "{{ route('medical-tests.index') }}" + '/' + id,
                    type: "PUT",
                    dataType: 'json',
                    success: function (data) {
                        $('#editForm'+id).trigger("reset");
                        $('#editModal'+id).modal('hide');
                        table.draw();
                        Swal.fire(
                          'Updated!',
                          data.success,
                          'success'
                        )
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#updateBtn'+id).html('Update');
                    }
                });
            });

            // Delete functionality
            table.on('click', '.delete', function () {
                var id = $(this).data("id");

                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('medical-tests.index') }}" + '/' + id,
                        success: function (data) {
                            table.draw();
                            Swal.fire(
                              'Deleted!',
                              data.success,
                              'success'
                            )
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                  }
                });
            });
        });
    </script>
@endsection
