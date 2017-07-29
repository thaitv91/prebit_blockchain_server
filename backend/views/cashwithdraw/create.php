<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Cashwithdraw */

$this->title = 'Create Cashwithdraw';
$this->params['breadcrumbs'][] = ['label' => 'Cashwithdraws', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cashwithdraw-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
