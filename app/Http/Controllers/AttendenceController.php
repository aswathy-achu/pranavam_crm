<?php

namespace App\Http\Controllers;

use App\Attendence;
use App\Batch;
use App\Batchdayslist;
use App\Course;
use App\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Exceptions\Exception;

class AttendenceController extends Controller
{

    public function attendenceday(){
        $page_data['course'] = Course::get();
        $page_data['student'] = Student::get();
        $page_data['batch_daylist'] = Batchdayslist::get();
        $page_data['batch_list'] = Batch::get();
        $batches = Batch::all(); 
        return view('attendenceday', compact('batches'))->with($page_data);
    }
    public function attendencestudentstatus(Request $request,$id=''){
        $batch_id = $request->input('batch_id');
        $course_id = $request->input('course_id');
        $selectedStudentIds = $request->input('attendance', []);
        $currentDate = Carbon::now()->toDateString();
    
        if ($request->isMethod('post')) {
            // Process attendance and update or create records
            $students = Student::where('batch_id', $batch_id)
                ->where('course_id', $course_id)
                ->pluck('id')
                ->all();



                $batch = Batch::find($batch_id);
                $course = Course::find($course_id);
                $students = Student::where('batch_id', $batch_id)
                    ->where('course_id', $course_id)
                    ->get();
                return view('attendencestudentlist', compact('students', 'batch', 'course', 'selectedStudentIds'));
            
        }
    }
    public function getCourseData(Request $request)
    { 
        $batchId = $request->input('batch_id'); 
        $courseData = Course::where('batch_id', $batchId)->get(['id', 'course_name']);
        return response()->json($courseData);
    }

    public function getStudentName(Request $req)
    {
        $batch_id = $req->input('batch_id');
        $course_id = $req->input('course_id');
        $selectedStudentIds = $req->input('attendance', []);
        $currentDate = Carbon::now()->toDateString();
        if ($req->isMethod('post')) {
            // Process attendance and update or create records
            $allStudents = Student::where('batch_id', $batch_id)
                ->where('course_id', $course_id)
                ->pluck('id')
                ->all();
            $existingAttendances = Attendence::where('batch_id', $batch_id)
                ->where('course_id', $course_id)
                ->whereIn('stud_id', $allStudents)
                ->where('date', $currentDate)
                ->get();
            $existingAttendancesMap = [];
            foreach ($existingAttendances as $existingAttendance) {
                $existingAttendancesMap[$existingAttendance->stud_id] = $existingAttendance;
            }
            foreach ($allStudents as $studentId) {
                $attendanceStatus = in_array($studentId, $selectedStudentIds) ? 1 : 0;
                if (isset($existingAttendancesMap[$studentId])) {
                    $existingAttendance = $existingAttendancesMap[$studentId];
                    $existingAttendance->attendence_mark = $attendanceStatus;
                    $existingAttendance->save();
                } else {
                    $attendance = new Attendence();
                    $attendance->batch_id = $batch_id;
                    $attendance->course_id = $course_id;
                    $attendance->stud_id = $studentId;
                    $attendance->attendence_mark = $attendanceStatus;
                    $attendance->date = $currentDate;
                    $attendance->save();
                }
            }
            // Redi]else {
            // Fetch data and return the view
            $batch = Batch::find($batch_id);
            $course = Course::find($course_id);
            $students = Student::where('batch_id', $batch_id)
                ->where('course_id', $course_id)
                ->get();
                $page_data['course'] = Course::get();
                $page_data['student'] = Student::get();
                $page_data['batch_daylist'] = Batchdayslist::get();
                $page_data['batch_list'] = Batch::get();
                $batches = Batch::all();
            return view('attendenceday', compact('students', 'batch', 'course', 'selectedStudentIds'))->with($page_data);
        }
    }
    public function attendencelist(){
        $attendances= Attendence::all(); 
        return view('attendencelist', compact('attendances'));
    }
    public function admin_panel_att_listing(Request $req)
    {
        if (request('ajaxData')) {
            $batch_id = request('selectBatch');
            $course_id = request('selectCourse');
            
            // Fetch students based on batch and course with their names
            $stud = Student::where('batch_id', $batch_id)
                    ->where('course_id', $course_id)
                    ->select('id', 'name')
                    ->get();
            $stud_ids = $stud->pluck('id')->toArray();
            
            $selectedMonth = request('selectedMonth');
            
            if ($selectedMonth == 'THIS') {
                // Get the current date and time
                $currentMonthDays = Carbon::now()->month(Carbon::now()->month)->daysInMonth;     //   total days in current month  
                $date = date('Y-m', strtotime(Carbon::now()));
                // info($date);
                // info($currentMonthDays);
                // Fetch attendance records up to the current date of the current month
                $attendance = Attendence::whereIn('stud_id', $stud_ids)
                    ->where('batch_id', $batch_id)
                    ->where('course_id', $course_id)
                    ->where('created_at','LIKE',"%$date%")
                    ->get();
                // $attendance = Attendence::where('created_at','LIKE',"%$date%")
                //                         ->get();
                // info("at".$attendance);
                $response['monthDays'] = $currentMonthDays;
                $response['lastAtt'] = Carbon::now()->day;
                info("lastAtt".$response['lastAtt']);
            } else {
                $date = Carbon::parse($selectedMonth);
                $daysInMonth = $date->daysInMonth;
                $attendance = Attendence::whereIn('stud_id', $stud_ids)
                    ->where('batch_id', $batch_id)
                    ->where('course_id', $course_id)
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->get();
                
                $response['monthDays'] = $daysInMonth;
                $response['lastAtt'] = $daysInMonth;
            }
            
            $response['status'] = 200;
            $response['message'] = 'Success';
            $response['attendance'] = $attendance;
            $response['stud'] = $stud;
            info("last".$response['lastAtt']);
            return response()->json($response);
        }
    
        // If not an AJAX request, prepare data for rendering the view
        $page_data['courselist'] = Course::get();
        $page_data['batch_daylist'] = Batchdayslist::get();
        $page_data['batch_list'] = Batch::get();
        return view('attendencelist')->with($page_data);
    }
    
