<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use providend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Bill$OfHealth Providers',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse',
        ],
    ]);
    
    if (Yii::$app->user->isGuest) {
        $menuItems = [
            ['label' => '<span class="glyphicon glyphicon-home"></span> Home', 'url' => ['/site/index']],
            ['label' => '<span class="glyphicon glyphicon-book"></span> About', 'url' => ['/about-us/index']],
            ['label' => '<span class="glyphicon glyphicon-envelope"></span> Contact', 'url' => ['/site/contact']],
            ['label' => '<span class="glyphicon glyphicon-education"></span> FAQ', 'url' => ['/faq-search/index']],
            ['label' => '<span class="glyphicon glyphicon-user"></span> Signup', 'url' => ['/site/signup']],
            ['label' => '<span class="glyphicon glyphicon-modal-window"></span> Login', 'url' => ['/site/login']],
        ];
    } 
    else {
        $menuItems[] = ['label' => '<span class="glyphicon glyphicon-dashboard"></span> Dashboard', 'url' => ['/provider/index']];
        $menuItems[] = [
            'label' => '<span class="glyphicon glyphicon-off"></span> Logout (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];    
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ])?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Bill$OfHealth <?= date('Y') ?> All Rights Reserved</p>
        <p class="pull-right">Saving your wealth with Bill$OfHealth</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
