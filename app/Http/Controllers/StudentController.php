<?php

namespace App\Http\Controllers;

use App\Attendence;
use App\Batch;
use App\Batchdayslist;
use App\Course;
use App\Invoice;
use App\Product;
use App\Staff;
use App\Student;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Twilio\Rest\Client;
use Yajra\DataTables\DataTables;
// use Twilio\Rest\Client;

// use Yajra\Datatables\Facades\Datatables;

class StudentController extends Controller
{
    public function studentdetails(){
        if (!Auth::check()){
            return Redirect::to('/');
        }
        return view('studentdetails');
    }
   
    public function createstudent()
    {
        if (!Auth::check()) {
            return redirect('/');
        }
    
        // Create a new student instance
        $student = new Student;
    
        // Generate an admission number
        $latestStudent = Student::latest('id')->first();
        if ($latestStudent) {
            $lastId = $latestStudent->id + 1;
        } else {
            $lastId = 1;
        }
        $admissionNumber = 'ADM-' . str_pad($lastId, 5, '0', STR_PAD_LEFT);
    
        // Set the generated admission number in the student instance
        $student->adm_no = $admissionNumber;
    
        // Retrieve necessary data for the view
        $page_data['productlist'] = Product::get();
        $page_data['courselist'] = Course::get();
        $page_data['batch_daylist'] = Batchdayslist::get();
        $page_data['batch_list'] = Batch::get();
    
        // Pass the student instance and other data to the view
        return view('createstudent', compact('student'))->with($page_data);
    }
    

    public function getBatchTimes()
    {
        $selectedDay = request('selectedDay'); 
        $batchTimes = Batch::where('batch_day', $selectedDay)->get();
        return $batchTimes;
    }

    public function manage_student(Request $request, $id = '')
    {
        info("dddd");
        if (!Auth::check()) {
            return redirect('/');
        }

        if ($request->isMethod('post')) {
            if ($request->input('id') == '') {
                $student = new Student;
                info($student);
            } else {
                $student = Student::find($request->input('id'));
            }
            // info($student);
            // Retrieve batch details
            $batch_id = $request->input('batch_id');
            $batch = Batch::find($batch_id);
        
            $student->batch_id = $batch_id;
            info($batch_id);
            $student->name = $request->input('fname');
            $student->adm_no = $request->input('adm_no');
            $student->age = $request->input('age');
            $student->gender = $request->input('gender');
            $student->date_of_birth = strtotime($request->post('dob'));
            $student->email = $request->input('email');
            $student->phone = $request->input('phone');
            $student->fees = $request->input('fees');
            $student->date_of_join = strtotime($request->post('doj'));
            $student->course_id = $request->input('course');
    
            if ($request->hasFile('profile_image')) {
                if ($request->input('id')) {
                    if (Storage::exists('student_photo/' . $student->profile_image)) {
                        Storage::delete('student_photo/' . $student->profile_image);
                    } 
                }
                $extension = $request->file('profile_image')->extension();
                $filename = rand() . '.' . $extension;
                $request->file('profile_image')->storeAs('student_photo', $filename);
                $student->profile_image = $filename;
            }
            $student->save();
            $admissionNumber = 'ADM-' . str_pad($student->id, 5, '0', STR_PAD_LEFT);
            $student->update(['adm_no' => $admissionNumber]);
            info("er".$admissionNumber);
            if ($request->input('id')) {
                return redirect('/studentlist')->with('success', 'Update successfully!');
            } else {
                // $batch->total_no_of_student++;
                // $batch->save();
                return redirect('/studentlist')->with('success', 'Add successfully!');
            }
        }
    
        if ($id) {
            $student = Student::find($id);
        } else {
            $student = null;
        }
    
        $page_data['productlist'] = Product::all();
        $page_data['batch_daylist'] = Batchdayslist::all();
        $page_data['courselist'] = Course::all();
        $page_data['student'] = $student;
        $page_data['menu'] = 'student';
        return view('createstudent', $page_data);
    }

    public function studentlist(){
        if (!Auth::check()) {return Redirect::to('/');}
        $page_data['menu'] = 'student';
        $page_data['studentlist'] = Student::get();
        $page_data['attendence'] = Attendence::get();
        $page_data['courselist'] = Course::get();
        $page_data['student'] = Student::get();
        $page_data['batch_daylist'] = Batchdayslist::get();
        $page_data['batch_list'] = Batch::get();
        $batches = Batch::all();
        return view('studentlist')->with($page_data);
    }
    public function get_student(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/');
        }
        $batchId = $request->input('batch_id');
        $courseId = $request->input('course_id');

        $users = Student::where('batch_id', $batchId)
        ->where('course_id', $courseId)
        ->get();
        return datatables()->of($users)
        ->addIndexColumn()
        ->editColumn('date_of_join',function ($f)
        {
            if (isset($f->date_of_join)) {
                $detailes = $f->date_of_join;
                $detailes = date('d-M-Y',$detailes);
            } else{
                $detailes = '';
            }
            return $detailes;
        })
        ->editColumn('course_id', function ($f) {
            $courseIds = explode(',', $f->course_id);
            $courseNames = Course::whereIn('id', $courseIds)->pluck('course_name')->toArray();
            return implode(', ', $courseNames);
        })
        ->addColumn('product_purchased', function ($student) {
            // Retrieve the invoices for the student
            $invoices = Invoice::where('stud_id', $student->id)->get();
            
            $productInfo = '';
            
            foreach ($invoices as $invoice) {
                // Assuming you have a Product model and a relationship named "product"
                $product = $invoice->product;
            
                if ($product) {
                    $productInfo .= $product->product_name ;
                }
            }
            
            return $productInfo;
        })
        
