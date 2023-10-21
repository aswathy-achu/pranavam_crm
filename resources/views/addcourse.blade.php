@extends('index')
@section('content')
<?php
use App\Batch;
use App\Batchdayslist;
?>
<div class="main-content">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Create Course</h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('/manage_course') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $course->id ?? '' }}">
                        <div class="row">
                        </div>    
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>course Name</label>
                            <input type="text" class="form-control" value="{{ $course->course_name ?? '' }}" name="course_name">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Fee</label>
                            <input type="text" class="form-control" value="{{ $course->course_fee ?? '' }}" name="course_fee">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                                <label>Batch Day</label>
                                <select class="form-control" type="time" name="batch" id="batch-day-dropdown" onchange="fetchBatchTimes(this.value)">
                                <option value="">--select--</option>
                                @if(isset($course->batch_id))
                                    <?php
                                $batchId = $course->batch_id;
                                $batch = Batch::find($batchId);
                                $days = '';
                                
                                if ($batch) {
                                    $batchDay = $batch->batch_day;
                                    $batchDaysList = Batchdayslist::find($batchDay);
                                    if ($batchDaysList) {
                                        $days = $batchDaysList->week_days;
                                    }
                                }
                                ?>
                                <option value="{{ $course->batch_id }}" data-max-occupancy="{{ $course->total_no_student }}" data-occupied-students="{{ $course->occupy_students }}" selected>
                                    {{ $days }}
                                </option>
                                @else
                                    @foreach($batch_daylist as $batch)
                                        <option value="{{ $batch->id }}" data-max-occupancy="{{ $batch->total_no_student }}" data-occupied-students="{{ $batch->occupy_students }}">{{ $batch->week_days }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>From Time - To Time</label>
                            <select class="form-control" name="from_time" id="from-time-dropdown" onchange="updateBatchId(this.value)" {{ isset($student->batch_id) ? '' : 'disabled' }}>
                                <option value="">--select--</option>
                                @if(isset($course->batch_id))
                                    <?php
                                    $batch = Batch::find($course->batch_id);
                                    ?>
                                    <option value="{{ $batch->from_time }} - {{ $batch->to_time }}" data-batch-id="{{ $batch->id }}" selected>
                                        {{ $batch->from_time }} - {{ $batch->to_time }}
                                    </option>
                                @endif
                            </select>
                        <input type="hidden" name="batch_id" id="batch_id" value="{{ isset($course->batch_id) ? $course->batch_id : '' }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                          <label>Duration</label>
                          <select class="form-control" value="{{ $course->duration ?? '' }}" name="duration">
                            <option>6 month</option>
                            <option>1 year</option>
                            <option>2 year</option>
                          </select>
                        </div>
                    <div class="form-group col-5 col-md-5 col-lg-5">
                    <label>Staff</label>
                    <select class="form-control" name="faculty" id="faculty-dropdown">
                        <option value="">--select--</option>
                        @foreach($stafflist as $staff)
                            <option value="{{ $staff->id }}" {{ isset($course) && $course->faculty == $staff->id ? 'selected' : '' }}>
                                {{ $staff->fname }} {{ $staff->lname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Description</label>
                            <input type="text" class="form-control" value="{{ $course->description ?? '' }}" name="description">
                        </div>
                        <div class="row">
                        <div class="form-group col-5 col-md-5 col-lg-5 ">
                                <label>File</label>
                                @if(isset($course->course_file))
                                <input type="file" accept="image/jpeg,image/jpg,image/png" name="course_file" id="profile-picture" class="dropify"  data-min-width="150px" data-height="200px" data-default-file="{{ asset('storage/app/course_file/'.$course->course_file) }}">
                                @else
                                <input type="file" accept="image/jpeg,image/jpg,image/png" name="course_file" id="profile-picture" class="dropify"  data-min-width="150px" data-height="200px">
                                @endif    
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit">Submit</button>
                            <button class="btn btn-white mr-1" onclick="window.location='{{ URL::previous() }}'">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('contentjs')
<script type="text/javascript">
    
$(document).ready(function() {
    // Attach event listener to the batch dropdown
    $('#batch-dropdown').change(function() {
        var selectedDay = $(this).val();
        fetchBatchTimes(selectedDay);
    });
});
function fetchBatchTimes(selectedDay) {
    if (selectedDay) {
        $.ajax({
            url: "{{route('getBatchTimes')}}",
            method: 'GET',
            data: {
                'selectedDay': selectedDay
            },
            success: function (data) {
                console.log(data); // Display the data in the console
                
                var fromTimeDropdown = $('#from-time-dropdown');
                fromTimeDropdown.empty();
                fromTimeDropdown.append($('<option></option>').text('--select--').val(''));
                $.each(data, function (key, value) {
                    console.log('key',key,'value',value);
                  
                    var optionText = value.from_time + ' - ' + value.to_time;
                    var optionValue = value.id;
                   
                    let option = $('<option></option>')
                    option.text(optionText).val(optionValue);
                    // if (value['occupy_students'] == value['total_no_of_student']) {

                    //     option.prop('disabled', true);
                    // }
                    fromTimeDropdown.append(option);
                    // fromTim`eDropdown.append($('<option></option>').text(optionText));
                    
                    console.log("Option Value: " + optionValue); 
                });
                
                fromTimeDropdown.prop('disabled', false);
            }
        });
    } else {
        $('#from-time-dropdown').empty();
        fromTimeDropdown.prop('disabled', true);
    }
}
function updateBatchId(batch_id) {
    // alert(dropdown);
  document.getElementById("batch_id").value = batch_id;
}

$('.dropify').dropify();
   
</script>
@endsection



