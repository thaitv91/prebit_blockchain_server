<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\BonusHistory;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Direct Bonus - PreBit';
?>
 <div class="top-dashboard no-margin-bottom-xs">
    <h2 class="title-general">DIRECT BONUS</h2>                  
</div>
<div class="end-send-help">
    <div class="">
        <div class="no-margin widget">
            <div class="widget-content">                    
                <div class="table-responsive">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => "<p>Showing {begin} to {end} of {count} entries</p>",
                        'layout' => "<div>{pager}</div>\n{items}\n<div class='col-md-12'>{summary}</div>\n<div class='col-md-12'>{pager}</div>",
                        'columns' => [
                            [
                                'label' => 'Time',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'tr-dark'],
                                'contentOptions' => ['class' => 'text-left'],
                                'value' => function($data) {
                                    return date('d/m/Y H:i',$data->created_at);
                                }
                            ],
                            /*[
                                'label' => 'Name',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'tr-blue-x '],
                                'value' => function($data) {
                                    $user = $data->findUserbyid($data->user_id);
                                    return  $user->fullname;
                                }
                            ],*/
                            [
                                'label' => 'Username',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'tr-dark'],
                                'value' => function($data) {
                                    $user = $data->findUserbyid($data->user_id);
                                    if ($user) {
                                        return  $user->username;
                                    }
                                }
                            ],
                            [
                                'label' => 'Bonus',
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'tr-dark'],
                                'value' => function($data) {
                                    return number_format($data->amount, 8);
                                }
                            ],
                            [
                                'headerOptions' => ['class' => 'tr-dark'],
                                'contentOptions' => ['class' => 'text-left'],
                                'label' => 'Chat',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return '<a href="#" title=""><img src="'.Yii::$app->params['site_url'].'images/chat-table.png" alt=""></a>';
                                }
                            ],
                        ],
                        'tableOptions' => [ 'id' => 'simple-table', 'class' => 'table'],
                    ]); ?>

                    
                </div>
            </div>
        </div>
    </div>
</div>