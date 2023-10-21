<?php

namespace App\Http\Controllers;

use App\Attendence;
use App\Batch;
use App\Batchdayslist;
use App\Course;
use App\Invoice;
use App\Product;
use App\Student;
use App\StudentPayment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Exceptions\Exception;

class InvoiceController extends Controller
{
    public function addinvoice()
    {
        // Fetch the latest invoice if it exists, otherwise set it to null
        $lastInvoice = Invoice::latest()->first();
        $nextInvoiceNumber = $lastInvoice ? $lastInvoice->id + 1 : 1;
        $prefix = 'IN';
        $invoiceNo = $prefix . ' ' . $nextInvoiceNumber;
    
        $pagedata['prefix'] = $prefix . ' ';        $pagedata['batch_daylist'] = Batchdayslist::get();
        $pagedata['batch_list'] = Batch::get();
        $pagedata['courselist'] = Course::get();
        $pagedata['studentlist'] = Student::get();
        $pagedata['productlist'] = Product::get();
       
    
        // Pass the $pagedata array and the $nextInvoiceNumber variable to the view
        return view('createbill', compact('nextInvoiceNumber'))->with($pagedata);
    }
    // public function manage_invoice(Request $request, $id = '') {
    //     try {
    //         if ($request->isMethod('post')) {
    //             if ($request->input('id') == '') {
    //                 $invoice = new Invoice;
    //                 info($invoice);
    //             } else {
    //                 $invoice = Invoice::find($request->input('id'));
    //             }
    
    //             // Assign values to invoice properties
    //             $batch_id = $request->input('batch_id');
    //             $batch = Batch::find($batch_id);
    //             $invoice->batch_id = $batch_id;
    //             $invoice->course_id = $request->input('course_id');
    //             $invoice->invoice_no = $request->input('invoice_no');
    //             $invoice->Received_from = $request->input('received_from');
    //             $invoice->amount_in_word = $request->input('amount_in_word');
    //             $invoice->date = $request->input('date');
    //             $invoice->from_date = $request->input('from_date');
    //             $invoice->to_date = $request->input('to_date');
    //             $invoice->paid_by = $request->input('paid_by');
    //             $invoice->account_amt = $request->input('account_amt');
    //             $invoice->fees = $request->input('fees');
    //             $invoice->stud_id = $request->input('name');
    //             $invoice->product_id = $request->input('product');
    //             $invoice->email = $request->input('email');
    //             $invoice->phone = $request->input('phone');
                
    //             $paid_amount = $request->input('paid_amt');
    //             $invoice->paid_amount = $paid_amount;
    //             $invoice->balance_amount = $invoice->balance_amount - $paid_amount;
    
    //             $invoice->save();
    
    //             if ($request->input('id')) {
    //                 return redirect('/billinglist')->with('success', 'Update successfully!');
    //             } else {
                   
    //                 return redirect('/billinglist')->with('success', 'Add successfully!');
    //             }
    //         }
    
    //         if ($id) {
    //             $invoice = Invoice::find($id);
    //         } else {
    //             $invoice = null;
    //         }
        
    //         // Populate page data for rendering
    //         $page_data = [
    //             'productlist' => Product::all(),
    //             'batch_daylist' => Batchdayslist::all(),
    //             'courselist' => Course::all(),
    //             'studentlist' => Student::all(),
    //             'menu' => 'manage_invoice',
    //             'invoice' => $invoice,
    //         ];
    
