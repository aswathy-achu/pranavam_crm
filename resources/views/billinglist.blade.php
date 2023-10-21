@extends('index')
@section('content')
<div class="main-content">
<div class="col-lg-12 grid-margin stretch-card">
    
        <div class="card">
            <div class="card-body">
            <a href="{{route('addinvoice')}}" class="btn btn-primary">+ Create New invoice</a>

                <div class="col-lg-12 grid-margin">
                    <h1>Invoice List</h1>
                </div>
                <div class="table-responsive col-12 col-md-12 col-lg-12">
                <table id="data-table" class="table table-hover align-middle mb-0 dataTable ">
                <thead>
                        <tr>
                          <th>SL No</th>
                          <th>Invoice No</th>
                          <th>created at</th>
                          <th>Amount</th>
                          <th>paid By</th>
                          <th>Balance Amount</th>
                          <th>Student</th>
                          <th>View Invoice</th>
                          <th>Edit Invoice</th>
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
       ajax: "{{route('get-bill')}}",
       columns: [
                {
                    data: 'DT_RowIndex',
                    orderable: false, 
                    searchable: false
                }, 
                {data: 'invoice_no', name: 'invoice_no'},
                {data: 'date', name: 'date'},
                {data: 'account_amt', name: 'account_amt'},
                {data: 'paid_by', name:'paid_by'},
                {data: 'balance_amount', name:'balance_amount'},
                {data: 'stud_id', name:'stud_id'},
                
                {data: 'viewinvoice', name:'viewinvoice'},
                {data: 'action', name: 'action'},
                ] 
    });
});
</script>
    
@endsection

