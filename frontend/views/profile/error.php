<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>

<div class="row">
    <div class="col-md-12">
        <h1><?= Html::encode($this->title) ?></h1>

        <span class="display-4"><?= nl2br(Html::encode($message)) ?></span>
    </div>
</div>