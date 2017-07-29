<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LuckyWheel */

$this->title = 'Update Lucky Wheel: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Lucky Wheels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="page-content">
    <div class="page-header">
        <h1>
            Lucky Wheel
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Update Lucky Wheel
            </small>
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
        <?php if(Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger" role="alert">
                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>
        <?= $this->render('_form', [
	        'model' => $model,
            'listgift' => $listgift,
            'listgiftSelected' => $listgiftSelected,
	    ]) ?>
        </div>
    </div>    
</div>    

