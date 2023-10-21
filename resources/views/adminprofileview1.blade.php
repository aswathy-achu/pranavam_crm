@extends('index')
@section('content')
<?php 

	$images = asset('storage/app/admin_photo/' . $admin->admin_profile_image);
	$image = asset('storage/app/public/image/Avathar.png'); 
?>
<div class="main-content">
    <h4 class="card-title">User Profile</h4>

    <!-- Profile Section -->
    <div class="row">
	<div class="col-md-3 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form class="forms-sample">
                        <input type="hidden" name="id" value="{{ $admin->id ?? '' }}">
                        <div class="d-flex flex-column align-items-center text-center">
							@if(isset($images) && !empty($admin->admin_profile_image))
								<img src="{{ $images }}" class="rounded-circle" width="150" height="150">
								<input type="hidden" name="admin_profile_image" value="{{ $admin->admin_profile_image }}">
							@else
								<img src="{{ $image }}" class="rounded-circle" width="150" height="150">
								<input type="hidden" name="admin_profile_image" value="100.png">
							@endif
							<div class="mt-3"><br/>
								@if(Auth::user()->type == 'A')
									<a href="{{ route('adminprofile') }}" class="btn btn-primary">Edit Profile</a> 
								@endif
								<br/><br/> 
								<h4>{{ $admin->full_name }}</h4>
								<br/>
								<p>EMP ID: {{ $admin->email }}</p>
							</div>
						</div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Personal Details Section -->
		<div class="col-lg-9 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Personal Details</h3>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <h4>{{ $admin->full_name }}</h4>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <h4>{{ $admin->email }}</h4>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Mobile</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <h2>{{ $admin->mobile_number }}</h2>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Date Of Birth</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <h4>{{ $admin->dob }}</h4>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Gender</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <h4>{{ $admin->gender }}</h4>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Address</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <h4>{{ $admin->address1 }}</h4>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Joining Date</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <h4>{{ $admin->doj }}</h4>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <!-- Add more rows for other personal details if needed -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Target Section -->
    <!-- Place any target-related content here -->
</div>
							
							
							
@endsection