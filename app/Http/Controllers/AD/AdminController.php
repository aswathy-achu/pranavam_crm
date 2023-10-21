<?php

namespace App\Http\Controllers\AD;

use App\Admin;
use App\Course;
use App\Http\Controllers\BladeController;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\Permission;
use App\Product;
use App\Staff;
use App\Student;
use App\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;


class AdminController extends Controller
{
    // public function dashboard(){
    //     return view('dashboard');
    // }

    public function dashboard($id = '') {
        $endOfWeek = Carbon::now();
        $startOfWeek = Carbon::now()->subDays(7);
    
        $students = Student::select('student.*', 'course.course_name')
            ->join('course', 'student.course_id', '=', 'course.id')
            ->whereBetween('student.created_at', [$startOfWeek, $endOfWeek])
            ->get();
    
        $topPerformers = Student::where('student_performance', 'Excellent')->get();
        $badStudents = Student::where('student_performance', 'Bad')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->get();
            // info("9/*/-/-".$badStudents);
        $bestStudents = Student::where('progress_track', 'professional')->get();
        $productList = Product::all(['id', 'product_name', 'product_selling_price', 'product_buy_price']);
    
        $courselist = Course::get();
        $menu = 'dashboard';
    
        return view('dashboard', [
            'students' => $students,
            'topPerformers' => $topPerformers,
            'badStudents' => $badStudents,
            'bestStudents' => $bestStudents,
            'productList' => $productList,
            'courselist' => $courselist,
            'menu' => $menu,
        ]);
    }
    
    public function adminprofile(Request $req,$id='')
    {
        if (!Auth::check()) {return Redirect::to('/');}
        $user_id= Auth::User()->id;
        // return $user_id;
        $admin=Admin::where('user_id',$user_id)->first();
      
        return view('createadminprofile', compact('admin'));
    }
    // public function get_fee()
    // {
    //     if (!Auth::check()) {
    //         return Redirect::to('/');
    //     }
    
    //     // Get the current date and the current month
    //     $now = Carbon::now();
    //     $currentMonth = $now->month;
    
    //     // Get all students' details from the students table
    //     $students = Student::where('date_of_join', '<>', null) // Ensures that date_of_join is not null
    //                         ->orderBy('id', 'desc')
    //                         ->get();
    //     foreach ($students as $student) {
    //         // Get the latest invoice for the student for the current month
    //         $currentMonthInvoice = $student->invoices()
    //             ->where('balance_amount', 0)
    //             ->whereMonth('created_at', Carbon::now()->month)
    //             ->first();
    
    //         if ($currentMonthInvoice) {
    //             // If the student has paid the fee for the current month, change status to 'Paid'
    //             $student->status = 'Paid';
    //         } else {
    //             // Otherwise, change status to 'Unpaid'
    //             $student->status = 'Unpaid';
    //         }
    //     }
    //     // Filter students to include only those who have a balance amount greater than 0 and haven't paid for the current month
    //     $studentsWithBalance = $students->filter(function ($student) use ($currentMonth, $now) {
    //         $dateOfJoining = Carbon::createFromTimestamp($student->date_of_join);
    
    //         // Set the fee due date based on the conditions
    //         if ($dateOfJoining->day <= 10 && $dateOfJoining->month == $currentMonth) {
    //             // If the student's admission date is in the current month, the fee due date is 15th of next month
    //             $dueDate = $now->copy()->addMonth()->day(15);
    //         } else {
    //             // Otherwise, set the fee due date based on the admission date
    //             if ($dateOfJoining->day <= 10) {
    //                 $dueDate = $now->copy()->day(15);
    //             } else {
    //                 $dueDate = $now->copy()->day(25);
    //             }
    //         }
    
    //         // Check if the student has already paid the fee for the current month
    //         $hasPaidThisMonth = $student->invoices()
    //             ->where('balance_amount', 0)
    //             ->whereMonth('created_at', $currentMonth)
    //             ->exists();
    
    //         // Return true if the student has a balance amount greater than 0 and hasn't paid for the current month
    //         return $student->invoices()->where('balance_amount', '>', 0)->exists() && !$hasPaidThisMonth;
    //     });
    
    //     return datatables()->of($studentsWithBalance)
    //         ->editColumn('due_date', function ($student) use ($now) {
    //             $dateOfJoining = Carbon::createFromTimestamp($student->date_of_join);
    
    //             // Set the fee due date based on the conditions
    //             if ($dateOfJoining->day <= 10 && $dateOfJoining->month == $now->month) {
    //                 $dueDate = $now->copy()->addMonth()->day(15);
    //             } else {
    //                 if ($dateOfJoining->day <= 10) {
    //                     $dueDate = $now->copy()->day(15);
    //                 } else {
    //                     $dueDate = $now->copy()->day(25);
    //                 }
    //             }
    
