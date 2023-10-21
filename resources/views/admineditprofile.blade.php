@extends('index')
          @section('content')
          <div class="main-content">
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
            <div class="card-body">
               <a href="{{route('staffreg')}}" class="btn btn-primary">+ Create New Staff</a>
                <div class="col-lg-12 grid-margin">
</div>
</div>
          <div class="main-content">>
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Staff Registration</h4>
                  <form class="form-sample" action="{{route('updateprofile')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <p class="card-description"> Personal info </p>
                    <div class="col-sm-6">
                    <div class="col-sm-6">
                  
                    @if(isset($admin->image))
                    <input name="image" type="file" class="dropify" accept="image/jpeg,image/jpg,image/png" id="profile-picture" data-height="150" data-width="150" data-default-file="{{asset('storage/app/public/image/'.$admin->image) }}">
                    @else
                    <input name="image" type="file" class="dropify" accept="image/jpeg,image/jpg,image/png" id="profile-picture" data-height="150" data-width="150">
                    @endif
                    
                  </div>
                <!-- data-height="200px" data-width="100px"  -->
                  </div>
                      <br/>
                      
                      <input type="hidden" name="id" value="{{$admin->id ?? ''}}">
                      <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">First Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="fname" value="{{$admin->full_name ?? ''}}"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <?php if (isset($admin->gender)) {
                                $val = $admin->gender;
                            } else {
                                $val = '';
                            } ?>
                          <label class="col-sm-3 col-form-label">Gender</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="gender">
                              <option <?php if($val=='Male'){echo "selected";} ?>>Male</option>
                              <option <?php if($val=='Female'){echo "selected";} ?>>Female</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Date of Birth</label>
                          <div class="col-sm-9">
                            <?php if (isset($admin->dob)) {
                                $val = date('Y-m-d',$admin->dob);
                            } else {
                                $val = date('Y-m-d');
                                
                            } 
                            
                            ?>
                            <input type="date" class="form-control" name="dob"  value="{{$val}}"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Date of Join</label>
                          <div class="col-sm-9">
                            <?php if (isset($admin->doj)) {
                                $val = date('Y-m-d',$admin->doj);
                            } else {
                                $val = date('Y-m-d');
                                
                            } 
                            
                            ?>
                            <input type="date" class="form-control" name="doj"  value="{{$val}}"/>
                          </div>
                        </div>
                      </div>
                    <!-- </div> -->
                    <!-- <div class="row"> -->
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Position</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="position">
                              <option value="">Choose...</option>
                              @foreach($emp_position as $ep)
                                  <?php $select = '';
                                  if (isset($admin->position)) {
                                      if ($admin->position == $ep->id) {
                                          $select = 'selected';
                                      }
                                  } ?>
                                  <option value="{{$ep->id}}" {{$select}}>{{$ep->name}}</option>
                                  @endforeach
                              </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Email</label>
                          <div class="col-sm-9">
                            <input type="email" class="form-control" name="email" value="{{$admin->email ?? ''}}" readonly>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Phone</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="mobile_number" value="{{$admin->mobile_number ?? ''}}"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-3 card-description">Address</label>
                          <!-- <p class="card-description"> Address</p> -->
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Address 1</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="address1" value="{{$admin->address1 ?? ''}}"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">State</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="state" value="{{$admin->state ?? ''}}"/>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Address 2</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="address2" value="{{$admin->address2 ?? ''}}"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Postcode</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="postcode" value="{{$admin->postcode ?? ''}}"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">City</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="city" value="{{$admin->city ?? ''}}"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Country</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="country" value="{{$admin->country ?? ''}}"/>
                          </div>
                        </div>
                      </div>
                    
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                    <button class="btn btn-dark">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          @endsection
          @section('contentjs')
          <script>
              $('.dropify').dropify();
          </script>
      
          @endsection