<?php 
$session = Yii::$app->session;
use common\models\User;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Referrals - Bitway';
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 top-dashboard">
        <h2>REFERRALS </h2>
        <?=Yii::$app->languages->getLanguage()['this_page_shows_all_the_members_that_you_have_invited_to_the_bitway_system']?>
    </div>    
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
        <!-- form search user -->
        <?php $form = ActiveForm::begin(['id' => 'searchuser']); ?>
            <?= $form->field($searchuser, 'username', ['template' => '<div class="form-search">{input}<button type="submit" aria-hidden="true"><i class="fa fa-search" aria-hidden="true"></i></button>{hint}{error}</div>'])->textInput(['maxlength' => true, 'placeholder' => 'Search username', 'class' => 'form-control', 'required' => 'required'])->label(false) ?>
        <?php ActiveForm::end(); ?>
        <!-- End / form form search user -->
    </div>                
</div>                
<div class="row referrals-link">
    <div class="col-lg-12">
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-default btn-copy" type="button" data-clipboard-action="copy" data-clipboard-target="#linkRegister"><?=Yii::$app->languages->getLanguage()['referrals_link']?></button>
            </span>
            
            <input id="linkRegister" type="text" value="<?=Yii::$app->params['url_file']?>register?u=<?=$this_user->username?>">
        </div><!-- /input-group -->
    </div><!-- /.col-lg-6 -->
</div><!--referrals-link-->


<div class="row end-send-help referrals-wrap">
    <div class="col-md-12">
        <h3 class="title-end-send-help">Search results for "<?=$keyword?>": <?=count($username_result)?> results</h3>
        <div class="widget">
            <div class="widget-content">                    
                <div class="table-responsive">
                    <table id="datatables-1" class="table table-striped table-bordered">
                        <thead>
                            <tr class="tr-green-x">
                                <th data-sortable="false">Name</th>
                                <th data-sortable="false">Username</th>
                                <th data-sortable="false">Level</th>
                                <th data-sortable="false">Email</th>
                                <th data-sortable="false">Mobile</th>   
                                <th data-sortable="false">SH this month</th>                                           
                                <th data-sortable="false">SH</th>
                                
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php 
                            if(!empty($username_result)){
                            foreach ($username_result as $user) {
                                // $user = User::findOne($userid_active);
                            ?>
                            <tr>
                                <td><?=$user->fullname?></td>
                                <td><a  href="<?=Yii::$app->params['site_url'];?>referrals/index/<?=$user->id;?>" data-lightbox="passport"><?=$user->username?></a></td>
                                <td>
                                    <?php 
                                    $rank = $user->level;
                                    switch ($rank)
                                    {
                                        case 0 :
                                            echo '';
                                            break;
                                        case 1:
                                            echo 'Bronze';
                                            break;
                                        case 2:
                                            echo 'Silver';
                                            break;
                                        case 3:
                                            echo 'Gold';
                                            break;
                                        case 4 :
                                            echo 'Platinum';
                                            break;
                                        case 5 :
                                            echo 'Diamond';
                                            break;
                                        case 6 :
                                            echo 'Master';
                                            break;
                                        case 7 :
                                            echo 'Grandmaster';
                                            break;
                                        case 8 :
                                            echo 'Legendary';
                                            break;
                                        default:
                                            echo '';
                                            break;
                                    }
                                    ?>
                                </td>
                                <td><?=$user->email?></td>
                                <td>(+<?=$user->country->country_code;?>) <?=ltrim($user->phone, '0');?></td>
                                <td class="chat-table"><?php echo number_format($user->getTotalShthismonth($user->id), 8, '.', ''); ?></td>
                                <td class="green-number"><strong><?php echo number_format($user->getTotalSh($user->id), 8, '.', ''); ?></strong></td>                                                
                                
                            </tr>
                            <?php } }else{ ?>
                            <tr>
                                <td colspan="7">No user member</td>
                            </tr>
                            <?php }?>                                   
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><!--end-send-help-->

<?php
if(count($username_result) > 10){
    echo $this->registerJs("
        $('#datatables-1').dataTable();
    ");
}







