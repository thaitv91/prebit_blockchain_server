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
use common\models\User;
use common\models\CharityDonors;

class SidebarWidget extends Widget
{
	public function init()
    {
        
    }

	public function run()
    {
        
    	?>
    	<div class="profile-info"><!--- Profile -->
            <div class="col-xs-4">
                <p class="rank-img">
                        <?php
                            $rank = Yii::$app->user->identity->level;
                            switch ($rank)
                            {
                                case 0 :
                                    echo '';
                                    break;
                                case 1:
                                    echo '<img src="/uploads/level/1.png">';
                                    break;
                                case 2:
                                    echo '<img src="/uploads/level/2.png">';
                                    break;
                                case 3:
                                    echo '<img src="/uploads/level/3.png">';
                                    break;
                                case 4 :
                                    echo '<img src="/uploads/level/4.png">';
                                    break;
                                case 5 :
                                    echo '<img src="/uploads/level/5.png">';
                                    break;
                                case 6 :
                                    echo '<img src="/uploads/level/6.png">';
                                    break;
                                case 7 :
                                    echo '<img src="/uploads/level/7.png">';
                                    break;
                                case 8 :
                                    echo '<img src="/uploads/level/8.png">';
                                    break;
                                default:
                                    echo '';
                                    break;
                            }
                        ?> 
                </p>
            </div>
            <div class="col-xs-8">
                <div class="profile-text">
                    <b <?php if(empty(Yii::$app->user->identity->charity)){echo "class = 'center_post'";}?>><?php echo Yii::$app->user->identity->fullname; ?></b>
                    <p> 
                        <?php if (!empty(Yii::$app->user->identity->charity)): ?>
                             Charity Contribution <br>
                             <?php
                                for ($i=0; $i < Yii::$app->user->identity->charity;  $i++) {
                                    if(($i+1)<=5){
                                        echo '<img src="'.Yii::$app->params['site_url'].'images/heart-charity.png">'.'&nbsp;';
                                    }
                                    
                                }
                             ?>
                        <?php echo ''; ?>
                        <?php endif ?>                          
                    </p>
                </div>
            </div>
        </div>
        <!--- Divider -->
        <div class="clearfix"></div>
        <hr class="divider" />
        <div class="clearfix"></div>

        <div id="sidebar-menu">
        	<?php
            echo Menu::widget([
            	'activateItems' => true,
		        'activateParents' => true,
		        'activeCssClass' => 'active',
                'items' => [
                    ['label' => '<img src="/images/icon/i-home.png"> Dashboard<span class="pull-right"></span>', 'url' => ['/site/index'],],
                    ['label' => '<img src="/images/icon/i-send.png"> Deposit<span class="pull-right"></span>', 'url' => ['/sendhelp/index'],], 
                    ['label' => '<img src="/images/icon/i-get.png"> Withdraw<span class="pull-right"></span>', 'url' => ['/gethelp/index']], 
                    ['label' => '<img src="/images/icon/i-token.png"> Fee<span class="pull-right"></span>', 'url' => ['/token/index']], 
                    ['label' => '<img src="/images/icon/i-wallet.png"> Your cash<span class="pull-right"></span>', 'url' => ['/bitwallet/index']], 
                    ['label' => '<img src="/images/icon/i-referrals.png"> Referrals<span class="pull-right"></span>', 'url' => ['referrals/index']],
                    ['label' => '<img src="/images/icon/i-downline.png"> Network<span class="pull-right"></span>', 'url' => ['/downlinetree/index'],], 
                    ['label' => '<img src="/images/icon/i-referrals-bonus.png"> Direct Bonus<span class="pull-right"></span>', 'url' => ['/referralsbonus/index']], 
                    ['label' => '<img src="/images/icon/i-manager.png"> Indirect Bonus<span class="pull-right"></span>', 'url' => ['/managerbonus/index']], 
                    // ['label' => '<img src="/images/icon/i-lucky.png"><span>Lucky Draw</span><span class="pull-right"></span>', 'url' => ['/luckydraw/index']], 
                     
                ],
                'encodeLabels' => false,
                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
                'options' => array('class' => 'nav nav-list'),

            ]);
            ?>
            <div class="clearfix"></div>
        </div>
    	<?php
    }

}
?>
