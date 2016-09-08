<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
	public $name;
	public $username;
    public $email;
    public $phone;
    public $password;
    public $password_repeat;
    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
          //  ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 
            		'message' => Yii::t('app' , 'This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],
        	
        	['name', 'string', 'min' => 2, 'max' => 255],
        	
        	['phone', 'string', 'min' => 2, 'max' => 15],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 
            		'message' => Yii::t('app' , 'This email address has already been taken.')],

            ['password', 'required'],
            [['password','password_repeat'], 'string', 'min' => 6],
        	['password', 'compare' ],
        ];
    }/**/
    
    public function attributeLabels(){
    	return [
    	'name'=>Yii::t('app','Name'),
    	'username'=>Yii::t('app','Username'),
    	'email'=>Yii::t('app','Email'),
    	'password'=>Yii::t('app','Password'),
    	'password_repeat'=>Yii::t('app','Password Repeat'),
    	'phone'=>Yii::t('app','Phone'),
    	];
    	
    }/**/

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->name = $this->name;
            $user->username = $this->username;
            $user->email = $this->email;
            $user->phone = $this->phone;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save();
            return $user;
        }

        return null;
    }/**/
    
    public function sendEmail()
    {
    	/* @var $user User */
    	$user = User::findOne([
    			'status' => User::STATUS_ACTIVE,
    			'email' => $this->email,
    	]);
    
    	if ($user) {
    		if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
    			$user->generatePasswordResetToken();
    		}
    
    		if ($user->save()) {
    			return \Yii::$app->mailer->compose('@frontend/views/mail/signup', ['user' => $user])
    			->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
    			->setTo($this->email)
    			->setSubject(Yii::t('app','Signup'). ' ' . \Yii::$app->name)
    			->send();
    		}
    	}
    
    	return false;
    }
    
}/**/
