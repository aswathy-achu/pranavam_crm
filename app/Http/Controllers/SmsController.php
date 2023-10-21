<?php

namespace App\Http\Controllers;

use App\Example;
use App\Terms_and_condition;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Twilio\Rest\Client;

class SmsController extends Controller
{

    // public function send_sms()
    // {
    //     $receiverNumber = "RECEIVER_NUMBER";
    //     $message = "This is testing from CodeSolutionStuff.com";
  
    //     try {
  
    //         $account_sid = getenv("TWILIO_SID");
    //         $auth_token = getenv("TWILIO_TOKEN");
    //         $twilio_number = getenv("TWILIO_PHONE");
  
    //         $client = new Client($account_sid, $auth_token);
    //         $client->messages->create($receiverNumber, [
    //             'from' => $twilio_number, 
    //             'body' => $message]);
  
    //         dd('SMS Sent Successfully.');
  
    //     } catch (Exception $e) {
    //         dd("Error: ". $e->getMessage());
    //     }
    // }
    
    public function example(){
        return view ("example");
    }
//     public function manage_example(Request $request, $id = '')
// {
//     if (!Auth::check()) {
//         return redirect('/');
//     }
    
   
//     if ($request->isMethod('post')) {
//         if ($request->input('id') == '') {
//             $student = new Example();
//         } else {
//             $student = Example::find($request->input('id'));
//         }
        
      
//         // Store student details

//         $student->name = $request->input('fname');
//         $student->phone = $request->input('phone');
//         $student->save();
    
//         if ($request->input('id')) {
//             return redirect('/studentlist')->with('success', 'Update successful!');
//         } else {
//             // Increment student count in the associated batc
            
//             return redirect('/studentlist')->with('success', 'Add successful!');
//         }
//     }
   
    
//     return view('createstudent');
// }
public function manage_example(Request $request, $id = '')
{
    // info("Sdddsd");
    if (!Auth::check()) {
        return redirect('/');
    }
    // echo $request->phone;
    try {
        $account_sid = env('TWILIO_SID');
        $account_token = env('TWILIO_TOKEN');
        $number = env('TWILIO_FROM');
        info($number);
        $client = new Client($account_sid,$account_token);
        $client->messages->create('+91'.$request->phone,[
            'from' => $number,
            'body' => $request->message
        ]);
        return "message sent ......";
    } catch (\Throwable $e) {
        return $e->getMessage();
    }
    
    // if ($request->isMethod('post')) {
    //     if ($request->input('id') == '') {
    //         $student = new Example();
    //     } else {
    //         $student = Example::find($request->input('id'));
    //     }
        
    //     // Store student details
    //     $student->name = $request->input('fname');
    //     $student->phone = $request->input('phone');
    //     $student->save();
    
    //     if ($request->input('id')) {
    //         return redirect('/studentlist')->with('success', 'Update successful!');
    //     } else {
    //         // Increment student count in the associated batch

    //         // Send SMS using Twilio
          
    //         $account_sid = env('TWILIO_SID');
    //         $auth_token = env('TWILIO_AUTH_TOKEN');
    //         $twilio_number = env('TWILIO_PHONE_NUMBER');
            
    //             $receiverNumber = $request->input('phone');
    //             $message = 'Welcome to our application!'; // Customize the message as needed

    //             $client = new Client($account_sid, $auth_token);
    //             $client->messages->create($receiverNumber, [
    //                 'from' => $twilio_number,
    //                 'body' => $message,
    //             ]);

    //             return redirect('/example')->with('success', 'Add successful! SMS Sent Successfully.');

            
               
    //     }
    // }
    
    // return view('example');
}
public function terms(Request $r){
    if ($_POST) {
        $conn = new Terms_and_condition;
        $conn->terms_and_condition = $r->post('terms_and_condition');
        $conn->language= $r->post('language');
        $conn->save();
        return Redirect::back()->with('success','Save successfully!');
    }
    return view('language');
}

// $page_data['terms_and_condition'] = Terms_and_condition::get();
// $page_data['title'] = 'Terms and Condition';
// return view('admin/terms_and_condition')->with($page_data);
}
