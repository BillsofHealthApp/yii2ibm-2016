<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model providend\models\ProviderControlSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="provider-control-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'pcontrol_id') ?>

    <?= $form->field($model, 'prov_id') ?>

    <?= $form->field($model, 'login') ?>

    <?= $form->field($model, 'profile') ?>

    <?= $form->field($model, 'business') ?>

    <?php // echo $form->field($model, 'prices') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
