<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Update Deposit Amount for User: ' . $model->user_id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = 'deposit';
?>
<div class="user-update col-md-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_update_deposit', [
        'model' => $model,
    ]) ?>

</div>
