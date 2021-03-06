<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ListGift */

$this->title = 'Create List Gift';
$this->params['breadcrumbs'][] = ['label' => 'List Gifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <div class="page-header">
        <h1>
            List Gift
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Create List Gift
            </small>
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
        <?php if(Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>
        <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>
        </div>
    </div>    
</div>     
