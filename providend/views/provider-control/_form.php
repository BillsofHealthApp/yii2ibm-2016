<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model providend\models\ProviderControl */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="provider-control-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'prov_id')->textInput() ?>

    <?= $form->field($model, 'login')->textInput() ?>

    <?= $form->field($model, 'profile')->textInput() ?>

    <?= $form->field($model, 'business')->textInput() ?>

    <?= $form->field($model, 'prices')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