    // public function admin_panel_att_listing(Request $req)
    // {
    //     // info("*******************************");
    //     if (request('ajaxData')) {
    //         $students = Student::get();
    //         $batchId = $req->input('batch_id');
    //         if(request('selectedMonth') == 'THIS'){
    //             $currentMonthDays = Carbon::now()->month(Carbon::now()->month)->daysInMonth;     //   total days in current month  
    //             $date = date('Y-m', strtotime(Carbon::now()));
    //             $attendance = Attendence::where('created_at','LIKE',"%$date%")
    //            ->get();
    //             $response['monthDays'] = $currentMonthDays;
    //             $response['lastAtt'] = Carbon::now()->day;
    //         }
    //              else {
    //                 if(strtotime(request('selectedMonth')) > strtotime(Carbon::now())){
                     
    //                 }
    //                 $date = request('selectedMonth');
    //                 $batchId =  request('selectBatch');
    //                 info("*******************************");
    //                 info($date);
    //                 info($batchId);
    //                 $month = Carbon::parse($date)->month;
    //                 info($month);
    //                 $year = Carbon::parse($date)->year;
    //                 info($year);
    //                 $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;
    //                 info($daysInMonth);
    //                 $attendance = Attendence::where('created_at','LIKE',"%$date%")
    //                             ->where('batch_id','LIKE',"%$batchId")->get();
    //                 info($attendance);
    //                 $response['monthDays'] = $daysInMonth;
    //                 $response['lastAtt'] = $daysInMonth;
    //         }
    //         $response['status'] = 200;
    //         $response['message'] = 'Success';
    //         $response['attendance'] = $attendance;
    //         $response['student'] = $students;
    //         $response['monthDays'] = $daysInMonth ?? $currentMonthDays;
    //         $response['lastAtt'] = $daysInMonth ?? Carbon::now()->day;
    
    //         return response()->json($response); // Return JSON response
    //     }
    //     $page_data['courselist'] = Course::get();
    //     $page_data['batch_daylist'] = Batchdayslist::get();
    //     $page_data['batch_list'] = Batch::get();
    //     // $batches = Batch::all(); 
    //     return view('attendencelist')->with($page_data);
    // }
    // public function admin_panel_att_listing(Request $request)
    // {
    //     if (request('ajaxData')) {
    //         $batch_id = request('selectBatch');
    //         $course_id = request('selectCourse');
    //         // Fetch students based on batch and course with their names
    //         $stud = Student::where('batch_id', $batch_id)
    //             ->where('course_id', $course_id)
    //             ->select('id', 'name')
    //             ->get();
    //         info($stud);
    //         // Extract student IDs for attendance query
    //         $stud_ids = $stud->pluck('id')->toArray();
            
           
    //         $selectedMonth = request('selectedMonth');
    //         $currentMonthDays = Carbon::now()->month(Carbon::now()->month)->daysInMonth;     //   total days in current month  
    //         $date = date('Y-m', strtotime(Carbon::now()));// Current date in 'Y-m-d' format
            
