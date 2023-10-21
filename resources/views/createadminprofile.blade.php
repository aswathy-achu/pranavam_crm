@extends('index')
@section('content')

<div class="main-content">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Create Admin</h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('/manage_admin') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $admin->id ?? '' }}">
                        <div class="row">
                            <div class="form-group">
                                <label>Profile Picture</label>
                                @if(isset($admin->admin_profile_image))
                                <input type="file" accept="image/jpeg,image/jpg,image/png" name="admin_profile_image" id="profile-picture" class="dropify"  data-min-width="150px" data-height="200px" data-default-file="{{ asset('storage/app/admin_photo/'.$admin->admin_profile_image) }}">
                                @else
                                <input type="file" accept="image/jpeg,image/jpg,image/png" name="admin_profile_image" id="profile-picture" class="dropify"  data-min-width="150px" data-height="200px">
                                @endif    
                            </div>
                        </div>    
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Full Name</label>
                            <input type="text" class="form-control" value="{{ $admin->full_name ?? '' }}" name="fname">
                        </div>
                        
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Date of Birth</label>
                            
                            <input type="date" class="form-control" name="dob" value="{{$admin->dob}}"/>
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                        <?php
                        if (isset($admin->gender)) {
                            $val = $admin->gender;
                        } else {
                            $val = '';
                        }
                        ?>
                            <label>Gender</label>
                            <select class="form-control" name="gender">
                                <option {{ isset($admin->gender) && $admin->gender == 'Select' ? 'selected' : '' }}>Select</option>
                                <option {{ isset($admin->gender) && $admin->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option {{ isset($admin->gender) && $admin->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                         <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Date of Join</label>
                           
                            <input type="date" class="form-control" name="doj" value="{{ $val }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Mobile Number</label>
                        <input type="tel" class="form-control" name="phone" value="{{ $admin->mobile_number ?? '' }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Alternate Number</label>
                        <input type="tel" class="form-control" name="phone2" value="{{ $admin->alternate_number ?? '' }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>email</label>
                            <input type="email" class="form-control" name="email" value="{{ $admin->email ?? '' }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Address</label>
                            <input type="address" class="form-control" name="address1" value="{{ $admin->address1 ?? '' }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>State</label>
                            <input type="text" class="form-control" name="state" value="{{ $admin->state ?? '' }}">
                        </div><div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Address 2</label>
                            <input type="text" class="form-control" name="address2" value="{{ $admin->address2 ?? '' }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Post Code</label>
                            <input type="text" class="form-control" name="postcode" value="{{ $admin->postcode ?? '' }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>city</label>
                            <input type="text" class="form-control" name="city" value="{{ $admin->city ?? '' }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Country</label>
                            <input type="text" class="form-control" name="country" value="{{ $admin->country ?? '' }}">
                        </div>
                      <div class="form-group col-5 col-md-5 col-lg-5">
                        <label class="col-sm-3 card-description">password</label>
                        <input type="password" class="form-control" name="password">

                      <!-- <p class="card-description"> Address</p> -->
                    </div>
                    <div class="form-group col-5 col-md-5 col-lg-5">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" name="confirmpassword" >
                    </div>   
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                        <button class="btn btn-secondary" type="reset">Reset</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('contentjs')
<script type="text/javascript">
$('.dropify').dropify();
</script>
@endsection



