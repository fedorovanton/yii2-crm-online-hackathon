<?php

use yii\helpers\Html;

/**
 * Вьюха: Заполнение анкеты основого участника
 *
 * @var $model common\models\MemberInfo\ModelMemberInfo
 * @var $this yii\web\View
 */

$this->title = 'Добавление и редактирование участника | ' . Yii::$app->name;
//$this->params['breadcrumbs'][] = ['label' => 'Model Member Infos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
