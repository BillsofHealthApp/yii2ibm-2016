<?php

namespace providend\models;

use Yii;

/**
 * This is the model class for table "provider_control".
 *
 * @property integer $pcontrol_id
 * @property integer $prov_id
 * @property integer $login
 * @property integer $profile
 * @property integer $business
 * @property integer $prices
 */
class ProviderControl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'provider_control';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prov_id'], 'required'],
            [['prov_id', 'login', 'profile', 'business', 'prices'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pcontrol_id' => 'Pcontrol ID',
            'prov_id' => 'Prov ID',
            'login' => 'Login',
            'profile' => 'Profile',
            'business' => 'Business',
            'prices' => 'Prices',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProviders()
    {
        return $this->hasMany(Providers::className(), ['id' => 'prov_id']);
    }
}
