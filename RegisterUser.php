<?php

namespace app\models;

use yii\base\Model;

class RegisterUser extends Model
{
    const TYPE_JURIDICALLY = 'juridically';
    const TYPE_INDIVIDUAL  = 'individual';

    public $type;
    public $userName;
    public $email;
    public $taxId;
    public $orgName;
    public $private;

    public function rules()
    {
        return [
            [ [ 'type', 'userName', 'email' ], 'required' ],
            [ [ 'type', 'userName', 'taxId', 'orgName' ], 'trim' ],

            [
                'taxId',
                'required',
                'when' => function () {
                    return $this->type == self::TYPE_JURIDICALLY
                        || ($this->type == self::TYPE_INDIVIDUAL && $this->private);
                },
            ],

            [
                'orgName',
                'required',
                'when' => function () {
                    return $this->type == self::TYPE_JURIDICALLY;
                },
            ],

            [ 'type', 'in', 'range' => [ self::TYPE_INDIVIDUAL, self::TYPE_JURIDICALLY ] ],

            [ 'userName', 'string', 'min' => 3 ],
            [ 'email', 'email' ],
            [ 'taxId', 'match', 'pattern' => '/^\d{12}$/' ],
            [ 'private', 'boolean' ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'type'     => 'Тип',
            'userName' => 'ФИО',
            'email'    => 'Email адрес',
            'taxId'    => 'ИНН',
            'orgName'  => 'Название организации',
            'private'  => 'ИП',
        ];
    }
}
