$( document ).ready(function() {

    //var socket = io.connect('https://localhost:8890');
    var socket = io.connect('https://128.199.68.205:8890');

    

    socket.on('notification', function (data) {
        var message = JSON.parse(data);
        $('.messages_count_'+message.user_reciever).html(message.count_notseen);
        $( ".conversation_"+message.conversation ).append( message.content);
        $("#lastdiv").val(message.lastdiv);
        var target = $(".conversation_"+message.conversation);
        target.scrollTop(target[0].scrollHeight);
    });

});