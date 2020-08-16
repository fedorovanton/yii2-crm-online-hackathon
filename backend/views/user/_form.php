<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \backend\models\User\User;

/* @var $this yii\web\View */
/* @var $model backend\models\User\User */
/* @var $form yii\widgets\ActiveForm */

if (empty($model->status)) {
    $model->status = User::STATUS_ACTIVE;
}

if ($model->isNewRecord) {
    $submitButtonText = 'Добвить';
    $roleOptionDisabled = false;
} else {
    $submitButtonText = 'Сохранить';
    $roleOptionDisabled = true;
}

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->dropDownList(User::getStatusArray(),['prompt' => 'Выберите статус...']) ?>

    <?= $form->field($model, 'role')->dropDownList(User::getRoleArray(), ['prompt' => 'Выберите роль...', 'disabled' => $roleOptionDisabled]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_temp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

    <?php //echo$form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'verification_token')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'created')->textInput() ?>

    <?php //echo $form->field($model, 'updated')->textInput() ?>

    <div class="form-group">
            <?= Html::submitButton($submitButtonText, ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