    //         return view('createbill')->with($page_data);
    //     } catch (Exception $e) {
    //         // Handle the exception here, log the error, display a user-friendly error page, or take any appropriate action.
    //         return redirect('/error')->with('error', 'An error occurred. Please try again later.');
    //     }
    // }
    public function manage_invoice(Request $request, $id = '') {
        try {
            if ($request->isMethod('post')) {
                if ($request->input('id') == '') {
                    $invoice = new Invoice;
                } else {
                    $invoice = Invoice::find($request->input('id'));
                }
    
                // Assign values to invoice properties
                    $batch_id = $request->input('batch_id');
                    $batch = Batch::find($batch_id);
                    $invoice->batch_id = $batch_id;
                    $invoice->course_id = $request->input('course_id');
                    $invoice->invoice_no = $request->input('invoice_no');
                    $invoice->Received_from = $request->input('received_from');
                    $invoice->amount_in_word = $request->input('amount_in_word');
                    $invoice->date = $request->input('date');
                    $invoice->from_date = $request->input('from_date');
                    $invoice->to_date = $request->input('to_date');
                    $invoice->paid_by = $request->input('paid_by');
                    $invoice->account_amt = $request->input('account_amt');
                    $invoice->fees = $request->input('fees');
                    $invoice->stud_id = $request->input('name');
                    $invoice->product_id = $request->input('product');
                    $invoice->email = $request->input('email');
                    $invoice->phone = $request->input('phone');
                    $paid_amount = $request->input('paid_amt');
                
                    $studentPaidAmount = StudentPayment::where('stud_id', $invoice->stud_id)->sum('paid_amt');
                    if ($studentPaidAmount >= $invoice->account_amt) {
                        $invoice->balance_amount = 0;
                    } else {
                        $invoice->balance_amount = max($invoice->account_amt - $studentPaidAmount, 0);
                    }
                    $paid_amount = $request->input('paid_amt');
                    if ($paid_amount > $invoice->balance_amount) {
                        $paid_amount = $invoice->balance_amount;
                    }
                    
                    $invoice->paid_amount = $paid_amount;
                    $invoice->balance_amount = $invoice->balance_amount - $paid_amount;
                    $invoice->save();
        

                    $studentpayment = new StudentPayment;

                    // Copy values from the Invoice model to StudentPayment model
                    $studentpayment->invoice_id = $invoice->id;
                    $studentpayment->fee_type = $invoice->fees;
                    $studentpayment->stud_id = $invoice->stud_id;
                    $studentpayment->amount = $invoice->account_amt;
                    $studentpayment->invoice_no = $invoice->invoice_no;
                    $studentpayment->paid_amt = $invoice->paid_amount;
                    $studentpayment->balance_amt = $invoice->balance_amount;
                    $studentpayment->date = now();
                    if ($invoice->account_amt == 0) {
                        $studentpayment->fee_type = 0;
                    }// Store the current timestamp as payment date
                    $studentpayment->save();
                    info("*-+++++++++++++++".$studentpayment);
                    
                    if ($request->input('id')) {
                        return redirect('/billinglist')->with('success', 'Update successfully!');
                    } else {
                        return redirect('/billinglist')->with('success', 'Add successfully!');
                    }
                }
                
            if ($id) {
                $invoice = Invoice::find($id);
            } else {
                $invoice = null;
            }
    
            // Populate page data for rendering
            $page_data = [
                'productlist' => Product::all(),
                'batch_daylist' => Batchdayslist::all(),
                'courselist' => Course::all(),
                'studentlist' => Student::all(),
                'menu' => 'manage_invoice',
                'invoice' => $invoice,
            ];
    
            return view('createbill')->with($page_data);
        } catch (Exception $e) {
            return redirect('/error')->with('error', 'An error occurred. Please try again later.');
        }
    }
    
    
    // public function manage_invoice(Request $request, $id = '')
    // {
    //     try {
    //         if ($request->isMethod('post')) {
    //             // Check if the invoice is being edited or created
    //             if ($request->input('id') == '') {
    //                 $invoice = new Invoice;
                   
    //             } else {
    //                 $invoice = Invoice::find($request->input('id'));
    //             }
    //             $batch_id = $request->input('batch_id');
    //             $batch = Batch::find($batch_id);
    //             $invoice->batch_id = $batch_id;
    
    //             $course_id = $request->input('course_id');
    //             $course = Course::find($course_id);
    //             $invoice->course_id = $course_id;
    //             $invoice->invoice_no = $request->input('invoice_no');
    //             $invoice->Received_from = $request->input('received_from');
    //             $invoice->amount_in_word = $request->input('amount_in_word');
    //             $invoice->date = $request->post('date');
    //             $invoice->from_date = $request->post('from_date');
    //             $invoice->to_date = $request->post('to_date');
    //             $invoice->paid_by = $request->input('paid_by');
    //             $invoice->account_amt = $request->input('account_amt');
    //             $invoice->fees = $request->input('fees');
    //             $invoice->stud_id = $request->input('name');
    //             $invoice->product_id = $request->input('product');
    //             $invoice->email = $request->input('email');
    //             $invoice->phone = $request->input('phone');
                
    //             $paid_amount = $request->input('paid_amt');
    //             $invoice->paid_amount = $paid_amount;
    //             $invoice->balance_amount = $invoice->account_amt - $paid_amount;
                
    //             $invoice->save();
    
    //             if ($request->input('id')) {
    //                 return redirect('/billinglist')->with('success', 'Update successfully!');
    //             } else {
    //                 return redirect('/billinglist')->with('success', 'Add successfully!');
    //             }
    //         }
        
