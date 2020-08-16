<?php
/* @var $this yii\web\View */

use \yii\helpers\Html;

$this->title = 'Экспорт | ' . Yii::$app->name;
?>

<div class="row">
    <div class="col-md-12">
        <div class="export__wrapper" style="margin-top: 50px;">
            <div class="export__text-item green">
                <div class="export__item">
                    <i class="export-icon xls-green-icon"></i>
                    <?= Html::a('Экспортировать общий список участников и организаторов в xls', ['index', 'export' => true])?>
                </div>
                <div class="export__item">
                    <i class="export-icon xls-green-icon"></i>
                    <?= Html::a('Экспортировать список команд с номинациями в xls', ['index', 'team_nomination' => true])?>
                </div>
            </div>
        </div>
    </div>
</div>
