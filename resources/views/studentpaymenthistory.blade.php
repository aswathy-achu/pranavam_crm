@extends('index')
@section('content')
<div class="main-content">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" autocomplete="off" action="javascript:;" method="post" id="form_id">
                    @csrf
                    <!-- batch -->
                    <div class="form-group">
                        <label>Batch Day</label>
                        <select class="form-control" name="batch_day" id="batch-day-dropdown">
                            <option value="">--select--</option>
                            @foreach($batch_daylist as $batch)
                                <option value="{{ $batch->id }}">{{ $batch->week_days }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Time -->
                    <div class="form-group">
                        <label>From Time - To Time</label>
                        <select class="form-control" name="from_time" id="from-time-dropdown" disabled>
                            <option value="">--select--</option>
                        </select>
                    </div>
                    <!-- Course -->
                    <div class="form-group">
                        <label>Course</label>
                        <select class="form-control" name="course" id="course-dropdown" disabled>
                            <option value="">--select--</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary icon-left btn-icon">
                        <i class="fas fa-search"></i>Search Student
                    </button>
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
                          <th>Name</th>
                          <th>Joined At</th>
                          <th>Batch</th>
                          <th>Course</th>
                          
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
                url: "{{ route('get-paymenthistory') }}",
                data: function(searchingData){
                    searchingData.batch_id = $('#from-time-dropdown').val();
                    searchingData.from_time = $('#from-time-dropdown').val();
                    searchingData.course_id = $('#course-dropdown').val();
                   
                },
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    orderable: false, 
                    searchable: false
                },
                {data: 'name', name: 'name'},
                {data: 'date_of_join', name: 'date_of_join'},
                {data: 'batch_id', name: 'batch_id'},
                {data: 'course_id', name:'course_id'},
               
                {data: 'action', name: 'action'},

            ],
            
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