<?php
use App\Course;
use App\Product;
use App\Batchdayslist;
use App\Batch;
use App\Invoice;
$productList = Product::all();


$imageUrl = asset('storage/app/student_photo/' . $student->profile_image);

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
$dateOfBirth = isset($student->date_of_birth) ? date('Y-m-d', $student->date_of_birth) : date('Y-m-d');
$dateOfJoin =isset($student->date_of_join) ? date('Y-m-d', $student->date_of_join) : date('Y-m-d');

$course = Course::find($student->course_id);
$courseName = $course ? $course->course_name : '';
?>

<form action="{{ route('profile', ['id' => $student->id]) }}" method="POST">
                @csrf
    <div class="row">
        <div class="card-body">
            <div class="card-title">
                <h5 class="modal-title" id="newmodel">Student View</h5>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <div class="form-row">
                        <label for="exampleInputUsername2" class="col-sm-6 col-form-label">Name</label>
                       <p>{{$student->name}}
                    </div>
                    <div class="form-row">
                        <label for="exampleInputUsername2" class="col-sm-6 col-form-label">Age</label>
                        <p>{{$student->age}}
                    </div>
                    <div class="form-row">
                        <label for="exampleInputUsername2" class="col-sm-6 col-form-label">Gender</label>
                        <p>{{$student->gender}}
                    </div>
                    <div class="form-row">
                        <label for="exampleInputUsername2" class="col-sm-6 col-form-label">Batch</label>
                        <p>{{$days}}
                    </div>
                </div>
               
                <div class="col-sm-4">
                    <div class="text-left">
                        <img src="{{ $imageUrl }}" class="mt-2" width="100px" height="100px">
                    </div>
                    <input type="hidden" name="image" value="{{ $student->profile_image }}">
                </div>
            </div>
            <div class="form-row">
                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Course</label>
                <p>{{$courseName}}</p>
            </div>
            <div class="form-row">
                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Date of Birth</label>
                <p>{{$dateOfBirth}}</p>
            </div>
            <div class="form-row">
                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Date of Join</label>
                <p>{{$dateOfJoin}}</p>
            </div>
            <div class="form-row">
                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Email</label>
                <p>{{$student->email}}
            </div>
            <div class="form-row">
                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Phone</label>
                <p>{{$student->phone}}
            </div>
            <div class="form-row">
                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Product</label>
               <p>{{$productInfo}}</p>
            </div>
            <div class="form-row">
                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Student Performance</label>
                <div class="col-sm-8">
                    
                <select class="form-control" name="student_performance">
                    <option value="Select" {{ $student->student_performance == 'Select' ? 'selected' : '' }}>Select</option>
                    <option value="Excellent" {{ $student->student_performance == 'Excellent' ? 'selected' : '' }}>Excellent</option>
                    <option value="Good" {{ $student->student_performance == 'Good' ? 'selected' : '' }}>Good</option>
                    <option value="Bad" {{ $student->student_performance == 'Bad' ? 'selected' : '' }}>Bad</option>
                </select>

                </div>
            </div>
            <div class="form-row">
                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Progress Track</label>
                <div class="col-sm-8">
                    <select class="form-control" name="progress_track">
                    <option value="Select" {{ $student->progress_track == 'Select' ? 'selected' : '' }}>Select</option>
                    <option value="Beginner" {{ $student->progress_track == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                    <option value="Intermediate" {{ $student->progress_track == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                    <option value="Professional" {{ $student->progress_track == 'Professional' ? 'selected' : '' }}>Professional</option>
                </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>


