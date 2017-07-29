<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use common\models\Cashwithdraw;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ticket transfer';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content">
    <div class="page-header">
        <h1>
            Tables
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Static &amp; Dynamic Tables
            </small>
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?php $form = ActiveForm::begin(['layout' => 'inline', 'method'=>'GET']); ?>
                <?= $form->field($ticketFilter, 'username', ['template' => '{input}{hint}{error}'])->textInput(['maxlength' => true, 'placeholder' => 'User name', 'class' => 'form-control'])->label(false) ?>
                <?= $form->field($ticketFilter, 'fromday', ['template' => '<div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span></div>{hint}{error}'])->textInput(['placeholder' => 'From', 'class' => 'form-control date-picker', 'data-date-format'=>'dd-mm-yyyy'])->label(false) ?>
                <?= $form->field($ticketFilter, 'today', ['template' => '<div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span></div>{hint}{error}'])->textInput(['placeholder' => 'To', 'class' => 'form-control date-picker', 'data-date-format'=>'dd-mm-yyyy'])->label(false) ?>
                <?= Html::submitButton('<i class="ace-icon fa fa-filter"></i><span class="bigger-110">Filter!</span>', ['class' => 'btn btn-sm btn-info']) ?>
                <?php ActiveForm::end(); ?>
                <h2></h2>
            </div>
            <div class="col-xs-12">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => "<p>Showing {begin} to {end} of {count} entries</p>",
                    'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'User',
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'text-center hidden-480'],
                            'contentOptions' => ['class' => 'text-center hidden-480'],
                            'value' => function($data) {
                                return $data->getUser($data->user_id)->username;
                            }
                        ],
                        [
                            'attribute' => 'amount',
                            'label' => 'Ticket',
                            'format' => 'raw',
                            'value' => function($data) {
                                return $data->amount.' Ticket';
                            }
                        ],
                        [
                            'attribute' => 'bitcoin',
                            'label' => 'Bitcoin',
                            'format' => 'raw',
                            'value' => function($data) {
                                return $data->bitcoin.' BTC';
                            }
                        ],
                        [
                            'attribute' => 'created_at',
                            'label' => 'Created at',
                            'format' => 'raw',
                            'value' => function($data) {
                                return date('H:s d/m/Y', $data->created_at);
                            }
                        ],
                        
                    ],
                    'tableOptions' => [ 'id' => 'simple-table', 'class' => 'table table-striped table-bordered table-hover'],
                ]); ?>
                </div><!-- /.span -->
            </div><!-- /.row -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>

