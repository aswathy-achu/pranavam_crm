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
                    <h3>Create Student</h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('/manage_student') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $student->id ?? '' }}">
                            <div class="row">
                                <div class="form-group">
                                    <label>File</label>
                                    @if(isset($student->profile_image))
                                    <input type="file" accept="image/jpeg,image/jpg,image/png" name="profile_image" id="profile-picture" class="dropify"  data-min-width="150px" data-height="200px" data-default-file="{{ asset('storage/app/student_photo/'.$student->profile_image) }}">
                                    @else
                                    <input type="file" accept="image/jpeg,image/jpg,image/png" name="profile_image" id="profile-picture" class="dropify"  data-min-width="150px" data-height="200px">
                                    @endif    
                                </div>
                            </div> 
                            <div class="form-group col-5 col-md-5 col-lg-5">
                                <label>Adm No</label>
                                <input type="text" class="form-control" value="{{ $student->adm_no ?? '' }}" name="adm_no" readonly>
                            </div>
                           
                            <div class="form-group col-5 col-md-5 col-lg-5">
                                <label>Name</label>
                                <input type="text" class="form-control" value="{{ $student->name ?? '' }}" name="fname">
                            </div>
                          
                            <div class="form-group col-5 col-md-5 col-lg-5">
                                <label>Age</label>
                                <input type="text" class="form-control" value="{{ $student->age ?? '' }}" name="age">
                            </div>
                            <div class="form-group col-5 col-md-5 col-lg-5">
                            <?php
                            if (isset($student->gender)) {
                                $val = $student->gender;
                            } else {
                                $val = '';
                            }
                            ?>
                            <label>Gender</label>
                            <select class="form-control" name="gender"> 
                                <option {{ isset($student->gender) && $student->gender == 'Select' ? 'selected' : '' }}>Select</option>
                                <option {{ isset($student->gender) && $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option {{ isset($student->gender) && $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            </div>
                            <div class="form-group col-5 col-md-5 col-lg-5">
                                <label>Date of Birth</label>
                                <?php 
                                    if (isset($student->date_of_birth)) {
                                        $val = date('Y-m-d',$student->date_of_birth);
                                    } else {
                                        $val = date('Y-m-d');
                                    }
                                ?>
                                <input type="date" class="form-control" name="dob" value="{{$val}}">
                            </div>
                            
                           
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Date of Join</label>
                            <?php 
                                if (isset($student->date_of_join)) {
                                    $join = date('Y-m-d',$student->date_of_join);
                                } else {
                                    $join = date('Y-m-d');
                                }
                                ?>
                            <input type="date" class="form-control" name="doj" value="{{$join}}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Fees</label>
                            <input type="text" class="form-control" name="fees" value="{{ $student->fees ?? '' }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Phone</label>
                            <input type="tel" class="form-control" name="phone" value="{{ $student->phone ?? '' }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>email</label>
                            <input type="email" class="form-control" name="email" value="{{ $student->email ?? '' }}">
                        </div>
                        <div class="form-group col-md-3 align-self-center text-center fontawesome-icons-list">
                        
                        <div class="list_veh"></div>
                        <hr>
                        <button type="button" data-toggle="modal" onclick="batchmodel()" data-target="#newmodel" class="btn btn-info btn-sm btn-block">Add Batch and Course <i class="fa fa-plus"></i></button>
                  
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
</div>
<div class="main-content">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
           
            
                    <div class="card">
                    <div class="card-header">
                    <h3>Batch and Course List</h3>
                </div>
            <div class="card-body">
                <div class="table-responsive col-12 col-md-12 col-lg-12">
                    <table id="data-table" class="table table-hover align-middle mb-0 dataTable">
                        <thead>
                        <tr>
                          <th>SL No</th>
                          <th>Batch Day</th>
                          <th>From Time to To Time</th>
                          <th>Course</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tr>
                            <td>1</td>
                            <td>Sunday</td>
                            <td>12.00 PM to 13.00PM</td>
                            <td>Piano</td>
                            <td><a href="javascript:void(0)" data-toggle="modal" data-target="#delete_modal" title="Delete"><i class="fas fa-trash"></i></a>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('contentjs')
<script type="text/javascript">
    $(document).ready(function() {
        // Attach event listener to the batch day dropdown
        $('#batch-dropdown').change(function() {
            var selectedDay = $(this).val();
            // alert("dd");
            fetchBatchTimes(selectedDay);
            console.log("sss",selectedDay);
        });

        $('#from-time-dropdown').change(function() {
            var selectedBatchId = $(this).val();
            updateBatchId(selectedBatchId);
            console.log("sqq",selectedBatchId);
        });
    });

    function fetchBatchTimes(selectedDay) {
        if (selectedDay) {
            $.ajax({
                url: "{{ route('getBatchTimes') }}", // Replace with your actual route
                method: 'GET',
                data: {
                    'selectedDay': selectedDay
                },
                success: function(data) {
                    console.log("aa",data);
                    var fromTimeDropdown = $('#from-time-dropdown');
                    console.log("ssssss",fromTimeDropdown);
                    fromTimeDropdown.empty();
                    fromTimeDropdown.append($('<option></option>').text('--select--').val(''));
                    $.each(data, function(key, value) {
                        var optionText = value.from_time + ' - ' + value.to_time;
                        var optionValue = value.id;
                        let option = $('<option></option>');
                        option.text(optionText).val(optionValue);
                        if (value.occupy_students == value.total_no_of_student) {
                            option.prop('disabled', true);
                        }
                        fromTimeDropdown.append(option);
                    });
                    fromTimeDropdown.prop('disabled', false);
                }
            });
        } else {
            $('#from-time-dropdown').empty();
            $('#from-time-dropdown').prop('disabled', true);
        }
    }

    function updateBatchId(batch_id) {
        document.getElementById("batch_id").value = batch_id;
        fetchCourseInfo(batch_id);
        console.log(batch_id);
    }

    function fetchCourseInfo(batch_id) {
        if (batch_id) {
            $.ajax({
                url: "{{ route('getCourseData') }}", // Replace with your actual route
                method: 'GET',
                data: {
                    'batch_id': batch_id
                },
                success: function(data) {
                    var courseDropdown = $('#course-dropdown');
                    courseDropdown.empty();
                    courseDropdown.append($('<option></option>').text('--select--').val(''));
                    $.each(data, function(key, value) {
                        var optionText = value.course_name;
                        var optionValue = value.id;
                        let option = $('<option></option>');
                        option.text(optionText).val(optionValue);
                        courseDropdown.append(option);
                    });
                    courseDropdown.prop('disabled', false);
                }
            });
        } else {
            $('#course-dropdown').empty();
            $('#course-dropdown').prop('disabled', true);
        }
    }

    function batchmodel(batch_id) {
    if (batch_id) {
        $.ajax({
            url: "",
            method: 'GET',
            data: {
                'batch_id': batch_id
            },
            success: function(data) {
                $(".modal-body").html(data);
                $("#newmodel").modal("show");
            },
            error: function() {
                alert("Failed to fetch data from the server.");
            }
        });
    }
}


    $('.dropify').dropify();
</script>

@endsection
 <!-- @section('contentjs')
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
                    if (value['occupy_students'] == value['total_no_of_student']) {

                        option.prop('disabled', true);
                    }
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

function updateBatchId(batch_id) {
    // alert(dropdown);
  document.getElementById("batch_id").value = batch_id;
}

$('.dropify').dropify();
   
</script>
@endsection -->

