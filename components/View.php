<?php
/**
 * @author Yuriy Basov <basowy@gmail.com>
 * @since 1.0.0
 */
namespace yii2x\web\db\components;

use Yii;
use yii2x\web\db\models\HtmlBlock;

class View extends \yii\web\View
{
    
    public function renderFile($viewFile, $params = [], $context = null)
    {   
        
        if (!is_file($viewFile)) {
            
            $appPath = Yii::getAlias('@app');
            $fileName = str_replace($appPath, "", $viewFile);
            $htmlBlock = HtmlBlock::find()->where(['fileName' => $fileName])->one();
            
            if(!empty($htmlBlock->id)){
                if($this->createViewFile($viewFile, $htmlBlock->content)){
                    $htmlBlock->touchFlush();
                }                
            }      
        }

        return parent::renderFile($viewFile, $params, $context);
    }
    
    public function createViewFile($viewFile, $content){

        Yii::trace("createViewFile: " . $viewFile, __METHOD__); 
        
        $path = explode(DIRECTORY_SEPARATOR,$viewFile);
        array_pop($path);
        $dir = implode($path, DIRECTORY_SEPARATOR);

        \yii\helpers\FileHelper::createDirectory($dir);
        $handle = fopen($viewFile, "w");
        $size = fwrite($handle, $content);
        fclose($handle);  

        return $size;           
    }    
}