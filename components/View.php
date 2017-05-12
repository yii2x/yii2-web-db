<?php
namespace yii2x\web\db\components;

use Yii;
use yii2x\web\db\models\Page;

class View extends \yii\web\View
{
    public $layout;
    public $page;

    public function renderFile($viewFile, $params = [], $context = null)
    {   
        $viewFile = Yii::getAlias($viewFile);

        $page = $this->page;
        if(strpos($viewFile, 'layouts') !== false){
            $page = $this->layout;
        }        

        if(!empty($page->id)){
            $updatedAt = strtotime($page->updated_at);
            $flushedAt = strtotime($page->flushed_at);

            if (!is_file($viewFile) || $flushedAt < $updatedAt || empty($updatedAt)) {

                if($this->renderViewFile($viewFile, $page->content)){
                    $page->touchFlush();
                }
            }
        }          
        return parent::renderFile($viewFile, $params, $context);
    }
    
    public function renderViewFile($viewFile, $content){

        $handle = fopen($viewFile, "w");
        $size = fwrite($handle, $content);
        fclose($handle);  

        return $size;           
    }    
}