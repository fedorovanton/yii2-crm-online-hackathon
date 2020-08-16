<?php
/* @var $this yii\web\View */

use \yii\helpers\Html;
use  \backend\components\StatisticsHelper;
use \common\components\Role;
use \common\models\MemberManagement\BaseMemberManagement;
use \common\models\MemberGuests\BaseMemberGuests;

?>

<div class="right-part ">
    <div class="statistics__title">Люди</div>
    <div class="statistics__wrapper">
        <div class="statistics__item" data-aos="zoom-in">
            <div class="statistics__item-row">
                <div class="statistics__item-title">Всего участников и организаторов</div>
                <div class="statistics__item-icon">
                    <?= Html::img(Yii::getAlias('@backendURL').'/img/icons/stats-icon-red.png') ?>
                </div>
            </div>
            <div class="count"><?= StatisticsHelper::getAllCount() ?></div>
        </div>
        <div class="statistics__item" data-aos="fade-right" data-aos-delay="250">
            <div class="statistics__item-row">
                <div class="statistics__item-title">Финалистов региональных этапов</div>
                <div class="statistics__item-icon">
                    <?= Html::img(Yii::getAlias('@backendURL').'/img/icons/stats-icon-red.png') ?>
                </div>
            </div>
            <div class="count"><?= StatisticsHelper::getCountMemberByRole(Role::MEMBERS_MAIN) ?></div>
        </div>
        <div class="statistics__item" data-aos="fade-right" data-aos-delay="750">
            <div class="statistics__item-row">
                <div class="statistics__item-title">Участники из вузов</div>
                <div class="statistics__item-icon">
                    <?= Html::img(Yii::getAlias('@backendURL').'/img/icons/stats-icon-red.png') ?>
                </div>
            </div>
            <div class="count"><?= StatisticsHelper::getCountMemberByRole(Role::MEMBERS_UNIVERSITIES) ?></div>
        </div>
        <div class="statistics__item" data-aos="fade-right" data-aos-delay="1000">
            <div class="statistics__item-row">
                <div class="statistics__item-title">Участники школьники</div>
                <div class="statistics__item-icon">
                    <?= Html::img(Yii::getAlias('@backendURL').'/img/icons/stats-icon-red.png') ?>
                </div>
            </div>
            <div class="count"><?= StatisticsHelper::getCountMemberByRole(Role::MEMBERS_PUPILS) ?></div>
        </div>
        <div class="statistics__item" data-aos="fade-right" data-aos-delay="1250">
            <div class="statistics__item-row">
                <div class="statistics__item-title">Дирекции</div>
                <div class="statistics__item-icon">
                    <?= Html::img(Yii::getAlias('@backendURL').'/img/icons/stats-icon-red.png') ?>
                </div>
            </div>
            <div class="count"><?= StatisticsHelper::getCountManagementByStatus(BaseMemberManagement::STATUS_DIRECTORATE) ?></div>
        </div>
        <div class="statistics__item" data-aos="fade-right" data-aos-delay="1500">
            <div class="statistics__item-row">
                <div class="statistics__item-title">Организаторы</div>
                <div class="statistics__item-icon">
                    <?= Html::img(Yii::getAlias('@backendURL').'/img/icons/stats-icon-red.png') ?>
                </div>
            </div>
            <div class="count"><?= StatisticsHelper::getCountManagementByStatus(BaseMemberManagement::STATUS_ORGANIZER) ?></div>
        </div>
        <div class="statistics__item"  data-aos="fade-right" data-aos-delay="1750">
            <div class="statistics__item-row">
                <div class="statistics__item-title">Волонтеров</div>
                <div class="statistics__item-icon">
                    <?= Html::img(Yii::getAlias('@backendURL').'/img/icons/stats-icon-red.png') ?>
                </div>
            </div>
            <div class="count"><?= StatisticsHelper::getCountMemberByRole(Role::VOLUNTEERS) ?></div>
        </div>
        <div class="statistics__item" data-aos="fade-right" data-aos-delay="2000">
            <div class="statistics__item-row">
                <div class="statistics__item-title">Экспертов и жюри</div>
                <div class="statistics__item-icon">
                    <?= Html::img(Yii::getAlias('@backendURL').'/img/icons/stats-icon-red.png') ?>
                </div>
            </div>
            <div class="count"><?= StatisticsHelper::getCountMemberByRole(Role::JURY) ?></div>
        </div>
        <div class="statistics__item" data-aos="fade-right" data-aos-delay="2250">
            <div class="statistics__item-row">
                <div class="statistics__item-title">Гостей</div>
                <div class="statistics__item-icon">
                    <?= Html::img(Yii::getAlias('@backendURL').'/img/icons/stats-icon-red.png') ?>
                </div>
            </div>
            <div class="count"><?= StatisticsHelper::getCountGuestByRole(BaseMemberGuests::STATUS_GUEST) ?></div>
        </div>
        <div class="statistics__item" data-aos="fade-right" data-aos-delay="2500">
            <div class="statistics__item-row">
                <div class="statistics__item-title">Почетных гостей</div>
                <div class="statistics__item-icon">
                    <?= Html::img(Yii::getAlias('@backendURL').'/img/icons/stats-icon-red.png') ?>
                </div>
            </div>
            <div class="count"><?= StatisticsHelper::getCountGuestByRole(BaseMemberGuests::STATUS_VENERABLE_GUEST) ?></div>
        </div>
        <div class="statistics__item" data-aos="fade-right" data-aos-delay="2750">
            <div class="statistics__item-row">
                <div class="statistics__item-title">Модераторов</div>
                <div class="statistics__item-icon">
                    <?= Html::img(Yii::getAlias('@backendURL').'/img/icons/stats-icon-red.png') ?>
                </div>
            </div>
            <div class="count"><?= StatisticsHelper::getCountMemberByRole(Role::MODERATORS) ?></div>
        </div>
        <div class="statistics__item" data-aos="fade-right" data-aos-delay="2850">
            <div class="statistics__item-row">
                <div class="statistics__item-title">Пресса</div>
                <div class="statistics__item-icon">
                    <?= Html::img(Yii::getAlias('@backendURL').'/img/icons/stats-icon-red.png') ?>
                </div>
            </div>
            <div class="count"><?= StatisticsHelper::getCountMemberByRole(Role::PRESS) ?></div>
        </div>
        <div class="statistics__item" data-aos="fade-right" data-aos-delay="2950">
            <div class="statistics__item-row">
                <div class="statistics__item-title">Служба безопасности</div>
                <div class="statistics__item-icon">
                    <?= Html::img(Yii::getAlias('@backendURL').'/img/icons/stats-icon-red.png') ?>
                </div>
            </div>
            <div class="count"><?= StatisticsHelper::getCountMemberByRole(Role::SECURITY_SERVICE) ?></div>
        </div>
        <div class="statistics__item" data-aos="fade-right" data-aos-delay="2950">
            <div class="statistics__item-row">
                <div class="statistics__item-title">Технический персонал</div>
                <div class="statistics__item-icon">
                    <?= Html::img(Yii::getAlias('@backendURL').'/img/icons/stats-icon-red.png') ?>
                </div>
            </div>
            <div class="count"><?= StatisticsHelper::getCountMemberByRole(Role::TECHNICAL_STAFF) ?></div>
        </div>
    </div>
    <div class="statistics__title">Команды</div>
    <div class="statistics__wrapper">
        <div class="statistics__item" data-aos="zoom-in">
            <div class="statistics__item-row">
                <div class="statistics__item-title">Всего команд</div>
                <div class="statistics__item-icon">
                    <?= Html::img(Yii::getAlias('@backendURL').'/img/icons/stats-icon-yellow.png') ?>
                </div>
            </div>
            <div class="count"><?= StatisticsHelper::getCountTeams() ?></div>
        </div>
        <div class="statistics__item" data-aos="zoom-in" data-aos-delay="250">
            <div class="statistics__item-row">
                <div class="statistics__item-title">Команд из 1 и 2х человек</div>
                <div class="statistics__item-icon">
                    <?= Html::img(Yii::getAlias('@backendURL').'/img/icons/stats-icon-yellow.png') ?>
                </div>
            </div>
            <div class="count"><?= StatisticsHelper::getCountTeamsByNumPeople(1) + StatisticsHelper::getCountTeamsByNumPeople(2) ?></div>
        </div>
        <div class="statistics__item" data-aos="zoom-in" data-aos-delay="500">
            <div class="statistics__item-row">
                <div class="statistics__item-title">Команды из 3х человек</div>
                <div class="statistics__item-icon">
                    <?= Html::img(Yii::getAlias('@backendURL').'/img/icons/stats-icon-yellow.png') ?>
                </div>
            </div>
            <div class="count"><?= StatisticsHelper::getCountTeamsByNumPeople(3) ?></div>
        </div>
        <div class="statistics__item" data-aos="zoom-in" data-aos-delay="750">
            <div class="statistics__item-row">
                <div class="statistics__item-title">Команды из 4х человек</div>
                <div class="statistics__item-icon">
                    <?= Html::img(Yii::getAlias('@backendURL').'/img/icons/stats-icon-yellow.png') ?>
                </div>
            </div>
            <div class="count"><?= StatisticsHelper::getCountTeamsByNumPeople(4) ?></div>
        </div>
        <div class="statistics__item" data-aos="zoom-in" data-aos-delay="1000">
            <div class="statistics__item-row">
                <div class="statistics__item-title">Команды из 5ти человек</div>
                <div class="statistics__item-icon">
                    <?= Html::img(Yii::getAlias('@backendURL').'/img/icons/stats-icon-yellow.png') ?>
                </div>
            </div>
            <div class="count"><?= StatisticsHelper::getCountTeamsByNumPeople(5) ?></div>
        </div>
    </div>
    <div class="statistics__title">Номинации</div>
    <div class="statistics__wrapper">
        <div class="statistics__item" data-aos="fade-right">
            <div class="statistics__item-row">
                <div class="statistics__item-title">Номинация</div>
                <div class="statistics__item-icon">
                    <?= Html::img(Yii::getAlias('@backendURL').'/img/icons/stats-star-icon.png') ?>
                </div>
            </div>
            <div class="count-title">Количество:</div>
            <div class="count"><?= StatisticsHelper::getCountNominations() ?></div>
        </div>
    </div>
</div>