        -> addColumn('status', function ($f) {
            // Assuming 'attendance_mark' is a column in the 'Attendance' table.
            $attendanceCount = Attendence::where('stud_id', $f->id)
                ->where('attendence_mark', 0)
                ->count();
        
            if ($attendanceCount >= 15) {
                return '<span style="background-color: red; color: white; border-radius: 10px; padding: 5px;">inactive</span>';
            } else {
                return '<span style="background-color: green; color: white; border-radius: 10px; padding: 5px;">active</span>';
            }
        })
        
        // ->addColumn('status', function ($f) {
        //     // Assuming 'attendance_mark' is a column in the 'Attendance' table.
        //     $attendanceDates = Attendance::where('stud_id', $f->id)
        //         ->where('attendence_mark', 0)
        //         ->orderBy('date', 'desc') // Order by date in descending order
        //         ->pluck('date')
        //         ->toArray();
        
        //     $consecutiveDays = 0;
        //     $today = strtotime(date('Y-m-d'));
        
        //     foreach ($attendanceDates as $date) {
        //         $attendanceDay = strtotime($date);
        //         $difference = ($today - $attendanceDay) / (60 * 60 * 24); // Calculate the difference in days
        
        //         if ($difference === 0) {
        //             // If attendance_mark is 0 for today, increase the consecutiveDays counter
        //             $consecutiveDays++;
        //             $today = strtotime('-1 day', $today); // Move to the previous day
        //         } else {
        //             // If attendance_mark is not 0 for the current day, break the loop
        //             break;
        //         }
        //     }
        
        //     if ($consecutiveDays >= 21) {
        //         return 'inactive';
        //     } else {
        //         return 'active';
        //     }
        // })
        ->addColumn('batch_id', function ($user) {
            $batchId = $user->batch_id;
            // info($batchId);
            $batch = Batch::find($batchId);
            if (!$batch) {
                return '';
            }
            $batchDay = $batch->batch_day;
            $days = Batchdayslist::find($batchDay);
            if (!$days) {
                return '';
            }
            ($days);
            return $days->week_days ?? '';
        })
        
        
        ->addColumn('action', function ($user) {
            $details = '<a href="'.url('/manage_student').'/'.$user->id.'" class="fas fa-edit"></a>';
            $details .='<a href="" data-toggle="modal" target="_blank" onclick="show_large_models('.$user->id.','."'profilemodal'".')" data-target="#newmodel"><i class="fas fa-eye"></i></a>';
            $details.='  <a href="javascript:void(0)" data-toggle="modal" data-target="#delete_modal" title="Delete" onclick=delete_confirm("/del_student/'.$user->id.'")><i class="fas fa-trash"></i></a>';
            return $details;
        })
        ->rawColumns(['status','action'])
        ->make(true);
    }
        
    public function profile(Request $request, $id = '')
    {
        $student = Student::find($id);
        $batch = Batch::find($id);
        $days = Batchdayslist::find($id);
        // $invoice= Invoice::where('stud_id',$request->stud_id)
        //                     ->where('product_id',$request->product_id)->get();
       info($days);
        if ($request->isMethod('post')) {
            $student->update([
                
                'student_performance' => $request->input('student_performance'),
                'progress_track' => $request->input('progress_track'),
            ]);
                info($student);
            return back()->with('success', 'Update Successful.');
        }
        return view('studentprofile', compact('student', 'batch', 'days'));
        // return BladeController::profilemodal($id, $lead);
    }
    public function del_student($id)
    {   
        if (!Auth::check()) {return Redirect::to('/');}
        $data = Student::find($id);
        if ($data) {
            $data->delete();
            return Redirect::back()->with('success','Delete successfully!');
        } else {
            return Redirect::back()->with('error','Data Not Found');
        }
    }  
    public function manage_batch_check()
    {
        $students = Student::get();
        $batch_daylist = Batchdayslist::all(); // Assuming you have a model for Batchdayslist
        $batch = Batch::all();
        $course = Course::all();
    
        $display = '<div class="form-row">';
    
        // Batch Day Dropdown
        $display .= '<div class="form-group col-5 col-md-5 col-lg-5">
                        <label>Batch Day</label>
                        <select class="form-control" name="batch" id="batch-dropdown" required>
                            <option value="">Select</option>';
    
        foreach ($batch_daylist as $key => $v) {
            $display .= '<option value="'.$v->id.'">'.$v->week_days.'</option>';
        }
    
        $display .= '</select>
                    </div>';
    
        // Batch Time Dropdown
        $display .= '<div class="form-group col-5 col-md-5 col-lg-5">
                        <label for="from-time-dropdown">Batch Time <span class="text-danger">*</span></label>
                        <select class="form-control" name="from_time" id="from-time-dropdown" required disabled>
                            <option value="">Select</option>
                        </select>
                    </div>';
        
        // Course Dropdown
        $display .= '<div class="form-group col-5 col-md-5 col-lg-5">
                        <label for="course_id">Course <span class="text-danger">*</span></label>
                        <select class="form-control" name="course" id="course-dropdown" required disabled>
                            <option value="">Select</option>
                        </select>
                    </div>';
    
        $display .= '</div>'; // Close the form-row
    
        $display .= '<center><button type="button" class="btn btn-warning btn-xs" onclick="batchmodel()">Confirm</button></center>';
    
        // Output the HTML
        echo $display;
    }
    
    
    

    

    }

    
    
    

