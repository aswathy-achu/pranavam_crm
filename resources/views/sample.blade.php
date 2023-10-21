@extends('index_panel')
@section('content')
<div class="row column1">
    <div class="white_shd full margin_bottom_30">
        <div class="full price_table padding_infor_info">
            <form action="{{route('manage_driver_leave')}}" method="POST" enctype="multipart/form-data">
            @csrf
                <input type="hidden" name="id" value="{{$leave->id ?? ''}}">
                <div class="form-row justify-content-md-center">
                    <div class="form-group col-md-3">
                        <label for="districts">Driver Name <span class="text-danger">*</span></label>
                        <select class="form-control" name="driver_name" required>
                           <option value="">--select--</option>
                            @foreach($driverlist as $driver)
                                <option value="{{ $driver->id }}" {{ isset($leave) && $leave->driver_name == $driver1->id ? 'selected' : '' }}>
                                    {{ $driver->f_name }} 
                                </option>
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="fromdateandtime">From Date and Time<span class="text-danger">*</span></label>
                            <input type="datetime-local" id="from_date_time" name="from_date_time">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="todateandtime">To Date and Time<span class="text-danger">*</span></label>
                            <input type="datetime-local" id="to_date_time" name="to_date_time">
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection