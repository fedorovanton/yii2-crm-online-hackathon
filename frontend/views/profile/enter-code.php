<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 11:31
 */

use \yii\helpers\Html;
use \yii\widgets\ActiveForm;

/**
 * Вьюха: Ввод SMS кода
 *
 * @var $phone string
 * @var $action string
 */
?>

<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(['action' => $action]); ?>

        <div class="input">
            <label for="">Введите SMS-код отправленный на номер телефона <?= Html::encode($phone) ?></label>
            <?= Html::hiddenInput('phone', $phone);  ?>
            <?= Html::input('text', 'code', null, ['placeholder' => '1234']);  ?>
        </div>

        <div class="to-right">
            <?= Html::submitButton('<span class="plus-button-icon"></span><span>Проверить</span>', ['class' => 'members-add-button']) ?>
        </div>

        <?php echo $this->render('_partial-tech-info') ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>