<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BladeController extends Controller
{
    public static function profilemodal($id,$lead){
        
        $images= asset('storage/app/student_photo/'.$lead->profile_image);

       return '<form action="'.url('profilemodal').''.'/'.''.$id.'" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="'.csrf_token().'">
                    <div class="row">
                        <div class="card-body">
                            <div class="card-title">
                              <h5 class="modal-title" id="newmodel">Student View</h5>
                                <div class="text-left">
                                    <label class="col-form-label mb-0">Profile Picture</label>
                                    <img src="'.$images.'" class="mt-2" width="100px" height="100px">
                                 </div>
                                <input type="hidden" name="image" value="'. $lead->profile_image .'">
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                </div>
                            </div>
                                    <div class="form-row">
                                        <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Name</label>
                                        <p>' . $lead->name . '</p>
                                    </div>
                            <div class="form-row">
                                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Age</label>
                                <p>' . $lead->age . '</p>
                            </div>
                            <div class="form-row">
                                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Gender</label>
                                <p>' . $lead->gender . '</p>
                                </div>
                            <div class="form-row">
                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Batch</label>
                            <p>' . $lead->batch . '</p>
                            </div>
                  <div class="form-row">
                  <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Course</label>
                  <p>' . $lead->course . '</p>
                  </div>
                  <div class="form-row">
                  <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Date of Birth</label>
                  <p>' . $lead->date_of_birth . '</p>
                  </div>
                  <div class="form-row">
                  <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Date of Join</label>
                  <p>' . $lead->date_of_join . '</p>
                  </div>
                  <div class="form-row">
                  <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Email</label>
                  <p>' . $lead->email . '</p>
                  </div>
                  <div class="form-row">
                  <label for="exampleInputUsername2" class="col-sm-4 col-form-label">phone</label>
                  <p>' . $lead->phone . '</p>
                  </div>
                  <div class="form-row">
                  <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Product Purchased</label>
                  <p>' . $lead->product_purchased . '</p>
                  </div>
                  <div class="form-row">
                    <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Student Performance</label>
                    <div class="col-sm-8">
                    <select class="form-control">
                        <option>Excellent</option>
                        <option>Good</option>
                        <option>Bad</option>
                        </select>   
                    </div>
                </div>
                <div class="form-row">
                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">progress track</label>
                <div class="col-sm-8">
                <select class="form-control">
                  <option>Beginner</option>
                  <option>intermediate</option>
                  <option>professional</option>
                  </select>   
              </div>
                  </div>
                  <div class="modal-footer">
                    <input type="hidden" id="type" name="type" value="newmodel2">
                    <button type="submit" class="btn btn-primary">submit</button>
                    <button type="button" class="btn btn-red" data-dismiss="modal">Cancel</button>
                </div>
                  </div>
                  </div>
                  </div>
                 
              
              ';
  
      }
}
