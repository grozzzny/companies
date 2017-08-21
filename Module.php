<?php
namespace grozzzny\companies;

use grozzzny\companies\assets\ModuleAsset;
use Yii;

class Module extends \grozzzny\base_module\Module
{
    public $settings = [
    ];

    public function init()
    {
        Yii::$app->view->theme->pathMap['@grozzzny/base_module/views'] = '@grozzzny/companies/views';

        parent::init(); // TODO: Change the autogenerated stub
    }

    public static function registerAssets()
    {
        parent::registerAssets(); // TODO: Change the autogenerated stub

        ModuleAsset::register(Yii::$app->view);
    }
}