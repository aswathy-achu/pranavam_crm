@extends('index')
@section('content')
<div class="main-content">
  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="card">
              <div class="card-header">
                <h3>Attendence</h3>
              </div>
              <div class="card-body">
                <div class="row">
                <form action="{{ route('attendencestudentstatus') }}" method="POST" id="myForm"></div>
                @csrf
               
                <div class="form-group col-5 col-md-5 col-lg-5">
                        <label>Batch Day</label>
                        <select class="form-control" type="time" name="batch_id" id="batch-day-dropdown" onchange="fetchBatchTimes(this.value)">
                        <option value="">--select--</option>
                                @foreach($batch_daylist as $batch)
                                    <option value="{{ $batch->id }}">{{ $batch->week_days }}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="form-group col-5 col-md-5 col-lg-5">
                        <label>From Time - To Time</label>
                        <select class="form-control" name="from_time" id="from-time-dropdown" onchange="updateBatchId(this.value)" {{ isset($student->batch_id) ? '' : 'disabled' }}>
                            <option value="">--select--</option>
                                <option value="{{ $batch->from_time }} - {{ $batch->to_time }}" data-batch-id="{{ $batch->id }}" selected>
                                    {{ $batch->from_time }} - {{ $batch->to_time }}
                                </option>
                        </select>
                        <input type="hidden" name="batch_id" id="batch_id" value="{{ isset($student->batch_id) ? $student->batch_id : '' }}">
                    </div>
                    <div class="form-group col-5 col-md-5 col-lg-5">
                    <label>Course</label>
                    <select class="form-control" name="course_id" id="course-dropdown" onchange="updatecourseid(this.value)">
                        <option value="">--select--</option>
                        @foreach($course as $singleCourse)
                            <option value="{{ $singleCourse->id }}" data-batch-id="{{ $singleCourse->batch_id }}">
                                {{ $singleCourse->course_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary mr-1" onclick="submitForm()" type="button">Submit</button>
            <button class="btn btn-white mr-1" onclick="window.location='{{ URL::previous() }}'">Cancel</button>
        </div>
        </div>
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
    $('#from-time-dropdown').change(function() {
        var selectedBatchId = $(this).val();
        updateBatchId(selectedBatchId);

        // Now that the batch is selected, enable the Course dropdown
        $('#course-dropdown').prop('disabled', false);
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
  fetchCourseInfo(batch_id);
}
function updatecourseid(course_id) {
        alert(course_id);
        document.getElementById("course_id").value = course_id;
    }

    function fetchCourseInfo(batch_id) {
        if (batch_id) {
            $.ajax({
                url: "{{ route('getCourseData') }}",
                method: 'GET',
                data: {
                    'batch_id': batch_id
                },
                success: function (data) {
                    console.log(data); 

                    var courseDropdown = $('#course-dropdown');
                    courseDropdown.empty();
                    courseDropdown.append($('<option></option>').text('--select--').val(''));
                    $.each(data, function (key, value) {
                        console.log('key',key,'value',value);

                        var optionText = value.course_name;
                        var optionValue = value.id;

                        let option = $('<option></option>');
                        option.text(optionText).val(optionValue);

                        courseDropdown.append(option);

                        console.log("Option Value: " + optionValue); 
                    });

                    courseDropdown.prop('disabled', false);
                }
            });
        } else {
            $('#course-dropdown').empty();
            courseDropdown.prop('disabled', true);
        }
    }
    function submitForm(batch_id) {
        // Your form submission code here

        // Send AJAX request to fetch student name
        alert('ddd');
        document.getElementById("myForm").submit();
    }
    
$('.dropify').dropify();
   
</script>
@endsection


