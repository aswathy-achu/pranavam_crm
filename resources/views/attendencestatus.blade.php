@extends('index')
@section('content')
<?php
use App\Batch;
use App\Batchdayslist;
?>
<div class="main-content">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" autocomplete="off" action="javascript:;" method="post" id="form_id">
                @csrf
                    <!-- batch -->
                    <div class="form-group">
                        <label>Batch Day</label>
                        <select class="form-control" type="time" name="batch_day" id="batch-day-dropdown" onchange="fetchBatchTimes(this.value)">
                        <option value="">--select--</option>
                                @foreach($batch_daylist as $batch)
                                    <option value="{{ $batch->id }}">{{ $batch->week_days }}</option>
                                @endforeach
                           
                        </select>                    
                    </div>
                    <!-- Time -->
                    <div class="form-group">
                        <label>From Time - To Time</label>
                        <select class="form-control" name="from_time" id="from-time-dropdown" onchange="updateBatchId(this.value)" {{ isset($student->batch_id) ? '' : 'disabled' }}>
                            <option value="">--select--</option>
                            
                                <option value="{{ $batch->from_time }} - {{ $batch->to_time }}" data-batch-id="{{ $batch->id }}" selected>
                                    {{ $batch->from_time }} - {{ $batch->to_time }}
                                </option>
                         
                        </select>
                        <input type="hidden" name="batch_id" id="from-time-dropdown" value="{{ isset($student->batch_id) ? $student->batch_id : '' }}">
                        <!-- </div> -->
                    </div>
                    <!-- Course -->
                    <div class="form-group">
                        <label>Course</label>
                        <select class="form-control" name="course_id" id="course-dropdown" onchange="updatecourseid(this.value)">
                        <option value="">--select--</option>
                        @foreach($courselist as $course)
                            <option value="{{ $course->id }}" data-batch-id="{{ $course->batch_id }}">
                                {{ $course->course_name }}
                            </option>
                        @endforeach
                    </select>
                    </div>
                    <div class="form-group">
                        <label>Attendance Date</label>
                        <input class="form-control" type="date" name="attendance_date" id="attendance-date" value="">
                    </div>
                    <button type="submit" class="btn btn-primary icon-left btn-icon"><i class="fas fa-search"></i>Search Student</button>                
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive col-12 col-md-12 col-lg-12">
                    <table id="data-table" class="table table-hover align-middle mb-0 dataTable">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Date</th>
                                <th>Student Name</th>
                                <th>Present/Absent</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('contentjs')
<script type="text/javascript">
$(document).ready(function () {
    function refreshdatatable(){
        $('.dataTable').dataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "{{ route('get_Attendence') }}",
                data: function(searchingData){
                    searchingData.batch_id = $('#from-time-dropdown').val();
                    searchingData.from_time = $('#from-time-dropdown').val();
                    searchingData.course_id = $('#course-dropdown').val();
                    searchingData.date = $('#attendance-date').val();
                },
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'date', name: 'date' },
                { data: 'name', name: 'name' },
                { data: 'attendence_mark', name: 'attendence_mark' },
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                }

            ],
            createdRow: function (row, data, dataIndex) {
                const attendenceMarkCell = $(row).find('td:eq(3)');
                const attendenceMark = attendenceMarkCell.text().trim();
                if (attendenceMark === 'Present') {
                    attendenceMarkCell.css('color', 'green');
                } else if (attendenceMark === 'Absent') {
                    attendenceMarkCell.css('color', 'red');
                }
            }
        });
    }
   
    $("#form_id").on('submit',function(){
        refreshdatatable();
    //   $('.dataTable').DataTable().draw(true);
    });
    
    function clearDataTableSearch() {
        document.getElementById("form_id").reset();
        $('.dataTable').DataTable().draw(true);
    }
});

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
                
                var fromTimeDropdown = $('#from-time-dropdown');
                fromTimeDropdown.empty();
                fromTimeDropdown.append($('<option></option>').text('--select--').val(''));
                $.each(data, function (key, value) {
                    // console.log('key',key,'value',value);
                  
                    var optionText = value.from_time + ' - ' + value.to_time;
                    var optionValue = value.id;
                   
                    let option = $('<option></option>')
                    option.text(optionText).val(optionValue);
                   
                    fromTimeDropdown.append(option);
                    // fromTim`eDropdown.append($('<option></option>').text(optionText));
                    
                    // console.log("Option Value: " + optionValue); 
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
            // alert(course_id);
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
                    // console.log(data); 

                    var courseDropdown = $('#course-dropdown');
                    courseDropdown.empty();
                    courseDropdown.append($('<option></option>').text('--select--').val(''));
                    $.each(data, function (key, value) {
                        // console.log('key',key,'value',value);

                        var optionText = value.course_name;
                        var optionValue = value.id;

                        let option = $('<option></option>');
                        option.text(optionText).val(optionValue);

                        courseDropdown.append(option);

                        // console.log("Option Value: " + optionValue); 
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
        // alert('ddd');
        document.getElementById("myForm").submit();
    }
    function updateAttendance(stud_id, attendence_mark) {
        // console.log("stud_id: " + stud_id);
        // console.log("attendence_mark: " + attendence_mark);
        $.ajax({
            url: "{{ route('updateattendencestatus') }}",
            method: "GET", 
            data: {
               
                'stud_id': stud_id,
                'attendence_mark': attendence_mark
            },
            success: function (data) {
                // console.log(data); 
                $('.dataTable').DataTable().draw(true);
            }
        });
    }
    $('.dropify').dropify();
    </script>

<script src="{{config('app.assets')}}/js/attendance.js"></script>

@endsection