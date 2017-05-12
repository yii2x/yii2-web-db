<?php

namespace yii2x\web\db\models;

use Yii;
use yii2x\common\behaviors\JsonFieldBehavior;
use yii2x\common\behaviors\GuestViewOnlyBehavior;

/**
 * This is the model class for table "asset_bundle".
 *
 * @property integer $id
 * @property integer $account_id
 * @property string $alias
 * @property string $name
 * @property string $sourcePath
 * @property string $basePath
 * @property string $baseUrl
 * @property string $config
 * @property string $cssOptions
 * @property string $jsOptions
 * @property string $publishOptions
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class AssetBundle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asset_bundle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'created_by', 'updated_by'], 'integer'],
            [['sourcePath', 'basePath', 'baseUrl', 'config', 'cssOptions', 'jsOptions', 'publishOptions'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['alias'], 'string', 'max' => 45],
            [['name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_id' => 'Account ID',
            'alias' => 'Alias',
            'name' => 'Name',
            'sourcePath' => 'Source Path',
            'basePath' => 'Base Path',
            'baseUrl' => 'Base Url',
            'config' => 'Config',
            'cssOptions' => 'Css Options',
            'jsOptions' => 'Js Options',
            'publishOptions' => 'Publish Options',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
    public function behaviors()
    {
        return [                              
            [
                'class' => JsonFieldBehavior::className(),
                'attributes' => ['config']
            ],
            [
                'class' => GuestViewOnlyBehavior::className(),
                'attributes' => ['name']
            ]            
        ];
    } 
    /**
     * @inheritdoc
     * @return AssetBundleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssetBundleQuery(get_called_class());
    }
}