    //             return $dueDate->format('d-M-Y');
    //         })
    //         ->addColumn('status', function ($student) {
    //             // Return the status ('Paid' or 'Unpaid') determined in the previous loop
    //             return $student->status;
    //         })
    //         ->addColumn('action', function ($student) {
    //             if ($student->status == 'Paid') {
    //                 // If the student has paid, display a 'detail' button
    //                 return '<button class="btn btn-success">detail</button>';
    //             } else {
    //                 // If the student hasn't paid, display an 'inform' button
    //                 return '<button class="btn btn-danger">inform</button>';
    //             }
    //         })
    //         ->make(true);
    // }
    public function get_fee()
    {
        if (!Auth::check()) {
            return Redirect::to('/');
        }
        $now = Carbon::now();
        $currentMonth = $now->month;
        $students = Student::orderBy('id', 'desc')->get();
        foreach ($students as $student) {
            // Get the latest invoice for the student for the current month
            $currentMonthInvoice = $student->invoices()
                ->whereMonth('created_at', Carbon::now()->month)
                ->latest()
                ->first();
            info("*********************".$currentMonthInvoice);
            if (!$currentMonthInvoice) {
                $student->status = 'Unpaid'; // Condition 3: No invoice for the current month found
            } else {
                if ($currentMonthInvoice->balance_amount == 0) {
                    $student->status = 'Paid'; // Condition 1: Balance amount is 0
                } else {
                    $paidAmount = $currentMonthInvoice->account_amt - $currentMonthInvoice->balance_amount;
                    if ($paidAmount > 0) {
                        $student->status = ' Paid'; // Condition 2: Some amount is paid, but balance_amount > 0
                    } else {
                        $student->status = 'Unpaid'; // Condition 2: No payment made, balance_amount > 0
                    }
                }
            }
        }
        // Filter students to include only those who have a balance amount greater than 0 and haven't paid for the current month
        $studentsWithBalance = $students->filter(function ($student) use ($currentMonth, $now) {
            $dateOfJoining = Carbon::createFromTimestamp($student->date_of_join);
    
            // Set the fee due date based on the conditions
            if ($dateOfJoining->day <= 10 && $dateOfJoining->month == $currentMonth) {
                // If the student's admission date is in the current month, the fee due date is 15th of next month
                $dueDate = $now->copy()->addMonth()->day(15);
            } else {
                // Otherwise, set the fee due date based on the admission date
                if ($dateOfJoining->day <= 10) {
                    $dueDate = $now->copy()->day(15);
                } else {
                    $dueDate = $now->copy()->day(25);
                }
            }
    
            // Check if the student has already paid the fee for the current month
            $hasPaidThisMonth = $student->invoices()
                ->where('balance_amount', 0)
                ->whereMonth('created_at', $currentMonth)
                ->exists();
    
            // Return true if the student has a balance amount greater than 0 and hasn't paid for the current month
            return $student->invoices()->where('balance_amount', '>', 0)->exists() && !$hasPaidThisMonth;
        });
    
        return datatables()->of($students)
        ->addIndexColumn()
        ->editColumn('due_date', function ($student) use ($now) {
            $dateOfJoining = Carbon::createFromTimestamp($student->date_of_join);
            if ($dateOfJoining->day <= 10 && $dateOfJoining->month == $now->month) {
                                $dueDate = $now->copy()->addMonth()->day(15);
                            } else {
                                if ($dateOfJoining->day <= 10) {
                                    $dueDate = $now->copy()->day(15);
                                } else {
                                    $dueDate = $now->copy()->day(25);
                                }
                            }
                
                            return $dueDate->format('d-M-Y');
                        })
    
        ->addColumn('status', function ($student) {
                        return $student->status;
                    })
        // ->addColumn('action', function ($student) {
        //     // Check if the student has a corresponding invoice record
        //     $invoice = Invoice::where('stud_id', $student->id)->first();
    
        //     return $invoice ? '<button class="btn btn-success">detail</button>' : '<button class="btn btn-danger">inform</button>';
        // })
        ->addColumn('action', function ($row) {
            $invoice = Invoice::where('stud_id', $row->id)->first();
            
            if ($row->status === 'Unpaid') {
                $actionButton = '<button class="btn btn-danger">inform</button>';
            } else {
                if ($invoice) {
                    $pdfLink = route('download.invoice.pdf', ['invoice' => encrypt($invoice->id)]);
                    $actionButton = '<a href="' . $pdfLink . '" target="_blank" class="btn btn-success">detail</a>';
                } else {
                    $actionButton = '';
                }
            }
            
            return $actionButton;
        })
        
        ->make(true);
    }
    public function downloadpdf(Request $request, $invoice)
    {
        try {
            $id = decrypt($invoice);
            // info("*-*".$id);
            $invoice = Invoice::where('id',$id)->first();
            // info("*-++++++++++++++++".$invoice);
            $pdf = Pdf::loadView('viewinvoicePdf', ['invoice' => $invoice]);
            
            // Return the PDF as a response instead of downloading it
            return $pdf->stream('pdfview.pdf');
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->back()->with('error', 'Invalid Invoice ID');
        }
    }
    
