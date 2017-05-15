<?php
/**
 * @author Yuriy Basov <basowy@gmail.com>
 * @since 1.0.0
 */
namespace yii2x\web\db\components;

use Yii;
use yii\web\UrlRuleInterface;
use yii\db\Expression;
use yii2x\web\db\models\Request;

class RequestRule implements UrlRuleInterface
{
    /**
     * Parses the given request and returns the corresponding route and parameters.
     * @param \yii\web\UrlManager $manager the URL manager
     * @param \yii\web\Request $request the request component
     * @return array|boolean the parsing result. The route and the parameters are returned as an array.
     * If false, it means this rule cannot be used to parse this path info.
     */
    public function parseRequest($manager, $request)
    {
 
        $route = false;
        $parsedUrl = parse_url(Yii::$app->request->absoluteUrl);
        $pageUrlList = $this->getUrlParts($parsedUrl);    
  
        $uriRoute = $this->getUriRequest($pageUrlList);
        if(!empty($uriRoute->id)){
            $request->uriRequest = $uriRoute;            
            $route = $uriRoute->auth_item;
            Yii::trace("Request parsed with URL rule: " . $route, __METHOD__);
            return [$route,[]];
        }

        return false;
    }

    /**
     * Creates a URL according to the given route and parameters.
     * @param \yii\web\UrlManager $manager the URL manager
     * @param string $route the route. It should not have slashes at the beginning or the end.
     * @param array $params the parameters
     * @return string|boolean the created URL, or false if this rule cannot be used for creating this URL.
     */
    public function createUrl($manager, $route, $params)
    {
        $query = Request::find()
                ->where(['auth_item' => $route]);
    
//echo $query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql;exit;
        $uriRoute = $query->one();   
        if(!empty($uriRoute->id)){
            return $uriRoute->uri;
        }
        return false;
    }
    
    public function getUriRequest($pageUrlList){
        $is_guest = 'is_guest ' . ((Yii::$app->user->isGuest)? 'desc': 'asc');
        $query = Request::find()
                ->where(['uri' => $pageUrlList])
                ->orderBy([new Expression('FIELD(uri, "'.implode('","', $pageUrlList).'"), ' . $is_guest)]);
    
//echo $query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql;exit;
        $uriRoute = $query->one();      
        return $uriRoute;
    }    
    public function getUrlParts($parsedUrl){

        $list = [];
        $path = explode('/', $parsedUrl['path']);
        $currentPath = '';
        
        for($i=1; $i < count($path); $i++){
            $currentPath .= $path[$i];
            $list[] = $currentPath;
            $currentPath .= '/';
        }
                
        return array_reverse($list);
  
    }    
    
    protected function initUrlNameParams($page, $parsedUrl){
        
        $urlNameParams = '';
        if($page->urlName != '/'){
            $urlNameParams = str_replace($page->urlName, '', $parsedUrl['path']); 
        }
        else{
            if($request->getPathInfo() != '/'){
                $urlNameParams = $request->getPathInfo(); 
            } 
        }          
        
        return $urlNameParams;
    }        
}
