<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\states */

$this->title = 'Update States: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'States', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="page-content">
    <div class="page-header">
        <h1>
            Update State
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                <?=$model->name;?>
            </small>
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
        <?= $this->render('_form', [
	        'model' => $model,
	        'country'=> $country,
	    ]) ?>
        </div>
    </div>    
</div>   