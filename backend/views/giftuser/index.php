<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\GiftUser;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gifts User';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <div class="page-header">
        <h1>
            <?= Html::encode($this->title) ?>
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'user_id',
                                'label' => 'Username',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return $data->user->username;
                                }
                            ],
                            [
                                'attribute' => 'id_gift',
                                'label' => 'Gift',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return '<img width="80" src="'.Yii::$app->params['site_url_front_end'].'uploads/luckywheel/'.$data->gift->thumbnail.'" class="img-responsive"> ';
                                }
                            ],
                            [
                                'attribute' => 'created_at',
                                'label' => 'Time',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return date('d-m-Y - H:i', $data['created_at']);
                                }
                            ],
                            [
                                'attribute' => 'status',
                                'label' => 'Status',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function($data) {
                                    if ($data['status'] == GiftUser::STATUS_ACTIVE){
                                        $check = 'checked';
                                        $act = 'close';
                                    } else {
                                        $check = '';
                                        $act = 'opent';
                                    }
                                    return '<input name="status" class="ace ace-switch ace-switch-4 btn-empty" act='.$act.' '.$check.' type="checkbox" value='.$data["id"].' /><span class="lbl"></span>';
                                }
                            ],
                        ],
                    ]); ?>
                </div>    
            </div><!-- /.row -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>

<?= $this->registerJs('
$("input[name=status]").change(function(event, state) {
    var id = $(this).val();
    var act = $(this).attr("act");
    $.ajax({
        type: "POST", 
        url:"' . Yii::$app->urlManager->createUrl(["giftuser/status"]) . '", 
        data: {id:id,act:act}, 
        success: function (data) {
        }
    });    
});
') ?>