    //         if ($selectedMonth == $currentMonthDays) {
    //             // Fetch attendance records for the selected students, batch, and course for the current date
    //             $attendance = Attendence::whereIn('stud_id', $stud_ids)
    //                 ->where('batch_id', $batch_id)
    //                 ->where('course_id', $course_id)
    //                 ->whereDate('created_at', $date)
    //                 ->get();
    //                 info("s".$attendance);
                
    //             $response['monthDays'] = Carbon::now()->daysInMonth;  // Total days in the current month
    //             $response['lastAtt'] = Carbon::now()->day;
    //         }else {
    //             $date = Carbon::parse($selectedMonth);
    //             $daysInMonth = $date->daysInMonth;
                
    //             // Fetch attendance records for the selected students, batch, and course for the entire selected month
    //             $attendance = Attendence::whereIn('stud_id', $stud_ids)
    //                 ->where('batch_id', $batch_id)
    //                 ->where('course_id', $course_id)
    //                 ->whereYear('created_at', $date->year)
    //                 ->whereMonth('created_at', $date->month)
    //                 ->get();
                
    //             $response['monthDays'] = $daysInMonth;
    //             $response['lastAtt'] = $daysInMonth;
    //         }
            
    //         $response['status'] = 200;
    //         $response['message'] = 'Success';
    //         $response['attendance'] = $attendance;
    //         $response['stud'] = $stud;
        
    //         return response()->json($response);
    //     }
    
    //     // If not an AJAX request, prepare data for rendering the view
    //     $page_data['courselist'] = Course::get();
    //     $page_data['batch_daylist'] = Batchdayslist::get();
    //     $page_data['batch_list'] = Batch::get();
    //     return view('attendencelist')->with($page_data);
    // }
    public function attendencestatus(Request $request, $id = '')
    {
        $page_data['studentlist'] = Student::get();
        $page_data['attendence'] = Attendence::get();
        $page_data['courselist'] = Course::get();
        $page_data['student'] = Student::get();
        $page_data['batch_daylist'] = Batchdayslist::get();
        $page_data['batch_list'] = Batch::get();
        $batches = Batch::all();
        return view('attendencestatus')->with($page_data);
    }
    
    public function get_Attendence(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/');
        }
        //info(request()->all()) ;
        //info(request('batch_id'));
        // info($request->batch_id);
        // info($request->course_id);
        // info($request->date);
        $users = Attendence::join('student', 'student.id', '=', 'attendence.stud_id')
                            ->where('attendence.batch_id', $request->batch_id)
                            ->where('attendence.course_id', $request->course_id)
                            ->where('attendence.date', $request->date)
                            ->select('attendence.*', 'student.name as name') // Alias the name column
                            ->orderBy('attendence.id', 'desc')
                            ->get();
                
        return datatables()->of($users)
            ->addIndexColumn()
            
            ->editColumn('attendence_mark', function ($user) {
                // Convert 0 to "Absent" and 1 to "Present"
                return $user->attendence_mark ? 'Present' : 'Absent';
            })
            ->addColumn('action', function($data) {
                $actions = '<ul class="navbar-nav navbar-right">
                                </div>
                                <li class="dropdown">
                                    <a href="#" data-toggle="dropdown">
                                            <i class="fa fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item has-icon" onclick="updateAttendance('.$data->id.', 1)">
                                            <i class="far fa-user"></i> Present
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item preview-item" onclick="updateAttendance('.$data->id.', 0)">
                                            <i class="fas fa-sign-out-alt"></i> Absent
                                        </a>
                                    </div>
                                </li>
                            </ul>';
                return $actions;
                })
                ->rawColumns(['attendence_mark','action'])
                ->make(true);
        }
        public function updateattendencestatus(Request $request){
            // info("************");
            $stud_id = $request->input('stud_id');
            // info("--".$stud_id);
            $attendence_mark = $request->input('attendence_mark');
            // info("----".$attendence_mark);
            $attendance = Attendence::find($stud_id);
            if ($attendance) {
                $attendance->attendence_mark = $attendence_mark;
                // info("******************+++++".$attendence_mark);
                $attendance->save();
                return $attendance->attendence_mark;
                // return redirect()->back()->with('success', 'Attendance updated successfully');
            } 
        }
        
}