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

    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <td>Username</td>
                        <td>
                            <?=Html::a($model->user->username, '/user/view/'.$model->user_id);?>
                        </td>
                    </tr>  
                    <tr>
                        <td>Amount</td>
                        <td><?=$model->amount?> Btc</td>
                    </tr> 
                    <tr>
                        <td>Created_at</td>
                        <td><?=date('d/m/Y H:i', $model->created_at);?> Btc</td>
                    </tr> 
                    <tr>
                        <td>Min day</td>
                        <td><?=date('d/m/Y H:i', $model->min_days * 86400 + $model->created_at );?></td>
                    </tr> 
                    <tr>
                        <td>Max days</td>
                        <td><?=date('d/m/Y H:i', $model->max_days * 86400 + $model->created_at );?></td>
                    </tr> 
                    <tr>
                        <td>Status</td>
                        <td>
                            <?php 
                            $minday = ($model->min_days * 86400) + $model->created_at;
                            $maxday = ($model->max_days * 86400) + $model->created_at;
                            if($minday > time() && $maxday > time()){
                                $status = '<span class="label label-sm label-success">On-going</span>';
                            } 
                            if($minday <= time() && $maxday > time()) {
                                $status = '<span class="label label-sm label-warning">Maturity</span>';
                            } 
                            if ( $minday < time() && $maxday < time() ) {
                                $status = '<span class="label label-sm label-danger">Completed</span>';
                            }
                            echo  $status;
                            ?>
                        </td>
                    </tr>
                    </tr>
                </tbody>
            </table>
            <div class="clear-fix"></div>
        </div>

        <div class="col-md-6 col-ms-12 col-xs-12">
            <table class="table table-striped table-bordered">
                <thead> 
                    <tr> 
                        <th>Profit withdrawal time</th> 
                        <th>Amount</th>
                    </tr> 
                </thead>
                <tbody>
                    <?php if(!empty($sh_withdraw)){
                        $withdraw = 0;
                        foreach ($sh_withdraw as $key => $sh_withdraw) {
                            $withdraw += $sh_withdraw->amount;
                    ?>
                        <tr>
                            <td><?=date('d/m/Y H:i', $sh_withdraw->created_at)?></td>
                            <td>
                                <?=number_format($sh_withdraw->amount, 8);?>
                            </td>
                        </tr>
                    <?php
                        }
                        echo '<tr><td><b>Total withdraw</b></td><td><b>'.number_format($withdraw, 8).' Btc</b></td></tr>';
                    }else{ echo '<tr><td colspan="2">no withdrawal</td></tr>';}?>
                      
                </tbody>
            </table>
            <div class="clear-fix"></div>
        </div>   

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
