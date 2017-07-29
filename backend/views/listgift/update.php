<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ListGift */

$this->title = 'Update List Gift: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'List Gifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="page-content">
    <div class="page-header">
        <h1>
            List Gift
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Update Gift
            </small>
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
        <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>
        </div>
    </div>    
</div> 