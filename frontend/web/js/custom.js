//CLick Form In GET HELP PAGE

$(document).ready(function(){
    $(".languages").click(function(){
        var data = $(this).attr("data");
        $.ajax({
            dataType: "html",
            type: "POST", 
            url:'/user/setlanguage', 
            data: {lang : data}, 
            success: function (data) {
                if(data){
                    location.reload();
                } 
            }
        });
        
    });
});

$(document).ready(function(){
    $("button#click-to-gh").click(function(){
        $("#form-show-bonus").slideToggle();
        $( "button#click-to-gh" ).addClass( "hide" );
    });
});
$(document).ready(function(){
    $("button#click-to-main").click(function(){
        $("#form-show-main").slideToggle();
        $( "button#click-to-main" ).addClass( "hide" );
    });
});
$(document).ready(function(){
    $("#click-to-request").click(function(){
        $("#form-show-request").slideToggle();
        $( "#form-hide-request" ).addClass( "hide" );
    });
});
$( function() {
    $( "#datepicker" ).datepicker({
        appendText: "(yyyy-mm-dd)"
    });
  } );

$(function() {
    $('.summernote').summernote({
      height: 500
    });
});
$(function(){
    $('.summernote-small').summernote({
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']]
      ],
      height: 200
    });
});


$.fn.increment= function(options) {
    var $this = $(this);
    var coef = options.coef;
    var speed = options.speed;
    var value = options.amount;
    setInterval(function(){ 
        value = value + coef;
        $this.html(value.toFixed(8));
    }, 100);
};


function reload_page(){
    location.reload();
}


function getMobileOperatingSystem() {
  var userAgent = navigator.userAgent || navigator.vendor || window.opera;

      // Windows Phone must come first because its UA also contains "Android"
    if (/windows phone/i.test(userAgent)) {
        //copy button
        var clipboard = new Clipboard('.btn-copy');
        clipboard.on('success', function(e) {
            console.log(e);
        });
        clipboard.on('error', function(e) {
            console.log(e);
        });
    }

    if (/android/i.test(userAgent)) {
        //copy button
        var clipboard = new Clipboard('.btn-copy');
        clipboard.on('success', function(e) {
            console.log(e);
        });
        clipboard.on('error', function(e) {
            console.log(e);
        });
    }

    // iOS detection from: http://stackoverflow.com/a/9039885/177710
    if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
        $(document).ready(function() {
        //Select text on focus for input
            $(".referrals-link input:text").focus(focustext);
        });
        function focustext() {
            var input = this;
            setTimeout(function () {
                input.selectionStart = 0;
                input.selectionEnd = input.val().length;
            },100);
        }
    }

    return "unknown";
}

//copy button
    var clipboard = new Clipboard('.btn-copy');
    clipboard.on('success', function(e) {
        console.log(e);
    });
    clipboard.on('error', function(e) {
        console.log(e);
    });


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

function  formatMoney(n, currency) {
    return currency + " " + n.toFixed(2).replace(/./g, function(c, i, a) {
        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
    });
}

$(document).ready(function(){
    var timer = setInterval(function() { 
        var today = new Date();
        var d = today.getDate();
        var M = today.getMonth() +1;
        var y = today.getFullYear();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        d = checkTime(d);
        M = checkTime(M);
        m = checkTime(m);
        s = checkTime(s);
        $('.currentServertime').html(d +"-"+ M + "-" + y + " " + h + ":" + m + ":" + s);
        }, 500);
})
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}


$(document).ready(function(){
    function standbyGethelp() {
    $.ajax({
        dataType: "html",
        type: "POST", 
        url:'/gethelp/standbygethelp',  
        success: function (data) {
            //$('#standbyGethelp').html(data);
        }
    });
    var t = setTimeout(standbyGethelp, 1800000);
    };
    window.onload = standbyGethelp;
})


function isNumberKey(evt){
    var theEvent = evt || window.event;
      var key = theEvent.keyCode || theEvent.which;
      if ((key < 48 || key > 57) && !(key == 8 || key == 9 || key == 13 || key == 37 || key == 39 ) ){
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
      }
}

