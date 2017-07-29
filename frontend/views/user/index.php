<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Member Profile - PreBit';
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Users', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'password_hash',
            'auth_key',
            'email:email',
            // 'fullname',
            // 'slug_name',
            // 'sex',
            // 'birthday',
            // 'phone',
            // 'country_id',
            // 'state_id',
            // 'city_id',
            // 'address',
            // 'postcode',
            // 'avatart',
            // 'description:ntext',
            // 'level',
            // 'level_updated_at',
            // 'charity',
            // 'charity_updated_at',
            // 'wallet',
            // 'manager_bonus',
            // 'referral_bonus',
            // 'token',
            // 'referral_user_id',
            // 'language',
            // 'status',
            // 'publish',
            // 'passport',
            // 'identification',
            // 'selfie',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
