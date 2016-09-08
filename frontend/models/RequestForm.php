<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class RequestForm extends Model
{
    public $name;
    public $phone;
    public $email;
    public $text;
    public $type;
 

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'phone'], 'required','on'=>'common'],
            [['text'], 'required', 'on'=>['rukovMail','feedback']],
            [['email'],'email'],
            [['email'], 'required', 'on'=>'feedback'],
            [['name','text','type'],'string'],
            ['phone','match','pattern' => '/\d+/u'],
          
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
             'phone' => 'Ваш телефон',
             'text' => 'Комментарий',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}
