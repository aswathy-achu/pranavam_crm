@extends('index')
@section('content')
<div class="main-content">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Student Attendance</h4>
                <form class="forms-sample" autocomplete="off" action="javascript:;" method="get" id="form_id">
                    @csrf
                    <div class="form-group">
                        <label>Batch Day</label>
                        <select class="form-control" name="batch_day" id="batch-day-dropdown">
                            <option value="">--select--</option>
                            @foreach($batch_daylist as $batch)
                                <option value="{{ $batch->id }}">{{ $batch->week_days }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>From Time - To Time</label>
                        <select class="form-control" name="from_time" id="from-time-dropdown" disabled>
                            <option value="">--select--</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Course</label>
                        <select class="form-control" name="course" id="course-dropdown" disabled>
                            <option value="">--select--</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="month" name="month" id="att-month" value="">
                    </div>
                    <button type="submit" class="btn btn-primary icon-left btn-icon"><i class="fas fa-search"></i>Search Attendance</button>                
                    </div>
                 </form>
                <div class="table-responsive">
                    <table class="table table-bordered" id="mytable">
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('contentjs')
<script>
$(document).ready(function () {
  callAjax('THIS');
});
function callAjax(selectedMonth, selectBatch, selectCourse) {
    $.ajax({
        url: "{{ route('admin.panel.att.listing') }}",
        method: 'GET',
        data: {
            'selectedMonth': selectedMonth,
            'selectBatch': selectBatch,
            'selectCourse': selectCourse,
            'ajaxData': 1
        },
        success: function (response) {
            if (response['status'] == 200) {
                // Clear previous data and populate the table
                $("#mytable").empty();
                console.log("lastattendence", response['lastAtt']);
                setTableRow(response['attendance'], response['monthDays'], response['lastAtt'], response['stud']);            }
        }
    });
}
        function setTableRow(attendance, monthDays, lastAtt, stud){
            // console.log(attendance);
            // console.log(monthDays);
            // console.log(lastAtt);
            // console.log("985"+stud);
            // console.log(selectedMonth);
            // console.log(selectBatch);
            // console.log(selectCourse);
            // console.log("***********",lastAtt);
            
          var table = document.getElementById("mytable");
          var row1;
          var tableRowIds =[];

          for (let index = 1; index <= monthDays; index++) {
            row1 += '<td>'+index+'</td>';            
          }
          var tableRows = '<thead><tr><td>student</td>'+row1+'</tr></thead><tbody>';
           stud.forEach(function (student, i) {
            let rNo = i + 1;
            let generatedTd = '<td><span class="att-none">N</span></td>'.repeat(lastAtt);
            console.log("lastatt============",lastAtt);
            tableRows += '<tr id="student-row' + student['id'] + '"><td>' + student['name'] + '</td>' + generatedTd + '</tr>';
            tableRowIds.push("student-row" + student['id']);
        });

          $("#mytable").append(tableRows+'</tbody>');
          
          stud.forEach(student => {
          attendance.forEach(att => {
          if (student['id'] == att['stud_id']) {
            let nthChild = att['day'] + 1;
            let spanData;
            if (att['attendence_mark'] == 1) {
                spanData = '<span class="att-present">P</span>';
            } else {
                spanData = '<span class="att-absent">A</span>';
            }
            $("#student-row" + att['stud_id']).find(':nth-child(' + nthChild + ')').html(spanData);
        }
    });
});


        }
        $("#form_id").on('submit', function (event) {
            event.preventDefault();

            var att_month = $('#att-month').val();
            var from_time_dropdown = $('#from-time-dropdown').val();
            var course_dropdown = $('#course-dropdown').val();
            // console.log("-+-"+att_month);
            // console.log("+++"+from_time_dropdown);
            // console.log("+++"+course_dropdown);
                
            // Assuming you have a dropdown for students
            if(att_month){
              const date = new Date().toJSON().slice(0, 10);
              if(date.includes(att_month)){
                att_month = 'THIS';
              }
            }

            if (att_month && from_time_dropdown && course_dropdown) {
                // Pass all the selected values to the AJAX function
                callAjax(att_month, from_time_dropdown, course_dropdown);
            }
        });
        

    function clearDataTableSearch(){
        document.getElementById("form_id").reset();
        // $('#month-title').text(" \Carbon\Carbon::parse(date('M'))->format('F') ,  now()->year ");
        callAjax('THIS');
    }
     
    $("#batch-day-dropdown").change(function () {
        var selectedDay = $(this).val();
        if (selectedDay) {
            fetchBatchTimes(selectedDay);
        } else {
            // Reset time and course dropdowns
            $('#from-time-dropdown').empty().prop('disabled', true);
            $('#course-dropdown').empty().prop('disabled', true);
        }
    });

    $("#from-time-dropdown").change(function () {
        var selectedBatchId = $(this).val();
        if (selectedBatchId) {
            fetchCourseInfo(selectedBatchId);
        } else {
            // Reset course dropdown
            $('#course-dropdown').empty().prop('disabled', true);
        }
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
        
      </script>
@endsection