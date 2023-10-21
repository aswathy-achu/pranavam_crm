@extends('index')
@section('content')
<?php
use App\Batch;
use App\Batchdayslist;
use App\Student;
?>
<div class="main-content">
  <div class="row">
    <div class="col-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-header">
        <form action="{{ url('/manage_invoice') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="text" name="id" value="{{$invoice->id ?? '' }} ">
              <h4>create Bill</h4>
            </div>
            <div class="card-body">
              <div class="form-group col-5 col-md-5 col-lg-5">
                  <label>Date</label>
                  <input type="date" class="form-control" name="date" value="{{$invoice->date ?? ''}}">
              </div>
              <div class="form-group col-5 col-md-5 col-lg-5">
              <label class="col-sm-3 col-form-label">Invoice No.</label>
                @if(isset($invoice))
                    <input type="text" class="form-control" name="invoice_no" value="{{ $prefix ?? '' }}{{ $invoice->invoice_no }}" readonly />
                @else
                        <input type="text" class="form-control" name="invoice_no_view" value="{{ $prefix ?? '' }} {{ $nextInvoiceNumber ?? '' }}" readonly />
                        <input type="hidden" class="form-control" name="invoice_no" value="{{ $nextInvoiceNumber ?? '' }}" readonly />
                    @endif
                </div>

    <div class="form-group col-5 col-md-5 col-lg-5">
    <label>Batch Day</label>
    <select class="form-control" type="time" name="batch" id="batch-day-dropdown" onchange="fetchBatchTimes(this.value)">
        <option value="">--select--</option>
        @if(isset($invoice->batch_id))
            <?php
            $batchId = $invoice->batch_id;
            $batch = Batch::find($batchId);
            
            if ($batch) {
                $batchDay = $batch->batch_day;
                $batchDaysList = Batchdayslist::find($batchDay);
                if ($batchDaysList) {
                    $days = $batchDaysList->week_days;
                }
            }
            ?>
            <option value="{{ $batch->id }}" data-max-occupancy="{{ $batch->total_no_student }}" data-occupied-students="{{ $batch->occupy_students }}" selected>
                {{ $days ?? 'batch_Day' }} <!-- Display the batch day or 'batch_Day' if not available -->
            </option>
        @else
            @foreach($batch_daylist as $batch)
                <option value="{{ $batch->id }}" data-max-occupancy="{{ $batch->total_no_student }}" data-occupied-students="{{ $batch->occupy_students }}">{{ $batch->week_days }}</option>
            @endforeach
        @endif
    </select>
</div>


