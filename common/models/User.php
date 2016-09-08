<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const ROLE_USER = 10;
    
    public $authRole;
    public $pass;
    public $pass_repeat;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
       return [
        [
            'class' => TimestampBehavior::className(),
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => 'updated_at',
            ],
           /* [
            'class' => BlameableBehavior::className(),
            'createdByAttribute' => 'created_by',
            'updatedByAttribute' => 'LastUpdatedBy',
            ],*/
            ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['name', 'string', 'max' => 255],
            ['phone', 'string', 'max' => 15],
            ['role', 'default', 'value' => self::ROLE_USER],
            ['email','email'],
            ['email','unique'],
            ['email','required','on'=>['insert','update','newOrder']],
            ['pass','required','on'=>['insert','update']],
        		
            ['role', 'in', 'range' => [self::ROLE_USER]],
            [['authRole','pass','pass_repeat'],'safe'],
            ['pass','compare','on'=>['insert','update']],
        ];
    }
    
    public function attributeLabels(){
    	return[
    		'name'=>Yii::t('app','Name'),
    		'username'=>Yii::t('app','Username'),
    		'email'=>Yii::t('app','Email'),
    		'phone'=>Yii::t('app','Phone'),
    		'authRole'=>Yii::t('app','Auth Role'),
    			
    	];
    		
    	
    }/**/
    
    public function beforeSave($insert){
    	
    	if ($insert){
    		$this->setPassword($this->pass);}else{
    		// Обновляем пароль для пользователя
    		if ($this->pass)
    		$this->setPassword($this->pass);
    		}
    	
    	return parent::beforeSave($insert);
    }/**/
    
    
    public function afterSave($insert,$changedAttributes){
 		$auth = Yii::$app->authManager;
    	if ($insert){
    	$this->setPassword($this->pass);
        $authorRole = $auth->getRole(($this->authRole)?$this->authRole:'клиент');
        $auth->assign($authorRole, $this->getId());
    	} else{
    		// Обновляем роль для пользователя
    		if ($this->authRole && $this->scenario == 'update'){
    		$auth->revoke($this->userRole, $this->getId());
    		$auth->assign($auth->getRole($this->authRole), $this->getId());
    		
    		}
    	}
       
    	return parent::afterSave($insert,$changedAttributes);
    	
    }/**/
    
    public function afterDelete(){
    	$orders = \common\models\Order::deleteAll('customer_id = :customer_id',
    			[':customer_id'=>$this->id]);
    	$auth = Yii::$app->authManager;
    //	$authorRole = $auth->getRole($this->authRole);
 
    	
    	
    	
    	return parent::afterDelete();
    }/**/
    
    public function getUserRole(){
     $roleArray =	Yii::$app->authManager->getRolesByUser($this->id);
     foreach ($roleArray as $role)
     	$userRole = $role;
     return $role;
    }/**/

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
    
    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
    	return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }
    
    /**
     * Finds user by phone
     *
     * @param string $phone
     * @return static|null
     */
    public static function findByPhone($phone)
    {
    	return static::findOne(['phone' => $phone, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}/*end of Model*/
