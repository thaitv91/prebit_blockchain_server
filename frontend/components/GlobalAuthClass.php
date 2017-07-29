<?php 

namespace app\components;

use Yii;

class GlobalAuthClass extends \yii\base\Component
{
    private $auth = null;
    private $tokenData = null;
    
    public function init() {
    
         $session = Yii::$app->session;
		 
		  if($session['gauth']==1) {
            Yii::$app->runAction('site/logout');
        }
        parent::init();
        
    }

    
}