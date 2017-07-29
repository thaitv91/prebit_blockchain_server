<?php 
namespace frontend\components\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\db\Query;
use yii\widgets\Menu;
use common\models\User;
use common\models\Notify;
use common\models\Cities;
use common\models\States;
use common\models\Countries;
use common\models\Conversation;
use common\models\ChatMessages;

class TopbarWidget extends Widget
{
	public function init()
    {
        
    }

	public function run()
    {
        $model = Notify::find()->where(['receive_id' => (string) Yii::$app->user->identity->id])->andWhere(['publish' => Notify::PUBLISH_NOACTIVE, 'receive_id'=>Yii::$app->user->identity->id])->orderBy(['created_at' => SORT_DESC])->limit(4)->all();
        $countmessage = Notify::find()->where(['receive_id' => Yii::$app->user->identity->id])->groupBy(['all_id', 'receive_id'])->andWhere(['publish' => Notify::PUBLISH_NOACTIVE, 'receive_id'=>Yii::$app->user->identity->id])->count();

        //get conversation not seen
        $conversations = Conversation::find()->where(['user_first'=>Yii::$app->user->identity->id])->orWhere(['user_second'=>Yii::$app->user->identity->id])->all();
        $count_conver = 0;
        if(!empty($conversations)){
            foreach ($conversations as $key => $convers) {
                $messages = ChatMessages::find()->where(['id_conversation' => $convers->id, 'status' => ChatMessages::STATUS_NOACTIVE])->andWhere(['<>', 'user_id', Yii::$app->user->identity->id])->one();
                if(!empty($messages)){
                    $user = User::findOne($messages->user_id);
                    $count_conver += 1;
                }
            }
        }
    	?>


    	<div class="topbar-left">
            <div class="logo">
                <h1><a href="<?= Yii::$app->params['site_url'] ?>"><img src="/images/logo.png" alt="Logo"></a></h1>
            </div>
            <button class="button-menu-mobile open-left left-menu-toggle">
                <i class="fa fa-bars"></i>
            </button>
        </div>
        <!-- Button mobile view to collapse sidebar menu -->
        <div class="navbar navbar-default" role="navigation">
            <div class="container">
                <div class="navbar-collapse2">
                    <ul class="nav navbar-nav navbar-right top-navbar">
                        <li class="dropdown iconify hide-phone notify_connversation">
                            <a href="#" class="dropdown-toggle notify_message" data-toggle="dropdown">
                                <i class="fa fa-comments"></i>
                                <span id="count_conversation" class="label label-danger absolute messages_count_<?=Yii::$app->user->identity->id?>"><?php if($count_conver > 0) { echo $count_conver;}?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-message">
                                <li class="dropdown-header notif-header"><i class="icon-bell-2"></i> New Messages<a class="pull-right" href="#"></a></li>
                                <div id="list_messages">
                                
                                </div>
                                <li class="dropdown-footer">
                                    <div class="btn-group btn-group-justified">
                                        <div class="btn-group">
                                            <a href="<?=Yii::$app->urlManager->createAbsoluteUrl('/messages/index')?>" class="btn btn-sm btn-success ">See All <i class="icon-right-open-2"></i></a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown iconify">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i>
                                <?php if (number_format($countmessage) > 0) {
                                    echo '<span class="label label-danger absolute">';
                                    echo number_format($countmessage, 0, '', '.');
                                    echo '</span>';
                                }
                                ?>
                                
                            </a>
                            <ul class="dropdown-menu dropdown-message chat-v">
                                <li class="dropdown-header notif-header"><i class="icon-mail-2"></i> New Messages</li>
                                <?php
                                    if (!empty($model)) {
                                        foreach ($model as $value) {
                                            ?>
                                            <li class="unread">
                                                <?php echo Html::a('<img src="/images/users/chat/3.jpg" class="xs-avatar ava-dropdown" alt="Avatar"><strong>Admin</strong><i class="pull-right msg-time">'.Yii::$app->convert->time($value->created_at).' ago</i><br />'.'<p>'.$value->title.'</p>', '/message/view/'.$value->id, ['title' => Yii::t('app', 'View'),'data-pjax' => '0', 'class'=>''
                                                            ]) ?>                                                
                                            </li>
                                        <?php
                                        }
                                    }
                                ?>
                                <li class="dropdown-footer">
                                    <div class="">
                                        <?php echo Html::a('<i class="fa fa-share"></i> See all messages', '/message/inbox/', ['class'=>'btn btn-sm btn-block btn-primary']) ?>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="dropdown iconify">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-globe"></i></a>
                            <ul class="dropdown-menu dropdown-message">
                                <li class="dropdown-header notif-header"><i class="icon-bell-2"></i> Choose Languages<a class="pull-right" href="#"></a></li>
                                <li class="<?php if(!empty($_SESSION['language'])){ if($_SESSION['language'] == 'en'){ echo 'active';}}?>">
                                    <a class="languages active" href="javascript:;" data="en">
                                       English
                                    </a>
                                </li>
                                <li class="<?php if(!empty($_SESSION['language'])){ if($_SESSION['language'] == 'cn'){ echo 'active';}}?>">
                                    <a class="languages" href="javascript:;" data="cn">
                                       Chinese
                                    </a>
                                </li>
                            </ul>
                        </li>                    
                        <li class="dropdown topbar-profile">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="rounded-image topbar-profile-image">
                                <?php 
                                if(!empty(Yii::$app->user->identity->avatar)){
                                    $src = 'uploads/users/'.Yii::$app->user->identity->avatar;
                                }else{
                                    $src = '/uploads/users/default-avatar.jpg';
                                }
                                ?>
                                <img id="avatar2" class="img-responsive avarta" alt="" src="<?= Yii::$app->params['url_file'] ?><?=$src;?>" />
                                </span>
                                <strong><?php echo Yii::$app->user->identity->username; ?></strong> <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <?=Html::a('<i class="fa fa-user"></i> My Profile', Yii::$app->urlManager->createAbsoluteUrl('/user/view/'));?>
                                </li>
                                <li>
                                    <?=Html::a('<i class="fa fa-power-off"></i> Logout', Yii::$app->urlManager->createAbsoluteUrl('/site/logout'), ['data-method'=>'post']);?>
                                </li>                                
                            </ul>
                        </li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </div><!--navbar navbar-default-->
    	<?php
    }

}    	