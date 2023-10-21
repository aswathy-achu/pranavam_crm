@extends('index')
@section('content')
<div class="main-content">
<div class="col-lg-12 grid-margin stretch-card">
    
        <div class="card">
            <div class="card-body">
            <a href="{{route('createstudent')}}" class="btn btn-primary">+ Create New Student</a>

                <div class="col-lg-12 grid-margin">
                    <h1>Student List</h1>
                </div>
                <div class="table-responsive col-12 col-md-12 col-lg-12">
                <table id="data-table" class="table table-hover align-middle mb-0 dataTable ">
                <thead>
                        <tr>
                          <th>SL No</th>
                          <th>Name</th>
                          <th>Joined At</th>
                          <th>Batch</th>
                          <th>Course</th>
                          <th>Product purchased</th>
                          <th>Student Performance</th>
                          <th>progress track</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                </thead>
              </table>
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
       ajax: "{{route('get-student')}}",
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
                {data: 'product_purchased', name:'product_purchased'},
                {data: 'student_performance', name:'student_performance'},
                {data: 'progress_track', name:'progress_track'},
                {data: 'status', name:'status'},
                {data: 'action', name: 'action'},
                ] 
    });
});
</script>
    
@endsection

