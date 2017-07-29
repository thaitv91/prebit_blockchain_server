<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LevelSetting */

$this->title = 'Update Level Setting: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Level Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="level-setting-update">

    <h1><?= Html::encode($this->title) ?></h1>
	
	<?php if(Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger" role="alert">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
