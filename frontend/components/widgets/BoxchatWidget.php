<?php 
namespace frontend\components\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\widgets\Menu;


class BoxchatWidget extends Widget
{
    public function init()
    {
        
    }

    public function run()
    {
?>

        <aside id="sidebar_secondary" class="tabbed_sidebar ng-scope chat_sidebar">

            <div class="popup-head">
            	<div class="popup-head-left pull-left">
                    <a Design and Developmenta title="Gurdeep Osahan (Web Designer)" target="_blank" href="https://web.facebook.com/iamgurdeeposahan">
                        <img class="md-user-image" alt="Gurdeep Osahan (Web Designer)" title="Gurdeep Osahan (Web Designer)" src="http://bootdey.com/img/Content/avatar/avatar1.png" title="Gurdeep Osahan (Web Designer)" alt="Gurdeep Osahan (Web Designer)">
                        <h1>Gurdeep Osahan</h1>
                    </a>
                </div>
            	<div class="popup-head-right pull-right">
            		<button data-widget="remove" id="removeClass" class="chat-header-button pull-right" type="button">
                        <i class="glyphicon glyphicon-remove"></i>
                    </button>
                </div>
            </div>

            <div id="chat" class="chat_box_wrapper chat_box_small chat_box_active" style="opacity: 1; display: block; transform: translateX(0px);">
                <div class="chat_box touchscroll chat_box_colors_a">
                    <div class="chat_message_wrapper">
                        <div class="chat_user_avatar">
                            <a href="https://web.facebook.com/iamgurdeeposahan" target="_blank" >
                            <img alt="Gurdeep Osahan (Web Designer)" title="Gurdeep Osahan (Web Designer)"  src="http://bootdey.com/img/Content/avatar/avatar1.png" class="md-user-image">
                            </a>
                        </div>
                        <ul class="chat_message">
                            <li>
                                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio, eum? </p>
                            </li>
                            <li>
                                <p> Lorem ipsum dolor sit amet.<span class="chat_message_time">13:38</span> </p>
                            </li>
                        </ul>
                    </div>
                    <div class="chat_message_wrapper chat_message_right">
                        <div class="chat_user_avatar">
                        <a href="https://web.facebook.com/iamgurdeeposahan" target="_blank" >
                            <img alt="Gurdeep Osahan (Web Designer)" title="Gurdeep Osahan (Web Designer)" src="http://bootdey.com/img/Content/avatar/avatar1.png" class="md-user-image">
                        </a>
                        </div>
                        <ul class="chat_message">
                            <li>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem delectus distinctio dolor earum est hic id impedit ipsum minima mollitia natus nulla perspiciatis quae quasi, quis recusandae, saepe, sunt totam.
                                    <span class="chat_message_time">13:34</span>
                                </p>
                            </li>
                        </ul>
                    </div>
                    <div class="chat_message_wrapper">
                        <div class="chat_user_avatar">
                        <a href="https://web.facebook.com/iamgurdeeposahan" target="_blank" >
                            <img alt="Gurdeep Osahan (Web Designer)" title="Gurdeep Osahan (Web Designer)" src="http://bootdey.com/img/Content/avatar/avatar1.png" class="md-user-image">
                        </a>
                        </div>
                        <ul class="chat_message">
                            <li>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque ea mollitia pariatur porro quae sed sequi sint tenetur ut veritatis.https://www.facebook.com/iamgurdeeposahan
                                    <span class="chat_message_time">23 Jun 1:10am</span>
                                </p>
                            </li>
                        </ul>
                    </div>
                    <div class="chat_message_wrapper chat_message_right">
                        <div class="chat_user_avatar">
                        <a href="https://web.facebook.com/iamgurdeeposahan" target="_blank" >
                            <img alt="Gurdeep Osahan (Web Designer)" title="Gurdeep Osahan (Web Designer)" src="http://bootdey.com/img/Content/avatar/avatar1.png" class="md-user-image">
                        </a>
                        </div>
                        <ul class="chat_message">
                            <li>
                                <p> Lorem ipsum dolor sit amet, consectetur. </p>
                            </li>
                            <li>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    <span class="chat_message_time">Friday 13:34</span>
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="chat_submit_box">
                <div class="uk-input-group">
                    <div class="gurdeep-chat-box">
                        <textarea type="text" placeholder="Type a message" id="submit_message" name="submit_message" class="md-input"></textarea>
                        
                    </div>
                </div>
                <span style="vertical-align: sub;" class="uk-input-group-addon">
                    <a href="#"><i class="fa fa-camera"></i></a>
                </span>
            </div>
        </aside>
<?php
    }

}
?>
