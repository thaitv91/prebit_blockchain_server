<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\controllers\MemberController;
use common\models\User;
use common\models\CharityProgram;
use common\models\ShTransfer;
use common\models\GhTransfer;

$this->title = 'Banners - PreBit';
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 top-dashboard">
        <h2><?=Yii::$app->languages->getLanguage()['promotion_banners']?></h2>
		<?=Yii::$app->languages->getLanguage()['view_banners_and_referral_link_here']?>
        
    </div>                    
</div>
<div class="bg-white banner-page">
    <section class="col-md-8 col-lg-8 col-sm-8 col-xs-12 col-lg-offset-2">
        <div class="table-responsive">
            <table>
                <tbody>
                    <tr>
                        <td valign="top">
							<?=Yii::$app->languages->getLanguage()['use_our_referral_program_and_earn_up_to']?> <strong> 20.5%</strong> <?=Yii::$app->languages->getLanguage()['of_your_referral_deposit']?>!
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                                <td id="all-banner">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                    <tbody>
                                    <tr>
                                        <td>
											<?=Yii::$app->languages->getLanguage()['below_you_can_see_the_code_of_the_banner_you_have_chosen_you_can_now_embed_it_into_your_website']?>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <br>
                                            <img src="<?= Yii::$app->params['url_file'] ?>/images/banner2.gif" border="1"><br>
                                            <br>
                                             Code:<br>
                                            <textarea name="textfield" cols="55" rows="5" style="width:100%;">&lt;a href="<?=Yii::$app->params['url_file']?>register?u=<?=Yii::$app->user->identity->username?>" target="_blank"&gt;&lt;img src="https://system.pre-bit.org/images/banner2.gif" width="728" height="90" border="0" &gt;&lt;/a&gt; </textarea>
                                            <br>
                                            <br>
                                            <a href="http://www.instantinvest.biz/?ref=Username" target="_blank"></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="<?= Yii::$app->params['url_file'] ?>/images/banner3.gif" border="1"><br>
                                            <br>
                                             Code:<br>
                                            <textarea name="textfield" cols="55" rows="5" style="width:550px;">&lt;a href="<?=Yii::$app->params['url_file']?>register?u=<?=Yii::$app->user->identity->username?>" target="_blank"&gt;&lt;img src="https://system.pre-bit.org/images/banner3.gif" width="468" height="60" border="0" &gt;&lt;/a&gt; </textarea>
                                            <br>
                                            <br>
                                            <a href="http://www.instantinvest.biz/?ref=Username" target="_blank"></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="<?= Yii::$app->params['url_file'] ?>/images/125X125_2.gif" border="1"><br>
                                            <br>
                                             Code:<br>
                                            <textarea name="textfield" cols="55" rows="5" style="width:550px;">&lt;a href="<?=Yii::$app->params['url_file']?>register?u=<?=Yii::$app->user->identity->username?>" target="_blank"&gt;&lt;img src="https://system.pre-bit.org/images/125X125_2.gif" width="125" height="125" border="0" &gt;&lt;/a&gt; </textarea>
                                            <br>
                                            <br>
                                            <a href="http://www.instantinvest.biz/?ref=Username" target="_blank"></a>
                                        </td>
                                    </tr>
                                    </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>