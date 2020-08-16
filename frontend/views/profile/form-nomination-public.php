<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 11:31
 */

use \frontend\forms\MemberMainPublicForm;
use \yii\web\View;
use \yii\widgets\ActiveForm;
use \frontend\models\MemberMain\MemberMain;
use \yii\helpers\Html;
use \corpsepk\DaData\SuggestionsWidget;
use \kartik\select2\Select2;
use \common\models\Nomination\BaseNomination;
use \common\components\Role;

/**
 * Вьюха: Публичная анкета
 * @var $model MemberMainPublicForm
 * @var $this \yii\web\View
 */

$this->title = 'Выбор номинаций | ' . Yii::$app->name;

// Массив номинаций
$nominationsList = BaseNomination::getNominationArray(Role::MEMBERS_MAIN);

$style = <<<CSS
/**
 * Скрыть непонятный квадратик, который появляется под select2
 */
.field-setnominationform-nomination_id_1 a.chosen-single,
.field-setnominationform-nomination_id_2 a.chosen-single,
.field-setnominationform-nomination_id_3 a.chosen-single {
    display: none !important;
}
CSS;
$this->registerCss($style);

?>

<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($model, 'member_info_id')->hiddenInput()->label(false) ?>

        <div class="input">
            <?php echo $form->field($model, 'nomination_id_1')->widget(Select2::classname(), [
                'data' => $nominationsList,
                'bsVersion' => 4,
                'options' => ['placeholder' => 'Выберите приоритет 1...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>

        <div class="input">
            <?php echo $form->field($model, 'nomination_id_2')->widget(Select2::classname(), [
                'data' => $nominationsList,
                'bsVersion' => 4,
                'options' => ['placeholder' => 'Выберите приоритет 2...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>

        <div class="input">
            <?php echo $form->field($model, 'nomination_id_3')->widget(Select2::classname(), [
                'data' => $nominationsList,
                'bsVersion' => 4,
                'options' => ['placeholder' => 'Выберите приоритет 3...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>

        <div class="to-right">
            <?= Html::submitButton('<span class="plus-button-icon"></span><span>Отправить</span>', ['class' => 'members-add-button']) ?>
        </div>

        <?php echo $this->render('_partial-tech-info') ?>

        <?php ActiveForm::end() ?>
    </div>
</div>
