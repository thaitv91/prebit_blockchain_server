<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Countries */

$this->title = 'Update Countries: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Countries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="page-content">
    <div class="page-header">
        <h1>
            Update Cities
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
	    ]) ?>
        </div>
    </div>    
</div>   