@extends('index')
@section('content')
<div class="main-content">
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
            <div class="card-body">
               <a href="{{route('staffreg')}}" class="btn btn-primary">+ Create New Staff</a>
                <div class="col-lg-12 grid-margin">
                    <h1>Staff List</h1>
                </div>
                <div class="table-responsive col-12 col-md-12 col-lg-12">
                    <table id="data-table" class="table table-hover align-middle mb-0 dataTable ">
                <thead>
                        <tr>
                          <th>SL No</th>
                          <th>Name</th>
                          <th>Gender</th>
                          <th>Phone</th>
                          <th>Joined At</th>
                          <th>Address</th>
                          <th>Action</th>
                        </tr>
                </thead>
              </table>
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
       ajax: "{{route('get_staff')}}",
       columns: [
                {
                    data: 'DT_RowIndex',
                    orderable: false, 
                    searchable: false
                }, 
                {data: 'fname', name: 'fname'},
                {data: 'gender', name: 'gender'},
                {data: 'phone', name: 'phone'},
                {data: 'date_of_joining', name: 'date_of_joining'},
                {data: 'address1', name:'address1'},
                {data: 'action', name: 'action'},
                ] 
    });
});
</script>
    
@endsection

