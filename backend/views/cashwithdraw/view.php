<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Cashwithdraw;

/* @var $this yii\web\View */
/* @var $model common\models\Cashwithdraw */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cashwithdraws', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">

    <div class="page-header">
        <h1>
            Cash Withdraw Detail
        </h1>
    </div><!-- /.page-header -->
    <div class="col-ms-12">
        <table class="table table-striped table-bordered">
            <tbody>
                <tr>
                    <td>Username</td>
                    <td><?=$model->getUser($model->user_id)->username?></td>
                </tr>  
                <tr>
                    <td>Amount</td>
                    <td class="center"><?=$model->amount?></td>
                </tr>  
                <tr>
                    <td>Currency</td>
                    <td class="center"><?=$model->getCurrency($model->currency)->currency?></td>
                </tr>
                <tr>
                    <td>Bank Name</td>
                    <td class="center"><?=$model->bank_name?></td>
                </tr>
                <tr>
                    <td>Recepient Name</td>
                    <td class="center"><?=$model->recepient_name?></td>
                </tr>
                <tr>
                    <td>Bank Account</td>
                    <td class="center"><?=$model->bank_account?></td>
                </tr>
                <tr>
                    <td>Bank Branch</td>
                    <td class="center"><?=$model->bank_branch?></td>
                </tr>
                <tr>
                    <td>Swiftcode</td>
                    <td class="center"><?=$model->swiftcode?></td>
                </tr>
                <tr>
                    <td>Additional Detail</td>
                    <td class="center"><?=$model->additional_detail?></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td class="center">
                        <?php 
                        if ($model->status == Cashwithdraw::STATUS_COMPLETED){
                            $check = 'checked';
                            $act = 'close';
                        }else{
                            $check = '';
                            $act = 'opent';
                        }
                        echo  '<input name="publish" class="ace ace-switch ace-switch-4 btn-empty" '.$check.' type="checkbox" act="'.$act.'" value="'.$model->id.'" /><span class="lbl"></span>';
                        ?>
                    </td>
                </tr>
                </tr>
            </tbody>
        </table>
    </div>    
</div>

<?= $this->registerJs('
$("input[name=publish]").change(function(event, state) {
    var id = $(this).val();
    var act = $(this).attr("act");
    $.ajax({
        type: "POST", 
        url:"' . Yii::$app->urlManager->createUrl(["cashwithdraw/publish"]) . '", 
        data: {id:id,act:act}, 
        success: function (data) {
        }
    });
    
});
') ?>
