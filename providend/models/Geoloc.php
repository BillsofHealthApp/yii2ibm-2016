<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "geoloc".
 *
 * @property integer $geoloc_id
 * @property string $address
 * @property double $latitude
 * @property double $longitude
 */
class Geoloc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'geoloc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['geoloc_id', 'address', 'latitude', 'longitude'], 'required'],
            [['geoloc_id'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'geoloc_id' => 'Geoloc ID',
            'address' => 'Address',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }
}
