$('#removeClass').click(function(){
	$('#sidebar_secondary').hide();
    $('#sidebar_secondary .chat_box').html('');
})

$('.notify_message').click(function(){
    $.ajax({
        //dataType: "json",
        //type: "POST", 
        url:'/referrals/loadlistmessage',
        success: function (data) {
            $('#list_messages').html(data);
        }
    });
})

$(document).on('click', '.btncountchat', function(){
    var count_conv = $('#count_conversation').html();
    if(count_conv){
        $count_after = count_conv -1;
        if($count_after > 0){
            $('#count_conversation').html($count_after);
        }else{
            $('#count_conversation').html('');
        }
    }
})

$(document).on('click', '.btnchat', function(){
	var data_user = $(this).attr('data-user');
	var data_id   = $(this).attr('data-id');
    
    
	$('#userone').val(data_user);
	$('#usersecond').val(data_id);

	$.ajax({
        dataType: "json",
        type: "POST", 
        url:'/referrals/loadconversation', 
        data: {data_user : data_user, data_id : data_id}, 
        success: function (data) {
            $('#chat .chat_box_content').html(data[0]);
            $('#chat .chat_box_content').addClass('conversation_'+data[1]);
            $('.user_reciever_conversation').html(data[2]);
        },
        complete: function (data) {
            var orderdiv = $('#chat .chat_box_content .chat_message_wrapper:last-child').attr('data');
            $('#lastdiv').val(orderdiv);
            var target = $(".chat_box_content");
            target.scrollTop(target[0].scrollHeight);
            countConversation(data_user);
        }
    });
	$('#sidebar_secondary').show();

})


$('#submit_message').click(function(){
    var data_user = $('#userone').val();
    var data_id   = $('#usersecond').val();
    $.ajax({
        dataType: "json",
        type: "POST", 
        url:'/referrals/messagesseen', 
        data: {data_user : data_user, data_id : data_id}, 
        success: function (data) {  
        }
    });
})

//set max-height for #list-profile
var height_screen = screen.height;
$('.list-profile .scroll-messages').css('height',height_screen - 400);
$('.conversation-content .chat_box_wrapper').css('height',height_screen - 400);
$('.conversation-content .chat_box_content').css('height',height_screen - 510);


$(document).on('click', '.btnconvers', function(){
    var data_user = $(this).attr('data-user');
    var data_id   = $(this).attr('data-id');
    
    $('.btnconvers').removeClass('active');
    $(this).addClass('active');
    
    $('#userone').val(data_user);
    $('#usersecond').val(data_id);

    $.ajax({
        dataType: "json",
        type: "POST", 
        url:'/referrals/loadconversation', 
        data: {data_user : data_user, data_id : data_id}, 
        success: function (data) {
            $('#chat .chat_box_content').html(data[0]);
            $('#chat .chat_box_content').addClass('conversation_'+data[1]);
            $('.user_reciever_conversation').html(data[2]);
        },
        complete: function (data) {
            var orderdiv = $('#chat .chat_box_content .chat_message_wrapper:last-child').attr('data');
            $('#lastdiv').val(orderdiv);
            var target = $(".chat_box_content");
            target.scrollTop(target[0].scrollHeight);

            countConversation(data_user);
        }
    });
})


function countConversation(userid){
    $.ajax({
        //dataType: "json",
        type: "POST", 
        url:'/messages/countconversation', 
        data: {userid : userid}, 
        success: function (data) {
            $('.messages_count_'+userid).html(data);
        }
    });
}
