@extends('index')
@section('content')
<div class="main-content">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="col-lg-12 grid-margin">
                    <h1>Student List</h1>
                </div>
                <div class="table-responsive col-12 col-md-12 col-lg-12">
                    <table id="data-table" class="table table-hover align-middle mb-0 dataTable ">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>from_time</th>
                                <th>to_time</th>
                                <th>Occupied Students</th>
                                <th>Total Number Student Admission </th>
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
$(document).ready( function () {
    $('.dataTable').dataTable({
       processing: true,
       serverSide: true,
       destroy: true,
       ajax: "{{route('get-timeschedule', ['id' => $batch_dayslist_id])}}",
       columns: [
                {
                    data: 'DT_RowIndex',
                    orderable: false, 
                    searchable: false
                }, 
                {data: 'from_time', name: 'from_time'},
                {data: 'to_time', name: 'to_time'},
                {data: 'occupy_students', name: 'occupy_students'},
                {data: 'total_no_of_student', name:'total_no_of_student'},
                // {data: 'balance_student', name:'balance_student'},
                {data: 'action', name: 'action'},
                ] 
    });
});
</script>
    
@endsection

