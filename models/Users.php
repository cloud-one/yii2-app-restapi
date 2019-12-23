<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $user_id
 * @property int $parent_id
 * @property string $account_type
 * @property int $primary
 * @property int $active 0 = inactive, 1 = active, -1 deleted
 * @property string $access_level SuperAdmin, Admin, PowerUser, User, Basic
 * @property int $access_level_id 3 = admin, 2 = user, 1 = basic
 * @property int $acl_id DEPRACATED
 * @property string $email
 * @property string $username
 * @property string $password
 * @property int $password_reset
 * @property int $avatar
 * @property string $name_first
 * @property string $name_last
 * @property string $gender
 * @property string $contact_type
 * @property string $title
 * @property int $phone_cell
 * @property int $phone_work
 * @property int $phone_work_ext
 * @property string $daterange
 * @property string $theme
 * @property int $call_center_lead
 * @property int $dma
 * @property string|null $card_id
 * @property string $default_dashboard
 */
class Users extends \yii\db\ActiveRecord
{
    public $name;
    public $user_name;
  
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'primary', 'acl_id', 'email', 'username', 'password', 'password_reset', 'name_first', 'name_last', 'gender', 'contact_type', 'title', 'phone_cell', 'phone_work', 'phone_work_ext', 'call_center_lead'], 'required'],
            [['parent_id', 'primary', 'active', 'access_level_id', 'acl_id', 'password_reset', 'avatar', 'phone_cell', 'phone_work', 'phone_work_ext', 'call_center_lead', 'dma'], 'integer'],
            [['daterange'], 'safe'],
            [['account_type', 'access_level'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 100],
            [['username', 'password', 'name_first', 'name_last', 'contact_type'], 'string', 'max' => 50],
            [['gender'], 'string', 'max' => 1],
            [['title'], 'string', 'max' => 255],
            [['theme'], 'string', 'max' => 30],
            [['card_id'], 'string', 'max' => 128],
            [['default_dashboard'], 'string', 'max' => 40],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'parent_id' => 'Parent ID',
            'account_type' => 'Account Type',
            'primary' => 'Primary',
            'active' => 'Active',
            'access_level' => 'Access Level',
            'access_level_id' => 'Access Level ID',
            'acl_id' => 'Acl ID',
            'email' => 'Email',
            'username' => 'Username',
            'password' => 'Password',
            'password_reset' => 'Password Reset',
            'avatar' => 'Avatar',
            'name_first' => 'Name First',
            'name_last' => 'Name Last',
            'gender' => 'Gender',
            'contact_type' => 'Contact Type',
            'title' => 'Title',
            'phone_cell' => 'Phone Cell',
            'phone_work' => 'Phone Work',
            'phone_work_ext' => 'Phone Work Ext',
            'daterange' => 'Daterange',
            'theme' => 'Theme',
            'call_center_lead' => 'Call Center Lead',
            'dma' => 'Dma',
            'card_id' => 'Card ID',
            'default_dashboard' => 'Default Dashboard',
        ];
    }

    public function fields()
    {
          $fields = parent::fields();
          $fields[] = 'name';
          $fields[] = 'user_name';
          

          $this->name = $this->name_first . ' ' . $this->name_last;
          $this->user_name = $this->username;

          return $fields;
    }
}
