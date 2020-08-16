<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 24/09/2019
 * Time: 09:02
 */

use \kartik\select2\Select2;
use \yii\web\JsExpression;
use \frontend\models\MemberInfo\MemberInfo;
use \yii\helpers\Url;

/**
 * Представление для виджета поиска команд
 * @var $membersArray array
 */

$style = <<<CSS
/**
 * Скрыть непонятный квадратик, который появляется под select2
 */
.searchbar a.chosen-single {
    display: none !important;
}
CSS;
$this->registerCss($style);

?>

<!--<div class="searchbar">
    <div class="searchbar__input">
        <div></div>
        <input type="text" placeholder="Поиск по участникам...">
    </div>
</div>-->

    <div class="searchbar">
        <div class="searchbar__input">
            <div></div>
                <?php echo Select2::widget([
                    'name' => 'search',
                    'options' => ['placeholder' => 'Введите название команды...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 3,
                        'ajax' => [
                            'url' => Url::to(['team/team-list']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function (data) { return data.text; }'),
                        'templateSelection' => new JsExpression('function (data) {
                            if (data.id>0) { window.location.href = "/team/update/" + data.id }
                            return data.text; 
                        }'),
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Поиск совпадений...'; }"),
                        ],
                    ],
                ]); ?>
        </div>
    </div>
