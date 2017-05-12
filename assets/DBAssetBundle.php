<?php
/**
 * @author Yuriy Basov <basowy@gmail.com>
 * @since 1.0.0
 */


namespace yii2x\web\db\assets;

use yii\web\AssetBundle;

class DBAssetBundle extends AssetBundle
{
    public static $alias;
    
    /**
     * Registers this asset bundle with a view.
     * @param View $view the view to be registered with
     * @return static the registered asset bundle instance
     */
    public static function register($params)
    {
        $view = $params['view'];
        self::$alias = $params['alias'];
        
        return $view->registerAssetBundle(get_called_class());
    }
    
    public function init()
    {

        $assetBundle = \yii2x\web\db\models\AssetBundle::find()->where(['alias' => self::$alias])->one();
        self::$alias = null;
        
        if(!empty($assetBundle)){
            $config = $assetBundle->config;
         //   print_r($config);exit;
            
            foreach($config as $index => $item){
                $type = $item['name'];
                if($type == 'css'){
                    $this->css[] = $item['value'];
                }
                if($type == 'js'){
                    $this->js[] = $item['value'];
                }
                if($type == 'depends'){
                    $this->depends[] = $item['value'];
                }                
            }
            
            $this->sourcePath = (!empty($assetBundle->sourcePath))  ? $assetBundle->sourcePath: null;
            $this->basePath = (!empty($assetBundle->basePath))  ? $assetBundle->basePath: null;
            $this->baseUrl = (!empty($assetBundle->baseUrl))  ? $assetBundle->baseUrl: null;
        }

        parent::init();
    }    
    
}
