@extends('index')
@section('content')
<div class="main-content">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Create Batch</h4>
                </div>
                <div class="card-body">
                    <form action="javascript:;" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Day</label>
                                <select class="form-control" name="batch_day" id="batch_day" required> 
                                    <option value="">Choose...</option>
                                    @foreach($batch_daylist as $ba)
                                    <?php
                                        $select = '';
                                        if (isset($batch->batch_day)) {
                                            if ($batch->batch_day == $ba->id) {
                                                $select = 'selected';
                                            }
                                        }
                                    ?>
                                    <option value="{{$ba->id}}" {{$select}}>{{$ba->week_days}}</option>
                                    @endforeach
                                </select>
                        </div>   
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Occupied Student</label>
                            <input type="text" class="form-control" value="{{ $batch->occupy_students ?? '' }}" name="occupy_students" id="occupy_students">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>From Time</label>
                            <input type="time" class="form-control" value="{{ $batch->from_time ?? '' }}" name="from_time" id="from_time">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>To Time</label>
                            <input type="time" class="form-control" value="{{ $batch->to_time ?? '' }}" name="to_time" id="to_time">
                        </div>
                        <button onclick="checkBatch()">Submit</button>
                        <button class="btn btn-white mr-1" onclick="window.location='{{ URL::previous() }}'">Cancel</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    
<script>
    function checkBatch() {
        var batchDaySelect = document.getElementById("batch_day").value;
        var fromTimeInput = document.getElementById("from_time").value;
        var toTimeInput = document.getElementById("to_time").value;
        var occupy_students = document.getElementById("occupy_students").value;
        $.ajax({
            url: "{{route('check_batch')}}",
            method: 'POST',
            data: {
                 _token: "{{ csrf_token() }}",
                 'batchDaySelect': batchDaySelect,
                 'fromTimeInput':fromTimeInput,
                 'toTimeInput':toTimeInput,
                 'occupy_students':occupy_students
                },
            success: function (response) {
              if (response == 'success') {
               alert("Duplicate Entry Found");
              } else{
                alert("Added successfully!");
                window.location.href = "{{ route('dayschedule') }}";
              }
            }
          });
        }
</script>

@endsection