    public function viewadminprofile($id='')
    {
        if (!Auth::check()) {
          return redirect('/');
        }
        $userId = Auth::user()->id;
        if($id)
        {
          $admin = Admin::where('id', $id)->first();
        } else{
          $admin = Admin::where('user_id', $userId)->first();
        }

        $pageData = ['admin' => $admin];
        return view('adminprofileview', $pageData);
    }
    public function createadmin(Request $request, $id = '')
    {
        // Create an empty admin object if $id is not provided
        $admin = new Admin(); // Assuming you have an Admin model
    
        // If $id is provided, fetch the admin record
        if (!empty($id)) {
            $admin = Admin::find($id);
        }
    
        $pageData = ['admin' => $admin];
        return view('createadminprofile', $pageData);
    }
    
    public function manage_admin(Request $req,$id='')
    {
    //    info('dsfdh');
       
    
         if ($_POST) {
             if ($req->post('id') == '') {
    
                
    
                $data = new User;
                $data->name = $req->post('fname');
                $data->type = 'A';
                $data->email = $req->post('email');
                $data->password = Hash::make($req->post('password'));
                $data->save();
    
                
                $admin = new Admin;
             } else {
                $admin = Admin::find($req->post('id'));
                // print_r($staff->user_id);die;
    
                User::where('id', $admin->user_id)
                               ->update(['name' => $req->post('fname'), 'email' => $req->post('email'),'type' => 'A']);
             }
    
             if (!$req->post('id')) {
                $admin->user_id = $data->id;
             }
             $admin->full_name = $req->post('fname');
             $admin->alternate_number = $req->post('alternate_number');
             $admin->gender = $req->post('gender');
             $admin->dob = $req->post('dob');
             $admin->email = $req->post('email');
             $admin->mobile_number = $req->post('mobile_number');
            //  $staff->user_role = 'S';
             $admin->address1 = $req->post('address1');
             $admin->state = $req->post('state');
             $admin->address2 = $req->post('address2');
             $admin->postcode = $req->post('postcode');
             $admin->city = $req->post('city');
             $admin->country = $req->post('country');
             $admin->doj = $req->post('doj');
             if ($req->hasFile('admin_profile_image')) {
                if ($req->input('id')) {
                    if (Storage::exists('admin_photo/' . $admin->admin_profile_image)) {
                        Storage::delete('admin_photo/' . $admin->admin_profile_image);
                    } 
                }
                $extension = $req->file('admin_profile_image')->extension();
                $filename = rand() . '.' . $extension;
                $req->file('admin_profile_image')->storeAs('admin_photo', $filename);
                $admin->admin_profile_image = $filename;
            }
             $admin->save();
             if ($req->post('id')) {
                 return Redirect::to('dashboard')->with('success','Update successfully!');
             } else {
                 return Redirect::to('dashboard')->with('success','Add successfully!');
             }
         }
         if ($id) {
             $page_data['admin'] = Admin::find($id);
         }
        
         $page_data['menu'] = 'manage_Admin';
    
         return view('createadminprofile')->with($page_data);
        
    }
    public function login(){
        return view('login');
    }
    public function dologin(Request $request)
    {
        // $check = Hash::make("pranavamadmin2023@");
        // print_r($check);die;
        $username = $request->post('email');
        $rules = array(
            'email'    => 'required|email',
            'password' => 'required'
            );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('/role_redirects')
                ->withErrors($validator)
                ->withInput($request->all());
        } else {
            $userdata = array(
                'email'     => $request->post('email'),
                'password'  => $request->post('password')
            );
        }

        $user = DB::table('users')->where('email',$username)->first();

        if (!empty($user)) {

            if (Auth::attempt($userdata)) {
                    return Redirect::to('/role_redirects');
                } else {
                    $res = 'Username or Password error';
                }
        } else {
            $res = 'Incorrect email or password.';
        }

        session()->put('error',$res);
        return Redirect::back();
    }

    public function role_redirects()
    {
        if (Auth::check())
        {
            $usertype = Auth::user()->type;
            // $staffType = Auth::user()->staffType;
            switch (true) {
            case ($usertype == 'A'):
                return Redirect::to('dashboard');
                break;
            case ($usertype == 'S'):
                return Redirect::to('dashboard');
                break;
            }
        }else{
            $data['active'] = 'login';
            return view('login')->with($data);
        }

    }

    public function logout()
    {
        // print_r("sdsd");die;
        Auth::logout();
        // alert()->success('You have been logged out.', 'Good bye!');
        return Redirect::to('/login');
    }
    
 
public function staffdashboard(){
    return view('staff/staffdashboard');
}   


}