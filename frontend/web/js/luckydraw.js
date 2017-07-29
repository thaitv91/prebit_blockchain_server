// Vars used by the code in this page to do power controls.
var wheelPower    = 3;
var wheelSpinning = false;

// -------------------------------------------------------
// Function to handle the onClick on the power buttons.
// -------------------------------------------------------
// function powerSelected(powerLevel)
// {
//     // Ensure that power can't be changed while wheel is spinning.
//     if (wheelSpinning == false)
//     {
//         // Reset all to grey incase this is not the first time the user has selected the power.
//         document.getElementById('pw1').className = "";
//         document.getElementById('pw2').className = "";
//         document.getElementById('pw3').className = "";
        
//         // Now light up all cells below-and-including the one selected by changing the class.
//         if (powerLevel >= 1)
//         {
//             document.getElementById('pw1').className = "pw1";
//         }
            
//         if (powerLevel >= 2)
//         {
//             document.getElementById('pw2').className = "pw2";
//         }
            
//         if (powerLevel >= 3)
//         {
//             document.getElementById('pw3').className = "pw3";
//         }
        
//         // Set wheelPower var used when spin button is clicked.
//         wheelPower = powerLevel;
        
//         // Light up the spin button by changing it's source image and adding a clickable class to it.
//         document.getElementById('spin-spin').src = "spin_on.png";
//         document.getElementById('spin-spin').className = "clickable";
//     }
// }

// -------------------------------------------------------
// Click handler for spin button.
// -------------------------------------------------------
function startSpin()
{
    // Ensure that spinning can't be clicked again while already running.
    if (wheelSpinning == false)
    {
        var ticket = $('#ticket').val();
        var user = $('#Userlogin').val();
        var luckywheel = $('#Luckywheel').val();
        if(ticket > 0){
            $('#ticket').val(ticket-1);
            $('.amountticket').html(ticket-1);
            //ajax minus ticket of user
            $.ajax({
                dataType: "html",
                type: "POST", 
                data: {user : user, luckywheel : luckywheel}, 
                url:'/luckydraw/minusticket',  
                success: function (data) {
                }
            });
            // Based on the power level selected adjust the number of spins for the wheel, the more times is has
            // to rotate with the duration of the animation the quicker the wheel spins.
            if (wheelPower == 1)
            {
                theWheel.animation.spins = 3;
            }
            else if (wheelPower == 2)
            {
                theWheel.animation.spins = 6;
            }
            else if (wheelPower == 3)
            {
                theWheel.animation.spins = 9;
            }
            
            // Disable the spin button so can't click again while wheel is spinning.
            document.getElementById('spin-spin').src       = "spin_off.png";
            document.getElementById('spin-spin').className = "btn btn-defaulf";
            
            // Begin the spin animation by calling startAnimation on the wheel object.
            theWheel.startAnimation();
            
            // Set to true so that power can't be changed and spin button re-enabled during
            // the current animation. The user will have to reset before spinning again.
            wheelSpinning = true;
        } else {
            $('.ticketzero').show();
        }
    }
}

// -------------------------------------------------------
// Function for reset button.
// -------------------------------------------------------
function resetWheel()
{
    theWheel.stopAnimation(false);  // Stop the animation, false as param so does not call callback function.
    theWheel.rotationAngle = 0;     // Re-set the wheel angle to 0 degrees.
    theWheel.draw();                // Call draw to render changes to the wheel.
    
    // document.getElementById('pw1').className = "";  // Remove all colours from the power level indicators.
    // document.getElementById('pw2').className = "";
    // document.getElementById('pw3').className = "";
    
    wheelSpinning = false;          // Reset to false to power buttons and spin can be clicked again.

}

// -------------------------------------------------------
// Called when the spin animation has finished by the callback feature of the wheel because I specified callback in the parameters.
// -------------------------------------------------------
function alertPrize()
{
    // Get the segment indicated by the pointer on the wheel background which is at 0 degrees.
    var winningSegment = theWheel.getIndicatedSegment();
    
    // Just alert to the user what happened.
    // In a real project probably want to do something more interesting than this with the result.
    var gift = winningSegment.gift;
    var user = winningSegment.user;
    var luckywheel = winningSegment.luckywheel;

    $.ajax({
        //dataType: "html",
        type: "POST", 
        data: {user : user, gift : gift, luckywheel : luckywheel}, 
        url:'/luckydraw/spinwheel',  
        success: function (data) {
            $('#alert_luckydraw').html(data);
            $('#success_luckydraw').modal();
        }
    });

}





