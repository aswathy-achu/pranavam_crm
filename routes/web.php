<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AD\AdminController;
use App\Http\Controllers\AttendenceController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StaffController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('',[AdminController::class,'login']);
Route::post('/dologin',[AdminController::class, 'dologin']);
Route::get('/role_redirects',[AdminController::class, 'role_redirects']);
Route::group(['middleware'=>'user_auth'],function(){
    Route::any('/dashboard',[AdminController::class,'dashboard'])->name('dashboard');
    Route::any('/badstudents',[AdminController::class,'badstudents'])->name('badstudents');
    Route::any('/staff/dashboard',[AdminController::class,'staffdashboard'])->name('dashboard');

    Route::any('/get_fee',[AdminController::class,'get_fee'])->name('get-fee');
    Route::any('/downloadpdf/{invoice}',[AdminController::class,'downloadpdf'])->name('download.invoice.pdf');
    // Route::get('', '@downloadpdf')->name('');


    Route::get('/logout',[AdminController::class, 'logout'])->name('logout');
    
    Route::any('/studentlist',[StudentController::class, 'studentlist'])->name('studentlist');
    Route::any('/createstudent',[StudentController::class, 'createstudent'])->name('createstudent');
    // Route::any('/manage_student',[StudentController::class, 'manage_student'])->name('manage-student');
    Route::any('/studentdetails{id?}',[StudentController::class, 'studentdetails'])->name('studentdetails');
    Route::any('/manage_student/{id?}', [StudentController::class, 'manage_student'])->name('manage_student');
    Route::any('/get_student', [StudentController::class, 'get_student'])->name('get-student');
    Route::any('/profilemodal/{id?}','StudentController@profile')->name('profile');
    Route::get('/del_student/{id}','StudentController@del_student')->name('del_student');
    Route::get('/getBatchTimes','StudentController@getBatchTimes')->name('getBatchTimes');
    Route::get('/getseatlimit','StudentController@getseatlimit')->name('getseatlimit');
    Route::any('/manage_batch_check','StudentController@manage_batch_check')->name('manage_batch_check');

    // Route::get('/getseatlimit','StudentController@getseatlimit')->name('getseatlimit');

    // Route::any('/getBatchTimes/{day}', 'BatchController@getBatchTimes');
    
    // Route::any('/student_edit/{id?}', [StudentController::class, 'student_edit'])->name('student_edit');
    
    //attendance
    Route::any('/attendancebatch',[AdminController::class, 'attendancebatch'])->name('attendancebatch');
    Route::any('/attendancecourse',[AdminController::class, 'attendancecourse'])->name('attendancecourse');
    Route::any('/attendacestudent',[AdminController::class, 'attendacestudent'])->name('attendacestudent');
    Route::any('/attendenceday',[AttendenceController::class, 'attendenceday'])->name('attendenceday');
    // Route::any('/attendencestudentbatch',[AttendenceController::class, 'attendencestudentbatch'])->name('attendencestudentbatch');
    Route::any('/getCourseData',[AttendenceController::class, 'getCourseData'])->name('getCourseData');
    // Route::any('/studentattendence','AttendenceController@studentattendence')->name('attendencestudentlist');
    Route::any('/get-student', [AttendenceController::class, 'getStudentName'])->name('attendencestudentlist');
    Route::any('/attendencestudentstatus', [AttendenceController::class, 'attendencestudentstatus'])->name('attendencestudentstatus'); 
    Route::any('/attendencestatus',[AttendenceController::class, 'attendencestatus'])->name('attendencestatus');
    Route::get('/attendencelist',[AttendenceController::class, 'admin_panel_att_listing'])->name('admin.panel.att.listing');
    Route::any('/get_Attendence', [AttendenceController::class, 'get_Attendence'])->name('get_Attendence');
    Route::get('/get-attendance-status/{studentId}/{date}', 'AttendanceController@getAttendanceStatus');
    Route::any('/update-attendance', 'AttendenceController@updateattendencestatus')->name('updateattendencestatus');
    // Route::get('/attendance/{year}/{month}', [AttendanceController::class, 'showAttendanceList'])->name('attendance.list');
    //fees
    Route::any('/courselist',[CourseController::class, 'courselist'])->name('courselist');
    Route::any('/addcourse',[CourseController::class, 'addcourse'])->name('addcourse');
    Route::any('/manage_course/{id?}', [CourseController::class, 'manage_course'])->name('manage_course');
    // Route::any('/course_manage/{id?}', [CourseController::class, 'course_manage'])->name('course_manage');
    Route::any('/del_course/{id}',"CourseController@del_course")->name('del_course');
    Route::any('/courseview/{id?}',[CourseController::class, 'courseview'])->name('courseview');

    //product
    Route::any('/productview/{id?}',[ProductController::class, 'productview'])->name('productview');

    Route::any('/productlist',[ProductController::class, 'productlist'])->name('productlist');
    Route::any('/createproduct',[ProductController::class, 'createproduct'])->name('createproduct');
    Route::any('/product_update/{id?}', [ProductController::class, 'product_update'])->name('product_update');
    // Route::any('/product_manage/{id?}', [ProductController::class, 'product_manage'])->name('product_manage');
    
    Route::any('/del_product/{id}',"ProductController@del_product")->name('del_product');
    Route::any('/sample',[ProductController::class, 'sample'])->name('sample');
    Route::any('/productModal/{id?}','ProductController@productModal')->name('productModal');
    // Route::any('//{id?}','StudentController@profile')->name('profile');

    //billing
    Route::any('/billinglist',[InvoiceController::class, 'billinglist'])->name('billinglist');
    Route::any('/createbill',[InvoiceController::class, 'createbill'])->name('createbill');
    // Route::any('/stockproduct',[AdminController::class, 'stockproduct'])->name('stockproduct');
    Route::any('/adminprofile',[AdminController::class, 'adminprofile'])->name('adminprofile');
    Route::any('/manage_admin/{id?}',[AdminController::class, 'manage_admin'])->name('manage_admin');
    Route::any('/adminprofileview/{id?}',[AdminController::class, 'viewadminprofile'])->name('adminprofileview');
    Route::any('/showStudent/{id?}',[AdminController::class, 'showStudent'])->name('showStudent');
    Route::any('/createadmin',[AdminController::class, 'createadmin'])->name('createadmin');

    Route::any('/dayschedule',[BatchController::class, 'dayschedule'])->name('dayschedule');
    Route::any('/weekendschedule',[BatchController::class, 'weekendschedule'])->name('weekendschedule');
    Route::any('/timeschedule/{id?}',[BatchController::class, 'timeschedule'])->name('timeschedule');
    Route::any('/createbatch',[BatchController::class, 'createbatch'])->name('createbatch');
    Route::any('/manage_batch/{id?}', [BatchController::class, 'manage_batch'])->name('manage_batch');
    Route::any('/get_timeschedule/{id?}', [BatchController::class, 'get_timeschedule'])->name('get-timeschedule');
    Route::any('/check_batch/{id?}', [BatchController::class, 'check_batch'])->name('check_batch');
    Route::post('/getTimes', 'BatchController@getTimes');
    Route::any('/dayModal/{id?}','BatchController@dayModal')->name('dayModal');
    Route::get('/del_batch/{id}','BatchController@del_batch')->name('del_batch');
    
    Route::get('/sms_send',[SmsController::class, 'sms_send']);
    Route::get('/example','SmsController@example')->name('example');
    Route::any('/manage_example/{id?}', [SmsController::class, 'manage_example'])->name('manage_example');
    Route::any('/terms', [SmsController::class, 'terms'])->name('terms');

    // Route::any('/staff/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
    Route::any('/staffreg', [StaffController::class, 'staffreg'])->name('staffreg');
    Route::any('/manage_staff/{id?}', [StaffController::class, 'manage_staff'])->name('manage_staff');
    Route::any('/get_staff', [StaffController::class, 'get_staff'])->name('get_staff');
    Route::any('/stafflist',[StaffController::class, 'stafflist'])->name('stafflist');
    Route::get('/del_staff/{id}','StaffController@del_staff')->name('del_staff');
    Route::any('/staffprofile/{id}','StaffController@staffprofile')->name('staffprofile');
    Route::any('/editstaffprofile',[StaffController::class, 'editstaffprofile'])->name('editstaffprofile');
    Route::any('/edit_manage_staff',[StaffController::class, 'edit_manage_staff'])->name('edit_manage_staff');
    Route::any('/manage_reset_user_password/{id?}','StaffController@manage_reset_user_password')->name('manage_reset_user_password');
    Route::any('/viewstaffprofileadmin/{id?}','StaffController@viewstaffprofileadmin')->name('viewstaffprofileadmin');



    Route::any('/staffpermissionlist/{id?}',[StaffController::class, 'staffpermissionlist'])->name('staffpermissionlist');
    Route::any('/managestaffpermissionmodal',[StaffController::class, 'managestaffpermissionmodal'])->name('managestaffpermissionmodal');
    Route::any('/managestaffpermission',[StaffController::class, 'managestaffpermission'])->name('managestaffpermission');
    Route::any('/get_staff_permission', 'StaffController@get_staff_permission')->name('get-staff-permission');
    // Route::any('/permissionlist', 'AdminController@permissionlist')->name('permissionlist');
    Route::any('/permissionlist',[StaffController::class, 'permissionlist'])->name('permissionlist');
    Route::any('/manage_permission/{id?}',[StaffController::class, 'manage_permission'])->name('manage_permission');
   
    Route::any('/addinvoice',[InvoiceController::class, 'addinvoice'])->name('addinvoice');
    Route::any('/manage_invoice/{id?}', [InvoiceController::class, 'manage_invoice'])->name('manage_invoice');
    Route::any('/getFeeDetails/{studentId}', [InvoiceController::class, 'getFeeDetails'])->name('getFeeDetails');
    Route::any('/getStudentData',[InvoiceController::class, 'getStudentData'])->name('getStudentData');
    Route::any('/getFeeData',[InvoiceController::class, 'getFeeData'])->name('getFeeData');
    Route::any('/billlist',[InvoiceController::class, 'billlist'])->name('billlist');
    Route::any('/get_bill', [InvoiceController::class, 'get_bill'])->name('get-bill');
    Route::any('/getBalanceData', [InvoiceController::class, 'getBalanceData'])->name('getBalanceData');
    Route::get('/view-invoice-pdf/{invoice}',[InvoiceController::class,'viewInvoicePdf'])->name('view.invoice.pdf');
    Route::any('/studentpaymenthistory',[InvoiceController::class,'studentpaymenthistory'])->name('studentpaymenthistory');
    Route::any('/get-paymenthistory',[InvoiceController::class,'get_paymenthistory'])->name('get-paymenthistory');
    Route::any('/viewPaymentHistory/{id?}',[InvoiceController::class, 'viewPaymentHistory'])->name('viewPaymentHistory');
    Route::any('/paymenthistory',"InvoiceController@paymenthistory")->name('paymenthistory');


    Route::any('/performersweek',[DashboardController::class, 'performersweek'])->name('performersweek');
    Route::any('/beststudent',[DashboardController::class, 'beststudent'])->name('beststudent');


});
