<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CharityProgram */

$this->title = 'Update Charity Program: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Charity Programs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="page-content">
	<div class="charity-program-update">

	    <h1><?= Html::encode($this->title) ?></h1>

	    <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>

	</div>
</div>