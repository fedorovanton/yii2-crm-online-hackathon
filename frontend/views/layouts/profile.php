<?php

/**
 * Шаблон для публичной анкеты
 *
 * @var $this \yii\web\View
 * @var $content string
 */

use yii\helpers\Html;
use \frontend\assets\FrontendAsset;

FrontendAsset::register($this);

$session = Yii::$app->session;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="dark input-file-dark"></div>
<div class="anketa-public-bg">
    <?= Html::img(Yii::getAlias('@frontendURL').'/img/logo-anketa.png', ['alt' => 'anketa-public-bg', 'class' => 'anketa-public-logo'])?>
</div>
<div class="container-fluid anketa-public">

    <?php if ($session->hasFlash('alert-danger')): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <?= $session->getFlash('alert-danger') ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?= $content ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