<div class="form-group col-5 col-md-5 col-lg-5">
    <label>From Time - To Time</label>
    <select class="form-control" name="from_time" id="from-time-dropdown" {{ isset($student->batch_id) ? '' : 'disabled' }}>
        <option value="">--select--</option>
        @if(isset($student->batch_id))
            <?php
            $batch = Batch::find($student->batch_id);
            ?>
            <option value="{{ $batch->from_time }} - {{ $batch->to_time }}" data-batch-id="{{ $batch->id }}" selected>
                {{ $batch->from_time }} - {{ $batch->to_time }}
            </option>
        @elseif(isset($invoice->batch_id))
            <?php
            $invoiceBatch = Batch::find($invoice->batch_id);
                ?>
                <option value="{{ $invoiceBatch->from_time }} - {{ $invoiceBatch->to_time }}" data-batch-id="{{ $invoiceBatch->id }}" selected>
                    {{ $invoiceBatch->from_time }} - {{ $invoiceBatch->to_time }}
                </option>
            @endif
        </select>
        <input type="hidden" name="batch_id" id="batch_id" value="{{ isset($student->batch_id) ? $student->batch_id : ($invoice->batch_id ?? '') }}">
    </div>
      <div class="form-group col-5 col-md-5 col-lg-5">
          <label>Course</label>
          <select name="course_id" class="form-control" id="course-dropdown">
              <option value="">--select--</option>
              @foreach($courselist as $course)
                  <option value="{{ $course->id }}" data-batch-id="{{ $course->batch_id }}" 
                      {{ isset($invoice->course_id) && $invoice->course_id == $course->id ? 'selected' : '' }}>
                      {{ $course->course_name }}
                  </option>
              @endforeach
          </select>
      </div>

            <div class="form-group col-5 col-md-5 col-lg-5 ">
              <label>Recieved By</label>
              <input type="text" name="received_from" class="form-control" value="{{$invoice->recieved_from ?? ''}}">
            </div>
            <div class="form-group col-5 col-md-5 col-lg-5 ">
              <label>Amount in words</label>
              <input type="text" name="amount_in_word" class="form-control" value="{{$invoice->amount_in_word ?? ''}}">
            </div>
          <!-- <div> -->
            <div class="form-group col-12 col-md-12 col-lg-12">
              <label name="for_payment">For Payment of</label>
              <div class="d-flex">
                <div class="mr-3">
                  <input type="checkbox"  id="paymentOption1" onclick="showTextBox('textBox1', 'dropDownList2')">
                  <label for="paymentOption1">Fees</label>
                </div>
                <div>
                <input type="checkbox" name="product" id="paymentOption2" onclick="showDropDown('dropDownList2', 'textBox1')">
                <label for="paymentOption2">Product</label>
              </div>
            </div>
          </div>
          <div id="textBox1"  class="form-group col-5 col-md-5 col-lg-5" style="display: none;">
            <input type="text" name="fees" class="form-control" value="{{$invoice->fees ?? ''}}">
          </div>
          <div id="dropDownList2"  class="form-group col-5 col-md-5 col-lg-5" style="display: none;">
          <select  name="product" class="form-control" name="product" id="batch-day-dropdown">
            <option value="">--select--</option>
            @foreach($productlist as $product)
                <option value="{{ $product->id }}">
                    {{ $product->product_name }}
                </option>
            @endforeach
          </select>
          </div>
          <div class="form-group col-5 col-md-5 col-lg-5">
            <label>From date</label>
            <input type="date" class="form-control" name="from_date" value="{{$invoice->from_date ?? ''}}">
          </div>
        <div class="form-group col-5 col-md-5 col-lg-5">
            <label>To date</label>
            
            <input type="date" class="form-control" name="to_date" value="{{$invoice->to_date ?? ''}}">
        </div>
          <div class="form-group col-5 col-md-5 col-lg-5">
            <label>Paid By</label>
            <select class="form-control" name="paid_by">
              <option>Cash</option>
              <option>Upi</option>
              <option>Cheque</option>
            </select>
          </div>
          <!-- <div class="form-group col-5 col-md-5 col-lg-5">
            <label>Datetime Local</label>
            <input type="datetime-local" class="form-control">
          </div> -->
          <div class="form-group col-5 col-md-5 col-lg-5">
    <label>Name</label>
    <select name="name" class="form-control" id="student-name-dropdown" onchange="fetchfeeinfo(this.value)">
        <option value="">--select--</option>
        @foreach($studentlist as $studentOption)
            <option value="{{ $studentOption->id }}" data-batch-id="{{ $studentOption->stud_id }}" 
                {{ isset($invoice->stud_id) && $invoice->stud_id == $studentOption->id ? 'selected' : '' }}>
                {{ $studentOption->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group col-5 col-md-5 col-lg-5">
    <label>Account Amt</label>
    <input type="number" name="account_amt" class="form-control" id="account-amt-input" value="{{$invoice->account_amt ?? ''}}" readonly>
</div>

<div class="form-group col-5 col-md-5 col-lg-5">
    <label>Balance Amount</label>
    <input type="number" name="balance_amt" class="form-control" id="balance-amt-input" value="{{$invoice->balance_amou ?? ''}}" readonly>
</div>

<div class="form-group col-5 col-md-5 col-lg-5">
    <label>Paid Amt</label>
    <input type="number" name="paid_amt" class="form-control" value="{{$invoice->paid_amount ?? ''}}" oninput="updateBalanceAmount(this)">
</div>


      <div class="form-group col-5 col-md-5 col-lg-5">
        <label>Email</label>
        <input type="email"  name="email" class="form-control" value="{{$invoice->email ?? ''}}">
      </div>
  

      <div class="form-group col-5 col-md-5 col-lg-5">
        <label>Phone</label>
        <input type="tel" name="phone" class="form-control" value="{{$invoice->phone ?? ''}}">
      </div>
        <div class="card-footer text-right">
          <button class="btn btn-primary mr-1" type="submit">Submit</button>
          <button class="btn btn-white mr-1" onclick="window.location='{{ URL::previous() }}'">Cancel</button>
        </div>
        </form>
      </div>
    </div>
</div>
@endsection
@section('contentjs')
<script>
 function showTextBox(textBoxId, dropDownId) {
    var textBox = document.getElementById(textBoxId);
    var dropDownList = document.getElementById(dropDownId);
    var checkbox = document.getElementById(textBoxId.replace("textBox", "paymentOption"));

    if (checkbox.checked) {
      textBox.style.display = "block";
      dropDownList.style.display = "none";
    } else {
      textBox.style.display = "none";
    }
  }

  function showDropDown(dropDownId, textBoxId) {
    var dropDownList = document.getElementById(dropDownId);
    var textBox = document.getElementById(textBoxId);
    var checkbox = document.getElementById(dropDownId.replace("dropDownList", "paymentOption"));

    if (checkbox.checked) {
      dropDownList.style.display = "block";
      textBox.style.display = "none";
    } else {
      dropDownList.style.display = "none";
    }
  }

    // Attach event listener to the batch dropdown

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
        $('#student-name-dropdown').prop('disabled', false);
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
                    // if (value['occupy_students'] == value['total_no_of_student']) {

                    //     option.prop('disabled', true);
                    // }
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
  fetchStudentInfo(batch_id);
}
// function updatecourseid(course_id) {
//         alert(course_id);
//         document.getElementById("course_id").value = course_id;
//        

// }
function updateStudentId(batch_id) {
  console.log(batch_id);
  document.getElementById("batch_id").value = batch_id;
  fetchfeeinfo(batch_id);
  fetchbalanceamount(batch_id);
  alert("dd");
}
function updatefeeid(batch_id) {
    console.log(batch_id);
    alert("hlo");
  document.getElementById("batch_id").value = batch_id;
  fetchfeeinfo(batch_id);updatefeeid
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
    function fetchStudentInfo(batch_id) {
    if (batch_id) {
      $.ajax({
        url: "{{ route('getStudentData') }}",
        method: 'GET',
        data: {
          'batch_id': batch_id,
        },
        success: function (data) {
          console.log(data);

          var studentDropdown = $('#student-name-dropdown');
          studentDropdown.empty();
          studentDropdown.append($('<option></option>').text('--select--').val(''));
          $.each(data, function (key, value) {
            var optionText = value.name;
            var optionValue = value.id;

            let option = $('<option></option>');
            option.text(optionText).val(optionValue);

            studentDropdown.append(option);
          });

          studentDropdown.prop('disabled', false);
        }
      });
    } else {
      $('#student-name-dropdown').empty();
      $('#student-name-dropdown').prop('disabled', true);
      $('#account-amt-input').val('');
     // Reset balance amount when no student is selected
    }
  }
//   function updateBalanceAmount(paidInput) {
//     const accountAmt = parseFloat(document.getElementById('account-amt-input').value) || 0;
//     const paidAmt = parseFloat(paidInput.value) || 0;
//     const balanceAmtInput = document.getElementById('balance-amt-input');
//     const balanceAmt = accountAmt - paidAmt;
//     balanceAmtInput.value = balanceAmt;
//   }
// function updateBalanceAmount(paidAmtInput) {
//     var accountAmtInput = document.getElementById('account-amt-input');
//     var balanceAmtInput = document.getElementById('balance-amt-input');

//     var accountAmt = parseInt(accountAmtInput.value) || 0;
//     var paidAmt = parseInt(paidAmtInput.value) || 0;

//     var balanceAmt = accountAmt - paidAmt;
//     balanceAmtInput.value = balanceAmt; // Set the calculated balance amount
// }
  let totalAmt = 0;
  let lastPaidAmt = 0;
  function updateBalanceAmount(paidInput) {
      const paidAmt = parseFloat(paidInput.value) || 0;
      lastPaidAmt = paidAmt;
      const balance_amt = document.getElementById('balance-amt-input');
      console.log(balanceAmtInput);
      const substracted_amt = balance_amt - paidAmt;
      balance_amtInput.value = (balanceAmt == 0) ? '0' : balanceAmt;
      
      // Re-enable the student dropdown for further payments
      const studentDropdown = document.getElementById('student-name-dropdown');
      studentDropdown.disabled = false;
}

function fetchfeeinfo(stud_id) {
  console.log(stud_id);
    if (stud_id) {
        $.ajax({
            url: "{{ route('getFeeData') }}",
            method: 'GET',
            data: {
                'stud_id': stud_id,
            },
            success: function (data) {
              console.log(data);


                if (data.student.id == stud_id) {
                    totalAmt = parseFloat(data.student.fees);
                    console.log(totalAmt);
                    lastPaidAmt = parseFloat(document.getElementsByName('paid_amt')[0].value) || 0;
                    // alert(lastPaidAmt);
                    $('#account-amt-input').val(data.student.fees);
                    // console.log(data.invoice.balance_amount);
                    $('#balance-amt-input').val(data.invoice.balance_amount);
                    updateBalanceAmount(document.getElementsByName('paid_amt')[0]);
                    

                    const studentDropdown = document.getElementById('student-name-dropdown');
                    // console.log(studentDropdown);
                    if (data.student.fees == data.invoice.paid_amount) {
                        studentDropdown.disabled = true;

                    } else {
                        studentDropdown.disabled = false;
                    }
                    console.log();
                } else {
                    totalAmt = 0;
                    lastPaidAmt = 0;
                    $('#account-amt-input').val('');
                    $('#balance-amt-input').val('');
                }
            },
            error: function (error) {
                console.log("Error fetching fee data:", error);
            }
        });
    } else {
        totalAmt = 0;
        lastPaidAmt = 0;
        $('#account-amt-input').val('');
        $('#balance-amt-input').val('');
    }
}
    function submitForm(batch_id) {
        // Your form submission code here

        // Send AJAX request to fetch student name
        alert('ddd');
        document.getElementById("myForm").submit();
    }
</script>
@endsection