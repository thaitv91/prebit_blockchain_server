<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\LuckyWheel */

$this->title = 'Create Lucky Wheel';
$this->params['breadcrumbs'][] = ['label' => 'Lucky Wheels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <div class="page-header">
        <h1>
            Lucky Wheel
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Create Lucky Wheel
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
	    ]) ?>
        </div>
    </div>    
</div>     