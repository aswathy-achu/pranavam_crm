<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Batchdayslist;
use App\Course;
use App\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Exceptions\Exception;

class CourseController extends Controller
{
    public function addcourse(){
        $page_data['batch_daylist'] = Batchdayslist::get();
        $page_data['batch_list'] = Batch::get();
        $page_data['stafflist'] = Staff::get();
        $batches = Batch::all(); 
        return view('addcourse',compact('batches'))->with($page_data);
    }
   
    public function manage_course(Request $request,$id=''){
        try{
            if (!Auth::check()) {
                return redirect('/');
            }
            if ($request->isMethod('post')) {
                if ($request->input('id') == '') {
                    $course = new Course();
                } else {
                    $course = Course::find($request->input('id'));
                    info($course);
                }
                $batch_id = $request->input('batch_id');
                $batch = Batch::find($batch_id);
                $course->batch_id = $batch_id;
                $course->course_name = $request->input('course_name');
                $course->description = $request->input('description');
                $course->course_fee = $request->input('course_fee');
                $course->duration = $request->input('duration');
                $course->faculty = $request->input('faculty');
                
                if ($request->hasFile('course_file')) {
                    // Delete old profile image if it exists
                    if ($course->course_file && Storage::exists('course_file/' . $course->course_file)) {
                        Storage::delete('course_file/' . $course->course_file);
                    }
        
                    $extension = $request->file('course_file')->extension();
                    $filename = rand() . '.' . $extension;
                    $request->file('course_file')->storeAs('course_file', $filename);
        
                    $course->course_file = $filename;
                }
                
                    $course->save();
            
                    if ($request->input('id')) {
                        return redirect('/courselist')->with('success', 'Update successful!');
                    } else {
                        
                        return redirect('/courselist')->with('success', 'Add successful!');
                    }
                }
                
                if ($id) {
                    $course = Course::find($id);
                } else {
                    $course = null;
                }          
                $page_data['batch_daylist'] = Batchdayslist::all();
                $page_data['batch'] = Batch::all();
                $page_data['stafflist'] = Staff::all();
                $page_data['course'] = $course;
                $page_data['menu'] = 'manage_course';
            
                return view('addcourse')->with($page_data);
            } catch (Exception $e) {
                // Handle the exception here, log the error, display a user-friendly error page, or take any appropriate action.
                return redirect('/error')->with('error', 'An error occurred. Please try again later.');
            }
            }
            public function courselist(){
                $page_data['course'] = Course::get();
                return view('courselist')->with($page_data);
            }
            public function del_course(Request $request, $id)
            {   
                if (!Auth::check()) {
                    return redirect('/');
                }
            
                $data = Course::find($id);
            
                if (!$data) {
                    return redirect()->back()->with('error', 'Data Not Found');
                }
            
                if ($data->students()->count() > 0) {
                    return redirect()->back()->with('error', 'Cannot delete a course with registered students');
                }
            
                $data->delete();
                return redirect()->back()->with('success', 'Course deleted successfully!');
            }
            
            
              public function courseview($id=''){
                if (!Auth::check()) {return Redirect::to('/');}
                $page_data['course'] = Course::where('id',$id)->get();
                return view('courseview')->with($page_data);
              }  
            }

    

