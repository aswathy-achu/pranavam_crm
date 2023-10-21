<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Batchdayslist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class BatchController extends Controller
{
    public function createbatch(){
        $page_data['batch_daylist'] = Batchdayslist::get();
        return view('createbatch')->with($page_data);
    }

    public function dayschedule($id = '')
    {
        $batch = Batch::select('batch_day')->distinct()->get();
        $page_data['batch_daylist'] = Batchdayslist::get();
        return view('dayschedule', compact('batch'))->with($page_data);
    }
    public function timeschedule($id=''){
        if (!Auth::check()) {return Redirect::to('/');}
        $page_data['batch_dayslist_id'] = $id;
        return view ("timeschedule")->with($page_data);
    }
    public function get_timeschedule($id='')
    {
    $day = Batch::where('batch_day',$id)->orderBy('id', 'desc')->get();
    return datatables()->of($day)
        ->addIndexColumn()
        ->addColumn('action', function ($batch) {
            $details ='<a href="" data-toggle="modal" target="_blank" onclick="show_large_models('.$batch->id.','."'dayModal'".')" data-target="#newmodel"><i class="fas fa-eye"></i></a>';
            $details.='  <a href="javascript:void(0)" data-toggle="modal" data-target="#delete_modal" title="Delete" onclick=delete_confirm("/del_batch/'.$batch->id.'")><i class="fas fa-trash"></i></a>';
            return $details;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getTimes(Request $request){
        $selectedDay = $request->input('day');
        return $selectedDay;
    }
    public function check_batch(){
            
        $batchDaySelect = request('batchDaySelect');
        $fromTimeInput = request('fromTimeInput');
        $toTimeInput = request('toTimeInput');
        $occupy_students = request('occupy_students');
        info($batchDaySelect);
        info($fromTimeInput);
        info($toTimeInput);
        info($occupy_students);
        $total_no_of_student = request('total_no_of_student');
        try {
            info("========================");

            $check_duplicate = Batch::where('batch_day',$batchDaySelect)
                                    ->where('from_time',$fromTimeInput)
                                    ->where('to_time',$toTimeInput)
                                    ->first();
            info($check_duplicate);
            // return $check_duplicate;
            if(!empty($check_duplicate))
            {
                info("ifffffffffffff");
                if (!empty($check_duplicate)) {
                    // Update existing batch
                    $check_duplicate->occupy_students = $occupy_students;
                    $check_duplicate->total_no_of_student = $check_duplicate->occupy_students + $total_no_of_student;
                    $check_duplicate->save();
                    return Redirect::route('dayschedule')->with('success', 'Updated successfully!');
                    // return "success";
                }
            
            } else{
                info("elseeeeeeeeeeeeeee");
                $batch = new Batch;
                $batch->batch_day = $batchDaySelect;
                $batch->from_time = $fromTimeInput;
                $batch->to_time = $toTimeInput;
                $batch->occupy_students = $occupy_students;
                $batch->total_no_of_student = $total_no_of_student;
                $batch->save();
                return Redirect::route('dayschedule')->with('success', 'Added successfully!');
            }
        } catch (\Throwable $th) {
                
            return "error";
        }
        
    }
    public function dayModal(Request $req, $id = '')
    {
       
        if (!Auth::check()) {
            return Redirect::to('/');
        }
        $day = Batch::find($id);
        $days = Batchdayslist::find($id);

        if ($req->isMethod('post')) {
            $day->update([
                'from_time' => $req->input('from_time'),
                'occupy_students' => $req->input('occupy_students'),
                'to_time' => $req->input('to_time'),
            ]);

            return back()->with('success', 'Update Successful.');
        }

        return BladeController::dayModal($id, $day, $days);
    }
    public function del_batch($id)
        {   
            if (!Auth::check()) {return Redirect::to('/');}
            $data = Batch::find($id);
            if ($data) {
                $data->delete();
                return Redirect::back()->with('success','Delete successfully!');
            } else {
                return Redirect::back()->with('error','Data Not Found');
            }
    }  
}

