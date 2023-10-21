<?php

namespace App\Http\Controllers;

use App\Product;
use App\Student;
use App\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function performersweek(Request $request, $id = '') {
        $endOfWeek = Carbon::now(); // Get the current date and time
        $startOfWeek = Carbon::now()->subDays(7); // Subtract 7 days to get the start date of the week
    
        if ($id !== '') {
            $students = Student::where('id', $id)
                ->where('student_performance', 'Excellent')
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->get();
        } else {
            $students = Student::where('student_performance', 'Excellent')
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->get();
        }
        $courseNames = Course::pluck('course_name', 'id');

        $product=Product::pluck('product_name','id');
        return view('dashboard', ['students' => $students, 'courseNames' => $courseNames,'product' =>$product]);
    }
    // public function beststudent(Request $request, $id = '')
    // {
    //     if ($id !== '') {
    //         $students = Student::where('id', $id)
    //             ->where('progress_track', 'Professional')
    //             ->get();
    //     } else {
    //         $students = Student::where('progress_track', 'Professional')
    //             ->get();
    //     }
    
    //     // Get the course names based on the course_id
    //     $courseNames = Course::pluck('course_name', 'id');
    //  $productnames=Product::pluck('product_name','id');
    //     return view('dashboard', ['students' => $students, 'courseNames' => $courseNames,'productnames' =>$productnames]);
    // }
    // public function badstudent(Request $request, $id = '')
    // {
    //     if ($id !== '') {
    //         $students = Student::where('id', $id)
    //             ->where('student_performance', 'Bad')
    //             ->get();
    //     } else {
    //         $students = Student::where('student_performance', 'Bad')
    //             ->get();
    //     }
    //     $courseNames = Course::pluck('course_name', 'id');
    //     return view('dashboard', ['students' => $students, 'courseNames' => $courseNames]);
    // }
    // public function stockproduct(Request $request, $id = '')
    // {
    //     if ($id !== '') {
    //         $students = Student::where('id', $id)
    //             ->where('product_purchased', $request->product_purchased)
    //             ->get();
    //     } else {
    //         $students = Student::where('product_purchased', $request->product_purchased)
    //             ->get();
    //     }
    
    //     $courseNames = Course::pluck('course_name', 'id');
    //     $productNames = Product::pluck('product_name', 'id');
    //     $productSelling = Product::pluck('product_selling_price', 'id');
    
    //     return view('dashboard', compact('students', 'courseNames', 'productNames', 'productSelling'));
    // }
    public function calculateDueDate(Request $request)
    {
        $currentDate = Carbon::now(); // Get the current date
        $dueDate = null;

        // Calculate the first due date (before 10 days from the beginning of the month)
        $firstDueDate = $currentDate->startOfMonth()->subDays(10);

        if ($currentDate->day <= 15) {
            // If the current date is on or before 15th, use the first due date
            $dueDate = $firstDueDate;
        } elseif ($currentDate->day > 15 && $currentDate->day <= 20) {
            // If the current date is after 15th and on or before 20th, use the second due date (10 days after the first due date)
            $dueDate = $firstDueDate->copy()->addDays(10);
        } else {
            // If the current date is after 20th, use the next month's first due date (before 10 days from the beginning of the next month)
            $dueDate = $currentDate->startOfMonth()->addMonth()->subDays(10);
        }

        return view('due_date', compact('dueDate'));
    }
    
    }
    
