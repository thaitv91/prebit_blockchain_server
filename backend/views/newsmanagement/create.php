<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Posts */

$this->title = 'Create News';
$this->params['breadcrumbs'][] = ['label' => 'Newsmanagement', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