    //         if ($id) {
    //             $page_data['invoice'] = Invoice::find($id);
    //         }           
    //         $page_data['productlist'] = Product::all();
    //         $page_data['batch_daylist'] = Batchdayslist::all();
    //         $page_data['courselist'] = Course::all();
    //         // $page_data['invoice'] = Invoice::all();
    //         $page_data['studentlist'] = Student::all();
    //         $page_data['menu'] = 'manage_invoice';
    //         return view('createbill')->with($page_data);
    //     } catch (Exception $e) {
    //         // Handle the exception here, log the error, display a user-friendly error page, or take any appropriate action.
    //         return redirect('/error')->with('error', 'An error occurred. Please try again later.');
    //     }
    // }

// public function getFeeData(Request $request)
//     {
//         $batch_id = $request->input('stud_id');
//         info($batch_id);
//          $invoice = Student::find($batch_id, ['id', 'fees']);
        
//         info($invoice);
//         if ($invoice) {
//           return response()->json($invoice);
//         } 
//     }
public function getFeeData(Request $request)
{
    $stud_id = $request->input('stud_id');
    
    $student = Student::find($stud_id, ['id', 'fees']);
    
    $latestInvoice = Invoice::where('stud_id', $stud_id)
        ->select('balance_amount', 'paid_amount', 'updated_at')
        ->orderBy('updated_at', 'desc')
        ->first();

    if ($student) {
        $accountAmount = ($latestInvoice) ? $latestInvoice->paid_amount : $student->fees;
        
        return response()->json([
            'student' => $student,
            'invoice' => [
                'balance_amount' => ($latestInvoice) ? $latestInvoice->balance_amount : $student->fees,
                'account_amnt' => $accountAmount,
                'last_paid_updated_at' => ($latestInvoice) ? $latestInvoice->updated_at : null,
            ],
        ]);
    }
}


public function getBalanceData(Request $request)
{
    $batch_id = $request->input('batch_id');
    info($batch_id);
    
}
public function billinglist()
{
    return view('billinglist');
} 
public function get_bill()
{
    $users = Invoice::orderBy('id','desc');
    return datatables()->eloquent($users)
    ->addIndexColumn()
    ->editColumn('stud_id', function ($f) {
        $studentId = explode(',', $f->stud_id);
        $studentname = Student::whereIn('id', $studentId)->pluck('name')->toArray();
        return implode(', ', $studentname);
    })
    ->addColumn('viewinvoice', function ($row) {
        return '<a href="' . route('view.invoice.pdf', ["invoice"=>encrypt($row->id)]) . '" target="_blank"><i class="fas fa-file pdf" style="font-size:22px;color: #6c7293;"></i></a>';
    })
    
    ->addColumn('action', function ($f) {
        $details = '<a href="'.url('/manage_invoice').'/'.$f->id.'" class="fas fa-edit"></a>';


        return $details;
    })
    ->rawColumns(['viewinvoice','action'])

    ->make(true);
}
public function viewInvoicePdf(Request $request, $invoice)
    {
        try {
            $id = decrypt($invoice);
            info("*-*".$id);
            $invoice = Invoice::where('id',$id)->first();
            info("*-++++++++++++++++".$invoice);
            $pdf = Pdf::loadView('viewinvoicePdf', ['invoice' => $invoice]);
            
            // Return the PDF as a response instead of downloading it
            return $pdf->stream('pdfview.pdf');
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->back()->with('error', 'Invalid Invoice ID');
        }
    }
    public function getStudentData(Request $request)
    { 
        $batch_id = $request->batch_id;
        info($batch_id);
        $studentData = Student::where('batch_id', $batch_id)->get(['id','name'])->toArray();
                        // ->where('name', $studentName)
                        // ->get(['id', 'name', 'fees'])
                        // ->toArray();
        info($studentData);
        return response()->json($studentData);
        }	
        public function studentpaymenthistory(){
            $page_data['studentlist'] = Student::get();
            $page_data['attendence'] = Attendence::get();
            $page_data['courselist'] = Course::get();
            $page_data['student'] = Student::get();
            $page_data['batch_daylist'] = Batchdayslist::get();
            $page_data['batch_list'] = Batch::get();
            $batches = Batch::all();
            return view('studentpaymenthistory')->with($page_data);
        }
        public function get_paymenthistory(Request $request){
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
            
            ->addColumn('action',  function ($d)
            {
                $details=' <a href="'.url('viewPaymentHistory').'/'.$d->id.'" class="btn btn-primary btn-icon-text btn-sm" title="payment history"> <i class="mdi mdi-file-tree"></i>
                  </a> ';
               
                return $details;
                
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
        public function viewPaymentHistory($id='')
    {
        if (!Auth::check()) {return Redirect::to('/');}
        $page_data['studentlist'] = Student::get();
            $page_data['attendence'] = Attendence::get();
            $page_data['courselist'] = Course::get();
            $page_data['student'] = Student::get();
            $page_data['batch_daylist'] = Batchdayslist::get();
            $page_data['batch_list'] = Batch::get();
            $batches = Batch::all();
            $page_data['stud_id'] = $id;
            $page_data['menu'] = 'Students Payments';
        return view('viewPaymentHistory')->with($page_data);
    }
    public function paymenthistory()
    {
      if (!Auth::check()) {return Redirect::to('/');}
      $users = StudentPayment::orderBy('id','desc')->where('stud_id',request('stud_id'));
    
      return datatables()->eloquent($users)
      ->addIndexColumn()
     
    
      ->rawColumns(['date','fee_type'])
      ->make(true);
    }
}