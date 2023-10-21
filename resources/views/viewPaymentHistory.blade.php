@extends('index')
@section('content')
<div class="main-content">
    <div class="col-lg-12 grid-margin stretch-card">
    
        <div class="card">
            <div class="card-body">
                <div class="table-responsive col-12 col-md-12 col-lg-12">
                    <table id="data-table" class="table table-hover align-middle mb-0 dataTable">
                        <thead>
                        <tr>
                        <th>Sl No</th>
                        <th> Date</th>
                        <th>Fee Type</th>
                        <th>Total Amount</th>
                        <th>Paid Amount</th>
                        <th>Balance Amount</th>
                        <th>Receipt No </th>
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
@section('contentjs')
<script>
$(document).ready( function () {
$('.dataTable').dataTable({
       processing: true,
       serverSide: true,
       destroy: true,
       ajax: {
          url: "{{ route('paymenthistory') }}",
          data: function (d) {
             d.stud_id = "{{$stud_id}}";
          }
       },
       
       columns: [
                {
                    data: 'DT_RowIndex',
                    orderable: false, 
                    searchable: false
                },
                {data:'date', name:'date'},
                {data:'fee_type', name:'fee_type'},
                {data:'amount', name:'amount'},
                {data:'paid_amt', name:'paid_amt'},
                {data:'balance_amt', name:'balance_amt'},
                {data:'invoice_no', name:'invoice_no'}
                
             ]
    });
 });
</script>
@endsection