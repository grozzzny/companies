<?php
namespace grozzzny\companies\models;

use grozzzny\base_module\BaseModel;
use Yii;
use yii\data\BaseDataProvider;
use yii\db\ActiveQuery;

class Company extends BaseModel
{
    const PRIMARY_MODEL = true;

    const CACHE_KEY = 'gr_companies';

    const TITLE = 'Companies';
    const SLUG = 'companies';

    const SUBMENU_PHOTOS = false;
    const SUBMENU_FILES = false;
    const ORDER_NUM = true;

    public static function tableName()
    {
        return '{{%gr_companies}}';
    }

    public function rules()
    {
        return [
            ['id', 'number', 'integerOnly' => true],
            [['name'], 'string'],
            ['image_file', 'image'],
            ['phone','match', 'pattern' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/'],
            [['email'], 'email'],
            [['site'], 'url'],
            [['description'], 'safe'],
            ['status', 'default', 'value' => self::STATUS_ON],
            [['order_num'], 'integer'],
            [['name'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gr', 'ID'),
            'name' => Yii::t('gr', 'Name company'),
            'phone' => Yii::t('gr', 'Phone'),
            'email' => Yii::t('gr', 'Email'),
            'image_file' => Yii::t('gr', 'Image'),
            'site' => Yii::t('gr', 'Site'),
            'description' => Yii::t('gr', 'Description'),
            'status' => Yii::t('gr', 'Status'),
            'order_num' => Yii::t('gr', 'Sort Index'),
        ];
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'category_id'])
            ->viaTable('gr_catalog_relations_categories_items', ['item_id' => 'id']);
    }

    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('gr_catalog_relations_categories_items', ['item_id' => 'id']);
    }


    public static function queryFilter(ActiveQuery &$query, $get)
    {
        if(!empty($get['text'])){
            $query->andFilterWhere(['LIKE', 'name', $get['text']]);
        }
    }

    public static function querySort(BaseDataProvider &$provider)
    {
        $sort = [];

        $attributes = [
            'id',
            'name',
            'status',
            'order_num'
        ];

        if(self::ORDER_NUM){
            $sort = $sort + ['defaultOrder' => ['order_num' => SORT_DESC]];
            $attributes = $attributes + ['order_num'];
        }

        $sort = $sort + ['attributes' => $attributes];

        $provider->setSort($sort);
    }

}
