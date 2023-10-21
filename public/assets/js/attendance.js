$('#casual-leave-date-picker').datepicker({
    multidate: false,
    format: "dd-M-yyyy",
});
$('#unpaid-leave-date-picker').datepicker({
    multidate: true,
    format: "dd-M-yyyy",
});// $('#date-picker').datepicker('setDates', [new Date(2023, 2, 1), new Date(2023, 3, 5)]);

$('#early-get-off-date-picker').datepicker({
    multidate: false,
    format: "dd-M-yyyy",
});

$('#late-coming-form-date-picker').datepicker({
    multidate: false,
    format: "dd-M-yyyy",
});
$('#time-off-form-date-picker').datepicker({
    multidate: false,
    format: "dd-M-yyyy",
});$('#time-off-form-date-picker').datepicker().datepicker('setDate', 'today');

$('#extra-time-form-date-picker').datepicker({
    multidate: false,
    format: "dd-M-yyyy",
});//$('#extra-time-form-date-picker').datepicker().datepicker('setDate', 'today');
$('#add-workingday-form-date-picker').datepicker({
    multidate: false,
    format: "dd-M-yyyy",
});
$('#add-holiday-form-date-picker').datepicker({
    multidate: false,
    format: "dd-M-yyyy",
});
$('#form-date-picker').datepicker({
    multidate: false,
    format: "dd/mm/yyyy",
});
$('#form-date-picker-to').datepicker({
    multidate: false,
    format: "dd/mm/yyyy",
});
$('#form-date-picker-from').datepicker({
    multidate: false,
    format: "dd/mm/yyyy",
});

//-----------------------------------------------------------------------

  function switchToApplicationForm(selected_form){
    console.log(selected_form  +  'triggered');
    document.getElementById('application-list').style.display = 'none';
    document.getElementById(selected_form).style.display = 'block';
    if(selected_form == 'extra-time-form'){$('#extra-time-form-date-picker').datepicker().datepicker('setDate', 'today');}
  }
  function cancelApplicationForm(currently_active_form){
    console.log(currently_active_form  +  'cancelled');
    document.getElementById(currently_active_form).style.display = 'none';
    document.getElementById('application-list').style.display = 'block';
  }

  function showSubmitResponseMsg(response){
    if(response['status'] == 'success' || response['status'] == 200){
      $("#application-submit-msg-row").css({"display":"block",});
      $("#application-submit-msg-child").css({"display":"block","background-color": "#00d25b",});
      $("#application-submit-msg-child").text(response['message']);
    }else if(response['status'] == 'failed' || response['status'] == 400){
      $("#application-submit-msg-row").css({"display":"block",});
      $("#application-submit-msg-child").css({"display":"block","background-color": "#fc424a",});
      $("#application-submit-msg-child").text(response['message']);
    }
    setTimeout(function() {
      $("#application-submit-msg-row").css({"display":"none",});
    },3500);
  }












