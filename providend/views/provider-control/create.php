<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model providend\models\ProviderControl */

$this->title = 'Create Provider Control';
$this->params['breadcrumbs'][] = ['label' => 'Provider Controls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provider-control-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
