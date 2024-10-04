@extends('layouts.main')
@section('title', 'User Role')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4 mt-5" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
            <form action="{{route('role.store')}}" method="post">
                @csrf
                <div class="row g-2 p-3 ">
                    @if(Session::has('success'))
                    <p class="alert alert-success" id="session-message">{{ Session::get('success') }}</p>
                    @endif
                    <div class="col-12">
                        <label for="">Select User</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">Choose user</option>
                            @foreach ($users as $user)
                            <option value="{{$user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="">Set Role <span ><b id="role"></b></span></label>
                        <select name="role" id="user_role" class="form-control" required>
                            <option value="">Choose User Role</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <div class="col-8"></div>
                    <div class="col-4 mt-2">
                        <input type="submit" class="form-control btn btn-success">
                    </div>
                </div>

            </form>
        </div>
        <div class="col-4"></div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $('#user_id').select2({});
        $('#user_role').select2({});
    })

$(document).ready(function() {
    var $messageElement = $('#session-message');
    if ($messageElement.length) {
        setTimeout(function() {
            $messageElement.fadeOut(300); // Fade out over 500ms
        }, 3000); // Time in milliseconds (5000 ms = 5 seconds)
    }
    $('#user_id').on('change', function(){
        var id = $(this).val();
        $('#role').empty();
        $.ajax({
            url: 'role/'+ id +'/edit',
            type: 'GET',
            success: function(response) {
                $('#role').text('( ' + response.user.role + ' )');

            }
        })
    })
});


</script>
@endsection
