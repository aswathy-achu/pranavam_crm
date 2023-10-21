<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Batchdayslist;
use App\Course;
use App\Invoice;
use App\Product;

use Illuminate\Http\Request;

                                    
                             
class BladeController extends Controller
{
    public static function profilemodal($id, $student)
    {
       
        $images = asset('storage/app/student_photo/' . $student->profile_image);
        
        $batchId = $student->batch_id;
        $batch = Batch::find($batchId);
        $days = '';
        
        if ($batch) {
            $batchDay = $batch->batch_day;
            $batchDaysList = Batchdayslist::find($batchDay);
            if ($batchDaysList) {
                $days = $batchDaysList->week_days;
            }
        }
        $invoices = Invoice::where('stud_id', $student->stud_id)->get();
        $invoices = $student->invoices;
    
        $productInfo = '';
        
        foreach ($invoices as $invoice) {
            // Assuming you have a Product model and a relationship named "product"
            $product = $invoice->product;
            if ($product) {
                $productInfo .= $product->product_name ;
            }
        }    
        $course = Course::find($student->course_id);
        $courseName = $course ? $course->course_name : '';
        
        
        $dateOfBirth = isset($student->date_of_birth) ? date('Y-m-d', $student->date_of_birth) : date('Y-m-d');

    // Format Date of Join
        $dateOfJoin =isset($student->date_of_join) ? date('Y-m-d', $student->date_of_join) : date('Y-m-d');
    // 
        return '
            <form action="' . url('profilemodal') . '/' . $id . '" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <div class="row">
                    <div class="card-body">
                        <div class="card-title">
                            <h5 class="modal-title" id="newmodel">Student View</h5>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-row">
                                    <label for="exampleInputUsername2" class="col-sm-6 col-form-label">Name</label>
                                    <p>' . $student->name . '</p>
                                </div>
                                <div class="form-row">
                                    <label for="exampleInputUsername2" class="col-sm-6 col-form-label">Age</label>
                                    <p>' . $student->age . '</p>
                                </div>
                                <div class="form-row">
                                    <label for="exampleInputUsername2" class="col-sm-6 col-form-label">Gender</label>
                                    <p>' . $student->gender . '</p>
                                </div>
                                <div class="form-row">
                                    <label for="exampleInputUsername2" class="col-sm-6 col-form-label">Batch</label>
                                    <p>' . $days . '</p>
                                    <input type="hidden" name="batch_days" value="' . $days . '">
                                </div>
                            </div>
                            
                            <div class="col-sm-4">
                                <div class="text-left">
                                    <img src="' . $images . '" class="mt-2" width="100px" height="100px">
                                </div>
                                <input type="hidden" name="image" value="' . $student->profile_image . '">
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Course</label>
                            <p>' . $courseName . '</p>
                        </div>
                        <div class="form-row">
                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Course Fee</label>
                        <p>' . $student->fees . '</p>
                        </div>
                    
                        <div class="form-row">
                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Date of Birth</label>
                            <p>' . $dateOfBirth . '</p>
                        </div>
                        <div class="form-row">
                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Date of Join</label>
                            <p>' . $dateOfJoin . '</p>
                        </div>
                        <div class="form-row">
                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Email</label>
                            <p>' . $student->email . '</p>
                        </div>
                        <div class="form-row">
                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Phone</label>
                            <p>' . $student->phone . '</p>
                        </div>
                        <div class="form-row">
                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Product</label>
               <p>'.$productInfo.'</p>
            </div>
                        <div class="form-row">
                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Student Performance</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="student_performance">
                                    <option>Excellent</option>
                                    <option>Good</option>
                                    <option>Bad</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Progress Track</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="progress_track">
                                    <option>Beginner</option>
                                    <option>Intermediate</option>
                                    <option>Professional</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        ';
    }
    
    public static function dayModal($id, $day, $days)
    {
        $weekDays = isset($days) ? $days->week_days : '';

        return '
            <form action="' . url('dayModal') . '/' . $id . '" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <div class="row">
                    <div class="card-body">
                        <div class="card-title">
                            <h5 class="modal-title" id="newmodel">Student View</h5>
                        </div>
                        <div class="row">
                            <div class="form-group col-5 col-md-5 col-lg-5">
                                <label>Day</label>
                                <p>' . $weekDays . '</p>
                            </div>
                            <div class="form-group col-5 col-md-5 col-lg-5">
                                <label>Occupied Student</label>
                                <input type="text" name="occupy_students" class="form-control" value="' . ($day->occupy_students ?? '') . '">
                            </div>
                            <div class="form-group col-5 col-md-5 col-lg-5">
                                <label>From Time</label>
                                <input type="time" class="form-control" name="from_time" value="' . ($day->from_time ?? '') . '">
                            </div>
                            <div class="form-group col-5 col-md-5 col-lg-5">
                                <label>To Time</label>
                                <input type="time" class="form-control" name="to_time" value="' . ($day->to_time ?? '') . '">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        ';
    }
   
    public static function managestaffpermissionmodal($id, $permission) {
        return '
            <form action="' . url('managestaffpermission') . '/' . $id . '" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <div class="card">
                    <div class="card-header">
                        <h5 class="modal-title" id="permissionmodal">Staff Permission</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group col-9 col-md-9 col-lg-12">
                            <label>Name</label>
                            <input type="text" class="form-control" value="'.($permission->name ?? '').'" name="permission_name">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                        <button class="btn btn-secondary" type="reset">Reset</button>
                    </div>
                </div>
            </form>
        ';
    }
    public static function editModal($id) {
        return '
            <form action="' . url('editModal') . '/' . $id . '" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <div class="card">
                    <div class="card-header">
                        <h5 class="modal-title" id="permissionmodal">Staff Permission</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group col-9 col-md-9 col-lg-12">
                            <label>Name</label>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                        <button class="btn btn-secondary" type="reset">Reset</button>
                    </div>
                </div>
            </form>
        ';
    }
    private static function renderProductList($productlist)
    {
        $html = '
        <div class="form-row">
        <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Product Purchased</label>
        <div class="col-sm-8">
                <select class="form-control" name="product_purchased">
                    <option value="">-- Select --</option>';

        foreach ($productlist as $product) {
            $html .= '<option value="' . $product->id . '">' . $product->product_name . '</option>';
        }

        $html .= '
                </select>
                </div>
            </div>';

        return $html;
    }
}
