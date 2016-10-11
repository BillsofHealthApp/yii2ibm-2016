<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model providend\models\ProviderControl */

$this->title = $model->pcontrol_id;
$this->params['breadcrumbs'][] = ['label' => 'Provider Controls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provider-control-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->pcontrol_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->pcontrol_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'pcontrol_id',
            'prov_id',
            'login',
            'profile',
            'business',
            'prices',
        ],
    ]) ?>

</div>
