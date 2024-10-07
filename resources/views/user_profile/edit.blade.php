@extends('layouts.main')
@section('title', Auth::user()->name )
@section('content')
<style>
    .select2-container {
    width: 100% !important;
}
.select2-container--default .select2-selection--multiple {
    width: 100% !important;
}
.select2-container--default .select2-selection--single {
    width: 100% !important;
}
</style>
<div class="conatiner" >
    <div class="row p-4">
        <div class="col-3"></div>
        <div class="col-6 p-4" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
            <form action="{{route('profile.profileUpdate')}}" method="post">
                @csrf
            <div class="row g-3">
                <div class="col-12">
                    @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                </div>
                <div class="col-12">
                    <label for="">Email <span id="star">*</span></label>
                    @if(Auth::user()->role == 'admin')
                        <select name="email" id="email" required>
                            @foreach ($users as $user)
                                <option value="{{$user->email}}">{{$user->email}}</option>
                            @endforeach
                        </select>
                    @else
                    <input type="email" name="email" class="form-control" value="{{Auth::user()->email }}" required readonly>
                    @endif
                </div>
                <div class="col-12">
                    <label for="">Password<span id="star">*</span></label>
                    <input type="password" name="password" class="form-control"  required>
                </div>
                <div class="col-9"></div>
                <div class="col-3 text-right">
                    <input type="submit" class="form-contol btn btn-info mt-3" value="Update Profile">
                </div>
            </div>

            </form>
        </div>
        <div class="col-3"></div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $('#email').select2({});

    })
</script>
@endsection
