<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\states */

$this->title = 'Create States';
$this->params['breadcrumbs'][] = ['label' => 'States', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content">
    <div class="page-header">
        <h1><?=$this->title;?></h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
        <?= $this->render('_form', [
	        'model' => $model,
            'country'=> $country,
            'id' => $id,
	    ]) ?>
        </div>
    </div>    
</div>   