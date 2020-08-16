<?php

$alias = Yii::getAlias('@yii/rbac/migrations/m170907_052038_rbac_add_index_on_auth_assignment_user_id.php');
Yii::$classMap['m170907_052038_rbac_add_index_on_auth_assignment_user_id'] = $alias;

/**
 * Миграция.
 *
 * Создание индексов для таблиц RBAC "@yii/rbac/migrations".
 *
 * @link https://github.com/yiisoft/yii2/issues/9469
 */
class m190915_091845_rbac_index_add extends m170907_052038_rbac_add_index_on_auth_assignment_user_id {}