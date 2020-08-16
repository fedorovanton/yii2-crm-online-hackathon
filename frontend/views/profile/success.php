<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 11:31
 */

use \yii\helpers\Html;

/**
 * Вьюха: Анкета успешно отправлена
 */
?>

<div class="row">
    <div class="anketa-success__wrapper">
        <div class="anketa-success__icon">
            <?= Html::img(Yii::getAlias('@frontendURL').'/img/icons/checked-icon.png')?>
        </div>
        <div class="anketa-success__title">Ваша заявка успешно отправлена</div>

        <?php echo $this->render('_partial-tech-info') ?>

    </div>
</div>