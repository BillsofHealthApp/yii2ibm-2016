<?php

use yii\helpers\Html;
use kartik\grid\GridView;
//use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\FaqSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $form ActiveForm */

$this->title = 'F.A.Q.';
$this->params['breadcrumbs'][] = $this->title;
//$subques->subtitle = 'Enter a Question that is not in the FAQ';
?>
        


<div class="faq-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
   
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute'=>'faq_type_id',
                'value'=>'faqType.type',
            ],
            'question',
            'answer',
            //['class' => 'yii\grid\ActionColumn'],
        ],
         'responsive'=>true,
            'hover'=>true
            
    ]);
    ?>
    <?php Pjax::end();?>
</div>



<BR>
<BR>
<BR>
<BR>
<BR>
<BR>


<div class="faq-search-faqform">

    <h1><?= Html::encode('F.A.Q. submission') ?></h1>
    <h5><?= Html::encode('Enter a Question that is not in the FAQ ') ?></h5>

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model,'question') ?>
        <?= $form->field($model,'email') ?>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- faq-search-faqform -->  



