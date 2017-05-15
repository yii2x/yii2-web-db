<?php

namespace yii2x\web\db\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property integer $id
 * @property string $scheme
 * @property string $uri
 * @property string $auth_item
 * @property integer $is_guest
 * @property integer $layout_id
 * @property integer $html_block_id
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Request extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_guest', 'layout_id', 'html_block_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['scheme'], 'string', 'max' => 45],
            [['uri'], 'string', 'max' => 1000],
            [['auth_item'], 'string', 'max' => 64],
            [['uri', 'layout_id', 'is_guest'], 'unique', 'targetAttribute' => ['uri', 'layout_id', 'is_guest'], 'message' => 'The combination of Uri, Is Guest and Layout ID has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'scheme' => 'Scheme',
            'uri' => 'Uri',
            'auth_item' => 'Auth Item',
            'is_guest' => 'Is Guest',
            'layout_id' => 'Layout ID',
            'html_block_id' => 'Html Block ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @inheritdoc
     * @return RequestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RequestQuery(get_called_class());
    }
}
