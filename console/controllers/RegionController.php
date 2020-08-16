<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 27/09/2019
 * Time: 15:13
 */

namespace console\controllers;


use common\models\Region\BaseRegion;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use Yii;

class RegionController extends Controller
{
    /**
     * Импорт регионов
     * @command php yii region/import
     * @return int
     */
    public function actionImport()
    {
        $this->stdout("Начало: ".date('Y-m-d H:i:s')." \n", Console::FG_BLUE);
        $file_path = Yii::getAlias('@backend').'/web/import_files/Список_субъектов_для_региона_проживания.txt';
        $handle = @fopen($file_path, "r");
        if ($handle) {

            $this->stdout("Запуск импорта регионов\n", Console::FG_BLUE);

            while (($buffer = fgets($handle, 4096)) !== false) {
                $region = new BaseRegion();
                $region->name = trim($buffer);
                $region->updated = date('Y-m-d H:i:s');
                $region->created = date('Y-m-d H:i:s');
                $region->save();
            }
            if (!feof($handle)) {
                $this->stdout("Ошибка: fgets() неожиданно потерпел неудачу\n", Console::FG_RED);
                return ExitCode::UNSPECIFIED_ERROR;
            }
            fclose($handle);
        }

        $this->stdout("Конец: ".date('Y-m-d H:i:s')." \n", Console::FG_BLUE);
        return ExitCode::OK;
    }

}