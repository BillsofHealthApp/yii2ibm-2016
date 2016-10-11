<?php

use yii\grid\GridView;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use kartik\widgets\SideNav;
use kartik\helpers\Html;
use yii\helpers\Url;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AdminControlSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>



<?php  
$this->title = 'Provider Controls'. $model->id;
$this->params['breadcrumbs'][] = $this->title;

foreach ($dataProvider->models as $model_panel) {
?>
    
    <div class="col-xs-12, col-sm-4"> 
    <?php 
    echo Html::panel(
    [
        'postBody' => Html::listGroup([
        [
            'content' => 
                '<table align="center">
                <tr><td align="center">'.Html::img('@web/images/'.$model_panel->login_pic).'</td></tr>
                <tr><td align="center">'.'<h4>'.$model_panel->login.'</h4></td></tr>
                </table>',
            'url' => Url::to([$model_panel->login]),
        ],
        ], [], 'ul', 'li'),
    ]
    );    
    ?>
    </div>

    <div class="col-xs-12, col-sm-4"> 
    <?php 
    echo Html::panel(
    [
        'postBody' => Html::listGroup([
        [
            'content' => 
                '<table align="center">
                <tr><td align="center">'.Html::img('@web/images/'.$model_panel->profile_pic).'</td></tr>
                <tr><td align="center">'.'<h4>'.$model_panel->profile.'</h4></td></tr>
                </table>',
            'url' => Url::to([$model_panel->profile]),
        ],
        ], [], 'ul', 'li'),
    ]
    );    
    ?>
    </div>

    <div class="col-xs-12, col-sm-4"> 
    <?php 
    echo Html::panel(
    [
        'postBody' => Html::listGroup([
        [
            'content' => 
                '<table align="center">
                <tr><td align="center">'.Html::img('@web/images/'.$model_panel->business_pic).'</td></tr>
                <tr><td align="center">'.'<h4>'.$model_panel->business.'</h4></td></tr>
                </table>',
            'url' => Url::to([$model_panel->business]),
        ],
        ], [], 'ul', 'li'),
    ]
    );    
    ?>
    </div>

    <div class="col-xs-12, col-sm-4"> 
    <?php 
    echo Html::panel(
    [
        'postBody' => Html::listGroup([
        [
            'content' => 
                '<table align="center">
                <tr><td align="center">'.Html::img('@web/images/'.$model_panel->prices_pic).'</td></tr>
                <tr><td align="center">'.'<h4>'.$model_panel->prices.'</h4></td></tr>
                </table>',
            'url' => Url::to([$model_panel->prices]),
        ],
        ], [], 'ul', 'li'),
    ]
    );    
    ?>
    </div>



<?php
}
?>

