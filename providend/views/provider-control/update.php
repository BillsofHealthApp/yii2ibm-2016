<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model providend\models\ProviderControl */

$this->title = 'Update Provider Control: ' . ' ' . $model->pcontrol_id;
$this->params['breadcrumbs'][] = ['label' => 'Provider Controls', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pcontrol_id, 'url' => ['view', 'id' => $model->pcontrol_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="provider-control-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
