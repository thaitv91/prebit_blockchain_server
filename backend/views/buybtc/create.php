<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BuyBtc */

$this->title = 'Create Buy Btc';
$this->params['breadcrumbs'][] = ['label' => 'Buy Btcs', 'url' => ['index']];
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
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>
    </div>    
</div>    
