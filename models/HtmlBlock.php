<?php

namespace yii2x\web\db\models;

use Yii;

/**
 * This is the model class for table "html_block".
 *
 * @property integer $id
 * @property string $type
 * @property string $fileName
 * @property string $name
 * @property string $content
 * @property integer $layout
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property string $flushed_at
 * @property integer $flushed_by
 */
class HtmlBlock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'html_block';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fileName', 'content'], 'string'],
            [['layout', 'created_by', 'updated_by', 'flushed_by'], 'integer'],
            [['created_at', 'updated_at', 'flushed_at'], 'safe'],
            [['type'], 'string', 'max' => 45],
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
            'type' => 'Type',
            'fileName' => 'File Name',
            'name' => 'Name',
            'content' => 'Content',
            'layout' => 'Layout',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'flushed_at' => 'Flushed At',
            'flushed_by' => 'Flushed By',
        ];
    }

    /**
     * @inheritdoc
     * @return HtmlBlockQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HtmlBlockQuery(get_called_class());
    }
    
    public function getLayout(){
        $p = HtmlBlock::find()->where(['id' => $this->layout])->one();
        if(!empty($p->id)){
            return $p;
        }
        return new HtmlBlock();
    }
    
    public function touchFlush(){
        $this->flushed_by = (Yii::$app->user->isGuest)? null : Yii::$app->user->identity->id;
        $this->flushed_at = new \yii\db\Expression('UTC_TIMESTAMP()');
        $this->save();
    }      
}
