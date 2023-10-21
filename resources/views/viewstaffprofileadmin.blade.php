@extends('index')
@section('content')
<style>
    /* Add your CSS styles here */
    .section {
        display: none;
    }

    .active-section {
        display: block;
    }
    .btn-rectangle {
        border-radius: 0; 
    }
    
</style>
<?php 
    $images = asset('storage/app/staff_photo/' . $staff->staff_profile_image);
    $image = asset('storage/app/public/image/Avathar.png'); 
?>
<div class="main-content">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            

            <div class="card">
            
    <div class="card-header">
        
        <h4>Staff Profile View</h4>
        <div class="button-container">
                        <button class="btn btn-primary active" id="staffProfileBtn">Staff Profile</button>
                        <button class="btn btn-primary" id="passwordResetBtn">Password Reset</button>
                    </div>
    </div>
    
    <div class="card-body">

        <!-- Staff Profile Section -->
        <div id="staffProfileSection" class="section active-section">
            <!-- Add your staff profile form fields here -->
            <!-- Example: -->
            <div class="row">
                <!-- Profile Image Column -->
                <div class="col-4 text-center">
    
    
    @if(isset($images) && !empty($staff->date_of_joining))
        <img src="{{ $images }}" class="rounded-circle" width="150" height="150">
        <input type="hidden" name="staff_profile_image" value="{{ $staff->staff_profile_image }}">
    @else
        <img src="{{ $image }}" class="rounded-circle" width="150" height="150">
        <input type="hidden" name="staff_profile_image" value="100.png">
    @endif


                    <h4> {{ $staff->fname }} {{ $staff->lname }}</h4>
                    <p>EMP ID: {{ $staff->user_id }}</p>
                    <p>Job Role: {{ $staff->jobrole }}</p>

                </div>

                <!-- General Information Column -->
                <div class="col-4">
                   
                <table style="border-spacing: 10px;">
    <tr>
        <th width="50%">Name</th>
        <td width="9%">:</td>
        <td>{{ $staff->fname }} {{ $staff->lname }}</td>
    </tr>
    <tr style="height: 20px;"></tr>
    <tr>
        <th width="50%">Email</th>
        <td width="32%">:</td>
        <td>{{ $staff->email }}</td>
    </tr>
    <tr style="height: 20px;"></tr>
    <tr>
        <th width="50">Mobile Number</th>
        <td width="9%">:</td>
        <td>{{ $staff->phone }}</td>
    </tr>
    <tr style="height: 20px;"></tr>
    <tr>
        <th width="50">Date Of Birth</th>
        <td width="9%">:</td>
        <td>{{ date('Y-m-d', $staff->dob) }}</td>
    </tr>
    <tr style="height: 20px;"></tr>
    <tr>
        <th width="50">Gender</th>
        <td width="9%">:</td>
        <td>{{ $staff->gender }}</td>
    </tr>
    <tr style="height: 20px;"></tr>
    <tr>
        <th width="50">Address</th>
        <td width="9%">:</td>
        <td>{{ $staff->address1 }}{{ $staff->address2 }}<br/>{{ $staff->country }}<br/>{{ $staff->state }}<br/>{{ $staff->city }}<br/>{{ $staff->postcode }}</td>
    </tr>
    <tr style="height: 20px;"></tr>
    <!-- Add more fields as needed -->
</table>
                     
                </div>
            </div>
        </div>
        <div id="passwordResetSection" class="section">
    <!-- Add your password reset form fields here -->
    <!-- Example: -->
    <form action="{{ route('manage_reset_user_password') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h5 style="text-align: center;">Reset Password</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Email">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
            </div>
        </div>
        <div class="button-container text-right">
            <button id="previousBtn" disabled class="btn btn-primary mr-1">Previous</button>
            <button id="nextStepBtn" type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>



</div>

@endsection

@section('contentjs')
<script type="text/javascript">
   const staffProfileBtn = document.getElementById('staffProfileBtn');
    const passwordResetBtn = document.getElementById('passwordResetBtn');
    const staffProfileSection = document.getElementById('staffProfileSection');
    const passwordResetSection = document.getElementById('passwordResetSection');

    staffProfileBtn.addEventListener('click', () => {
        staffProfileSection.classList.add('active-section');
        passwordResetSection.classList.remove('active-section');
        staffProfileBtn.classList.add('active');
        passwordResetBtn.classList.remove('active');
    });

    passwordResetBtn.addEventListener('click', () => {
        staffProfileSection.classList.remove('active-section');
        passwordResetSection.classList.add('active-section');
        staffProfileBtn.classList.remove('active');
        passwordResetBtn.classList.add('active');
    });



</script>
@endsection
