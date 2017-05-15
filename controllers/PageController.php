<?php

namespace yii2x\web\db\controllers;

use Yii;
use yii\web\Controller;
use yii2x\web\db\models\HtmlBlock;

class PageController extends Controller
{
    public function actionIndex()
    {
        
        if(!empty(Yii::$app->request->uriRequest->html_block_id)){

            $htmlBlock = HtmlBlock::find()->where(['id' => Yii::$app->request->uriRequest->html_block_id])->one();
            
            if(!empty($htmlBlock->fileName)){

                if(!empty(Yii::$app->request->uriRequest->layout_id)){
                    $layoutHtmlBlock = HtmlBlock::find()->where(['id' => Yii::$app->request->uriRequest->layout_id])->one();
                    if(!empty($layoutHtmlBlock->id)){
                        $this->layout = '@app'.$layoutHtmlBlock->fileName;
                    }
                }   
  
                return $this->render('@app'.$htmlBlock->fileName);
            }            
        }
    }    
}
