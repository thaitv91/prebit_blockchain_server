$( function() {
    $( "#datepicker1" ).datepicker({
        appendText: "(yyyy-mm-dd)"
    });
  } );
$( function() {
    $( "#datepicker2" ).datepicker({
        appendText: "(yyyy-mm-dd)"
    });
  } );

$('.date-picker').datepicker({
	autoclose: true,
	todayHighlight: true,
	endDate: new Date()
})

$('.date-picker-future').datepicker({
  autoclose: true,
  todayHighlight: true,
  startDate: '+1d'
})

$('.date-range-picker').daterangepicker({
  'applyClass' : 'btn-sm btn-success',
  'cancelClass' : 'btn-sm btn-default',
  'locale': {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Apply",
        "cancelLabel": "Cancel",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
        "daysOfWeek": [
            "Su",
            "Mo",
            "Tu",
            "We",
            "Th",
            "Fr",
            "Sa"
        ],
        "monthNames": [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ],
        "firstDay": 1
    },
  // locale: {
  //   format: 'DD-MM-YYYY',
  //   applyLabel: 'Apply',
  //   cancelLabel: 'Cancel',
  // }
})
     
