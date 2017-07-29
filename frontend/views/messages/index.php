<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\GhTransfer;
use yii\grid\GridView;

$this->title = 'Messages - PreBit';
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 top-dashboard">
        <h2>MESSAGES</h2>
        You can check chat history with your sponsors here.
    </div>                    
</div>				
<div class="row" id="messages_container">
	<div class="col-md-12 col-sm-12 col-xs-12">
	    <div class="col-md-3 col-sm-4 col-xs-12 select-item list-conversation">
	    	<div class="row">
		        <h3>Chat List (<?=count($list_conversation)?>)</h3>
	            <div class="list-profile">
	                <div class="scroll scroll-messages scrollTo">
	                	<?php 
	                	if(!empty($list_conversation)){
	                		foreach ($list_conversation as $key => $conversation) {

                            if(!empty($conversation['avatar'])){
                                $src = 'uploads/users/'.$conversation['avatar'];
                            }else{
                                $src = '/uploads/users/default-avatar.jpg';
                            }
	                	?>
	                	<div class="media">
	                        <a class="btnconvers" href="javascript:;" data-user="<?=$conversation['data-user']?>" data-id="<?=$conversation['data-id']?>">
	                            <div class="media-left">
	                                <img class=" avatar" width="50" src="<?= Yii::$app->params['url_file'] ?><?=$src?>">
	                            </div>
	                            <div class="media-body">
	                                <h4 class="media-heading"><?=$conversation['username']?></h4>
	                                <small>
	                                    <?=$conversation['lastmessage']?>
	                                </small>
	                            </div>
	                            <h4 class="line-hr"></h4>
	                        </a>
	                    </div>
	                	<?php
	                		}
	                	}
	                	?>
	                </div>
	            </div>
	        </div>    
	    </div>
		<div class="col-md-9 col-sm-8 col-xs-12 select-item conversation-content">
		    <div class="message-content">
		        <h3 class="user-conv user_reciever_conversation"></h3>
		        <!--<p class="time"><?php // Yii::$app->convert->get_date($messages_user->created_at);                                                                                                                                  ?></p>-->
		        <div class="comment user-messages scrollTo">
		        	<div id="chat" class="chat_box_wrapper chat_box_small chat_box_active" style="opacity: 1; display: block; transform: translateX(0px);">
				        <div class="chat_box_content touchscroll chat_box_colors_a">
							
				        </div>
				    </div>
		        </div>
		        <div class="chat_submit_box">
			        <?= Html::beginForm(['/messages/index'], 'POST', ['id' => 'chat-form']) ?>
			            <div class="uk-input-group">
			            	<div class="">
			                    <div class="file-atch"></div>
			                    <input type="hidden" id="file_atch" name="file_atch">

			                </div>
			                <div class="gurdeep-chat-box">
			                    <input id="userone" type="hidden" name="userone" value="">
			                    <input id="usersecond" type="hidden" name="usersecond" value="">
			                    <input id="lastdiv" type="hidden" name="lastdiv" value="">
			                    <textarea type="text" placeholder="Type a message" id="submit_message" name="message" class="md-input"></textarea>
			                </div>
			            </div>
			            <span style="vertical-align: sub;" class="uk-input-group-addon">
			                <a href="javacript:;" id="fileAttach"><i class="fa fa-camera"></i></a>
                			<input id="upload" type="file" style="display:none"/>
			                <?= Html::submitButton('Send', ['class' => 'btn btn-block btn-success',]) ?>
			            </span>
			        <?= Html::endForm() ?>
			    </div>
		    </div>
		</div>  
	</div>		  
</div><!--row1-->

<?=$this->registerJs("
$('#submit_message').keydown(function(event) {
    if (event.keyCode == 13) {
        $(this.form).submit()
        return false;
    }
})
$('#chat-form').submit(function() {

    var form = $(this);
    $.ajax({
        url: form.attr('action'),
        type: 'post',
        data: form.serialize(),
        success: function (response) {
           $('#submit_message').val('');
        }
    });

     return false;
});
");
?>

<?= $this->registerJs("$(document).on('click', '#fileAttach', function (event){
        event.preventDefault();
        $('#upload').trigger('click');

});") ?>

<?=$this->registerJs("
$('#upload').change(function(){
    var file_data = $(this).prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);                            
    $.ajax({
        url: '/messages/uploadfile', 
        //dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(data){
            $('#file_atch').val(data);
            $('#chat-form').submit()
            return false;
        }
    });
})
");?>



