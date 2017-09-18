<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%show_phones}}".
 *
 * @property integer $id
 * @property integer $time
 * @property integer $user_id
 * @property string $user_ip
 */
class ShowPhone extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%show_phones}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time', 'user_id'], 'integer'],
            [['user_ip'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'time' => Yii::t('app', 'Time'),
            'user_id' => Yii::t('app', 'User ID'),
            'user_ip' => Yii::t('app', 'User Ip'),
        ];
    }/**/
    
    public function beforeValidate() {
        $this->user_id = $this->getUserID();
        $this->user_ip = $this->get_ip_address();
        $this->time = time();
        
        return parent::beforeValidate();
    }/**/


    protected function getUserID(){
      if (Yii::$app->user->isGuest){
          return 0;
      } else {
          return Yii::$app->user->id;
      }
  }/**/  
    
  protected function get_ip_address(){
      
      return Yii::$app->getRequest()->getUserIP();
     /* 
    foreach (array('HTTP_CLIENT_IP',
                   'HTTP_X_FORWARDED_FOR',
                   'HTTP_X_FORWARDED',
                   'HTTP_X_CLUSTER_CLIENT_IP',
                   'HTTP_FORWARDED_FOR',
                   'HTTP_FORWARDED',
                   'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $IPaddress){
                $IPaddress = trim($IPaddress); // Just to be safe

                if (filter_var($IPaddress,
                               FILTER_VALIDATE_IP,
                               FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)
                    !== false) {

                    return $IPaddress;
                }
            }
        }
    }
      * 
      */
}/**/
    
}/* end of model */
