<?php

namespace yii2x\web\db\models;

use Yii;

/**
 * This is the model class for table "uri_route".
 *
 * @property integer $id
 * @property string $uri
 * @property string $auth_item
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class UriRoute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uri_route';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['uri'], 'string', 'max' => 1000],
            [['auth_item'], 'string', 'max' => 64],
            [['uri'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uri' => 'Uri',
            'auth_item' => 'Auth Item',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @inheritdoc
     * @return UriRouteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UriRouteQuery(get_called_class());
    }
}
