@extends('layouts.app')
@section('content')

    <div class="container">
       <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
            <a href="javascript:void(0)" class="btn btn-success mb-2" id="createNewTest">Create New Test</a>
        </div>
       </div>
        <table class="table data-table" id="medicalTestTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>

                    <th>Description</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Sample Room</th>
                    <th>Lab Room</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>


@endsection
@section('scripts')
    <script type="text/javascript">
        $(function () {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('medical-tests.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},

                    {data: 'description', name: 'description'},
                    {data: 'price', name: 'price'},
                    {
                data: 'status',
                name: 'status',
                render: function(data) {
                    return data == 1 ? 'Active' : 'Inactive';
                }
                },
                    {data: 'sample_collection_room_number', name: 'sample_collection_room_number'},
                    {data: 'lab_location_id', name: 'lab_location_id)'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                dom: '<"row"<"col-md-4"l><"col-md-4"B><"col-md-4"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>', // Layout definition
                buttons:[
                    'csv', 'pdf', 'copy'
                ],
            });

            $('#createNewTest').on('click', function () {
                $.ajax({
                    url:'{{route("medical-tests.create")}}',
                    method: 'GET',
                    success:function(respons){
                        $('body').append(respons);
                        $('#testCreateModal').modal('show');

                    }
                });
            });




            // Edit functionality
            table.on('click', '.edit', function () {
                var id = $(this).data("id");
                $.ajax({
                    url: '/tests/edit/'+id,
                    type: 'GET',
                    success:function(respons){
                        $('body').append(respons);
                        $('#testEditModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = '';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage += xhr.responseJSON.message;
                        } else {
                            errorMessage += status;
                        }

                        Swal.fire({
                                    icon: 'error',
                                    title: 'Opps',
                                    text: errorMessage,
                                    confirmButtonText: 'OK',
                                    timer:3000

                                });
                    },
                    error: function(xhr, status, error) {
                    var errorMessage = '';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += xhr.responseJSON.message;
                    } else {
                        errorMessage += status;
                    }

                    Swal.fire({
                                icon: 'error',
                                title: 'Opps',
                                text: errorMessage,
                                confirmButtonText: 'OK',
                                timer:3000
                            });
                     }

                });


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
                        url: '/medical-tests/'+ id,
                        headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        success: function (data) {
                            table.draw();
                            Swal.fire({
                                icon: 'info',
                                title: 'success',
                                text: 'Test deleted successfully',
                                toast: true,
                                position:'top-end',
                                showConfirmButton: false,
                                timer:2000

                            })
                        },
                        error: function(xhr, status, error) {
                    var errorMessage = '';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += xhr.responseJSON.message;
                    } else {
                        errorMessage += status;
                    }

                    Swal.fire({
                                icon: 'error',
                                title: 'Opps',
                                text: errorMessage,
                                confirmButtonText: 'OK',

                            });
                }
                    });
                  }
                });
            });
        });
    </script>
@endsection
