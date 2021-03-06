<?php
namespace grozzzny\companies\models;

//use grozzzny\base_module\BaseModel;
use Yii;
use yii\data\BaseDataProvider;
use yii\easyii2\components\ActiveQuery;
use yii\easyii2\components\FastModel;
use yii\easyii2\components\FastModelInterface;
use yii\easyii2\helpers\Image;
use yii\web\User;

/**
 * Company ActiveRecord model.
 *
 * Database fields:
 * @property integer $id
 * @property string  $name
 * @property string  $contry
 * @property string  $city
 * @property string  $address
 * @property string  $phone
 * @property string  $email
 * @property string  $image_file
 * @property string  $site
 * @property string  $description
 * @property integer $status
 * @property integer $order_num
 *
 * Defined relations:
 * @property User[]  $users
 * @property User[]  $admins
 *
 */
class Company extends FastModel implements FastModelInterface
{
    const PRIMARY_MODEL = true;

    const CACHE_KEY = 'gr_companies';

    const TITLE = 'Companies';
    const SLUG = 'companies';

    const SUBMENU_PHOTOS = false;
    const SUBMENU_FILES = false;
    const ORDER_NUM = true;

    private $_users;
    private $_admins;

    public static function tableName()
    {
        return '{{%gr_companies}}';
    }

    public function rules()
    {
        return [
            ['id', 'number', 'integerOnly' => true],
            [['name', 'country', 'city', 'address'], 'string'],
            ['image_file', 'image'],
            ['phone','match', 'pattern' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/'],
            [['email'], 'email'],
            [['site'], 'string'],
            [['description', 'users', 'admins'], 'safe'],
            ['status', 'default', 'value' => self::STATUS_OFF],
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
            'image_file' => Yii::t('gr', 'Logo'),
            'site' => Yii::t('gr', 'Site'),
            'description' => Yii::t('gr', 'Description'),
            'status' => Yii::t('gr', 'Status'),
            'order_num' => Yii::t('gr', 'Sort Index'),
            'users' => Yii::t('gr', 'Users'),
            'admins' => Yii::t('gr', 'Admins'),
            'country' => Yii::t('gr', 'Country'),
            'city' => Yii::t('gr', 'City'),
            'address' => Yii::t('gr', 'Address')
        ];
    }

    public static function getNameModel()
    {
        // TODO: Implement getNameModel() method.
        return Yii::t('app', 'Company');
    }

    public static function getSlugModel()
    {
        // TODO: Implement getNameModel() method.
        return 'companies';
    }

    public function getUsers()
    {
        return $this->hasMany(Yii::$app->user->identityClass, ['id' => 'user_id'])
            ->viaTable('gr_relations_companies_users', ['company_id' => 'id']);
    }

    public function setUsers($values)
    {
        $this->_users = $values;
    }


    public function getAdmins()
    {
        return $this->hasMany(Yii::$app->user->identityClass, ['id' => 'user_id'])
            ->viaTable('gr_relations_companies_admins', ['company_id' => 'id']);
    }

    public function setAdmins($values)
    {
        $this->_admins = $values;
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


    public function afterSave($insert, $changedAttributes)
    {
        $model = Yii::createObject(Yii::$app->user->identityClass);

        if(!empty($this->_users)){
            foreach ($this->users as $user) $this->unlink('users', $user, true);
            foreach ($model->findAll($this->_users) as $user) $this->link('users', $user);
        }

        if(!empty($this->_admins)) {
            foreach ($this->admins as $user) $this->unlink('admins', $user, true);
            foreach ($model->findAll($this->_admins) as $user) $this->link('admins', $user);
        }

        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    public function getImage($width = null, $height = null, $crop = true)
    {
        $image = empty($this->image_file) ? Yii::$app->params['nophoto'] : $this->image_file;
        return Image::thumb($image, $width, $height, $crop);
    }

}
