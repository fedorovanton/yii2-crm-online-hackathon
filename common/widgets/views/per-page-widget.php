<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 25/09/2019
 * Time: 08:16
 */

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $perPageList array */
/** @var $pageSize integer */
?>

Количество участников на страницу:

<select class="form-control" onchange="location = this.value;" style="width: 100px;">
    <?php foreach ($perPageList as $perPageValue): ?>
        <option value="<?= Html::encode(Url::current(['per-page' => $perPageValue, 'page' => null])) ?>" <?php if ($pageSize == $perPageValue): ?> selected="selected"<?php endif; ?>>
            <?= $perPageValue ?>
        </option>
    <?php endforeach; ?>
</select>