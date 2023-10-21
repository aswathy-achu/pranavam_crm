@extends('index')
@section('content')

<div class="main-content">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Staff Profile Edit</h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('/edit_manage_staff') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $staff->id ?? '' }}">
                        <div class="row">
                            <div class="form-group">
                                <label>Profile Picture</label>
                                @if(isset($staff->staff_profile_image))
                                <input type="file" accept="image/jpeg,image/jpg,image/png" name="staff_profile_image" id="profile-picture" class="dropify"  data-min-width="150px" data-height="200px" data-default-file="{{ asset('storage/app/staff_photo/'.$staff->staff_profile_image) }}">
                                @else
                                <input type="file" accept="image/jpeg,image/jpg,image/png" name="staff_profile_image" id="profile-picture" class="dropify"  data-min-width="150px" data-height="200px">
                                @endif    
                            </div>
                        </div>    
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>First Name</label>
                            <input type="text" class="form-control" value="{{ $staff->fname ?? '' }}" name="fname">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Last Name</label>
                            <input type="text" class="form-control" value="{{ $staff->lname ?? '' }}" name="lname">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Date of Birth</label>
                            <?php 
                                if (isset($staff->date_of_birth)) {
                                    $val = date('Y-m-d',$staff->date_of_birth);
                                } else {
                                    $val = date('Y-m-d');
                                }
                             ?>
                            <input type="date" class="form-control" name="dob" value="{{$val}}"/>
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                        <?php
                        if (isset($staff->gender)) {
                            $val = $staff->gender;
                        } else {
                            $val = '';
                        }
                        ?>
                            <label>Gender</label>
                            <select class="form-control" name="gender">
                                <option {{ isset($staff->gender) && $staff->gender == 'Select' ? 'selected' : '' }}>Select</option>
                                <option {{ isset($staff->gender) && $staff->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option {{ isset($staff->gender) && $staff->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                         <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Date of Join</label>
                            <?php 
                                if (isset($staff->date_of_joining)) {
                                    $val = date('Y-m-d',$staff->date_of_joining);
                                } else {
                                    $val = date('Y-m-d');
                                }
                             ?>
                            <input type="date" class="form-control" name="doj" value="{{ $val }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Mobile Number</label>
                        <input type="tel" class="form-control" name="phone" value="{{ $staff->phone ?? '' }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Job Role</label>
                        <input type="text" class="form-control" name="jobrole" value="{{ $staff->jobrole ?? '' }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Alternate Number</label>
                        <input type="tel" class="form-control" name="phone2" value="{{ $staff->phone2 ?? '' }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>email</label>
                            <input type="email" class="form-control" name="email" value="{{ $staff->email ?? '' }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Address</label>
                            <input type="address" class="form-control" name="address1" value="{{ $staff->address1 ?? '' }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>State</label>
                            <input type="text" class="form-control" name="state" value="{{ $staff->state ?? '' }}">
                        </div><div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Address 2</label>
                            <input type="text" class="form-control" name="address2" value="{{ $staff->address2 ?? '' }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Post Code</label>
                            <input type="text" class="form-control" name="postcode" value="{{ $staff->postcode ?? '' }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>city</label>
                            <input type="text" class="form-control" name="city" value="{{ $staff->city ?? '' }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Country</label>
                            <input type="text" class="form-control" name="country" value="{{ $staff->country ?? '' }}">
                        </div>
                          @if(empty($staff))
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
                    @endif
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



