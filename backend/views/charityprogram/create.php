<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CharityProgram */

$this->title = 'Create Charity Program';
$this->params['breadcrumbs'][] = ['label' => 'Charity Programs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content">
	<div class="charity-program-create">

	    <h1><?= Html::encode($this->title) ?></h1>

	    <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>

	</div>
</div>
