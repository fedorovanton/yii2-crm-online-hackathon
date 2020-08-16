<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 11:31
 */

/**
 * Вьюха: Авторизация для участника
 *
 * @var $this \yii\web\View
 * @var $action string
 */

use \yii\helpers\Html;
use \yii\widgets\ActiveForm;

$this->title = 'Авторизация участника | ' . Yii::$app->name;

?>

<?php /*<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(['action' => $action]); ?>

        <div class="input">
            <?php if ($action == '/profile/sign-in-captain'): ?>
                <label for="">Для того, чтобы выбрать приоритеты номинаций введите номер телефона капитана команды</label>
            <?php else: ?>
                <label for="">Введите номер телефона</label>
            <?php endif; ?>
            <?= Html::input('text', 'phone', null, ['placeholder' => '89991234567']);  ?>
        </div>

        <div class="to-right">
            <?= Html::submitButton('<span class="plus-button-icon"></span><span>Получить код</span>', ['class' => 'members-add-button']) ?>
        </div>

        <?php echo $this->render('_partial-tech-info') ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>*/?>

<div class="row">
    <div class="col-md-12">
        <div class="anketa-success__wrapper">

            <div class="anketa-success__icon">
                <?= Html::img(Yii::getAlias('@frontendURL').'/img/icons/checked-icon.png')?>
            </div>
            <div class="anketa-success__title">Выбор приоритетов окончен!</div>

        </div>
    </div>

</div>