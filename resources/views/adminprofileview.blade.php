@extends('index')
@section('content')
<style>
    body {
    padding: 0;
    margin: 0;
    font-family: 'Lato', sans-serif;
    color: #000;
}
.student-profile .card {
    border-radius: 10px;
}
.student-profile .card .card-header .profile_img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    margin: 10px auto;
    border: 10px solid #ccc;
    border-radius: 50%;
}
.student-profile .card h3 {
    font-size: 20px;
    font-weight: 700;
}
.student-profile .table th,
.student-profile .table td {
    font-size: 14px;
    padding: 5px 10px;
    color: #000;
}
</style>
<?php 
    $images = asset('storage/app/admin_photo/' . $admin->admin_profile_image);
    $image = asset('storage/app/public/image/Avathar.png'); 
?>
<div class="main-content">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12 d-flex"> <!-- Center align the column -->
            <div class="card">
                <div class="card-header">
                    <h4>Admin Profile</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="student-profile py-4">
                <div class="container">
                    <div class="row">
                    <div class="col-lg-4">
                        <div class="card shadow-sm">
                        <div class="d-flex flex-column align-items-center text-center">
                            @if(isset($images) && !empty($admin->admin_profile_image))
                                <img src="{{ $images }}" class="rounded-circle" width="150" height="150">
                                <input type="hidden" name="admin_profile_image" value="{{ $admin->admin_profile_image }}">
                            @else
                                <img src="{{ $image }}" class="rounded-circle" width="150" height="150">
                                <input type="hidden" name="admin_profile_image" value="100.png">
                            @endif
                            <h4>{{ $admin->full_name }}</h4>
                            <p>EMP ID: {{ $admin->email }}</p>
                            @if(Auth::user()->type == 'A')
                                <a href="{{ route('adminprofile') }}" class="btn btn-primary">Edit Profile</a> 
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                        <div class="card shadow-sm">
                        <div class="card-header bg-transparent border-0">
                            <h3 class="mb-0">General Information</h3>
                        </div>
                        <div class="card-body pt-0">
                            <table class="table table-bordered">
                            <tr>
                                <th width="30%">Name</th>
                                <td width="2%">:</td>
                                <td>{{ $admin->full_name }}</td>
                            </tr>
                            <tr>
                                <th width="30%">Email</th>
                                <td width="2%">:</td>
                                <td>{{ $admin->email }}</td>
                            </tr>
                            <tr>
                                <th width="30%">Mobile Number</th>
                                <td width="2%">:</td>
                                <td>{{ $admin->mobile_number }}</td>
                            </tr>
                            <tr>
                                <th width="30%">Date Of Birth</th>
                                <td width="2%">:</td>
                                <td>{{ $admin->dob }}</td>
                            </tr>
                            <tr>
                                <th width="30%">Gender</th>
                                <td width="2%">:</td>
                                <td>{{ $admin->gender }}</td>
                            </tr>
                            <tr>
                                <th width="30%">Address</th>
                                <td width="2%">:</td>
                                <td>{{ $admin->address1 }}</td>
                            </tr>
                            <tr>
                                <th width="30%">Joining Date</th>
                                <td width="2%">:</td>
                                <td>{{ $admin->doj }}</td>
                            </tr>
                            </table>
                        </div>
                        </div>
                        <div style="height: 26px"></div>
                        <div class="card shadow-sm">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
