<?php
namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\CharityProgram;
use common\models\CharityDonors;
use common\models\ShTransfer;
use common\models\GhTransfer;
use common\models\Converted;
use common\models\TokenRequest;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class Top10Controller extends BackendController
{
    public function actionIndex()
    {

        //Top SH
        $sql_select_topsh2 = 'SELECT amount, user_id, SUM(amount) AS sumamount  FROM sh_transfer GROUP BY user_id ORDER BY  sumamount DESC';
        $top = ShTransfer::findBySql($sql_select_topsh2)->all();

        $data_sh = array();
        foreach ($top as $key => $value) {
            $sh_month = User::find()->where(['id'=>$value->user_id])->orderBy(['level' => SORT_DESC, 'created_at' => SORT_DESC])->limit(9)->all();
            foreach ($sh_month as $key => $valuez) {
                $data_sh[] = $valuez->id;
            }            
        }


        //Top Leader1
        $topleader1 = User::find()->where(['status' => User::STATUS_ACTIVE])->andWhere(['>', 'downline', 0])->orderBy(['amount_shf1' => SORT_DESC, 'number_f1shactive' => SORT_DESC, 'downline' => SORT_DESC, 'level' => SORT_DESC, 'created_at' => SORT_DESC])->limit(3)->all();
        // var_dump($topleader1);
        $dataleader1 = array();
        foreach ($topleader1 as $key => $valueld) {
            	$dataleader1[] .= $valueld->id;
        }

        //Top Leader
        $topleader = User::find()->where(['status' => User::STATUS_ACTIVE])->andWhere(['>', 'downline', 0])->orderBy(['amount_shf1' => SORT_DESC, 'number_f1shactive' => SORT_DESC, 'downline' => SORT_DESC, 'level' => SORT_DESC, 'created_at' => SORT_DESC])->limit(10)->all();
        $dataleader = array();
        foreach ($topleader as $key => $value4) {
            	$dataleader[] .= $value4->id;    
        }

        //Top Charity
        $sql_select_topcharity2 = 'SELECT amount, user_id, SUM(amount) AS sumamount  FROM charity_donors GROUP BY user_id ORDER BY  sumamount DESC LIMIT 3';
        $model = CharityDonors::findBySql($sql_select_topcharity2)->all();
        $data_charity = array();
        $firstDayUTS = mktime (0, 0, 0, date("m"), 1, date("Y"));
        $lastDayUTS = mktime (0, 0, 0, date("m"), date('t'), date("Y"));
        foreach ($model as $key => $value) {
            $charity_month = CharityDonors::find()->where(['user_id'=>$value->user_id])->andWhere(['>=', 'created_at', $firstDayUTS])->andWhere(['<=', 'created_at', $lastDayUTS])->groupBy(['user_id'])->all();
            $data_charity[] = $value->user_id;
        }

        $user = new User;
        return $this->render('index',[
            'model' => $model,
            'user'=>$user,
            'top' => $top,
            'dataleader' => $dataleader,
            'data_sh' => $data_sh,
            'data_charity' => $data_charity,
            'dataleader1' => $dataleader1,
        ]);
    }


    public function actionUsersh(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $dateto = date_create(str_replace('/', '-', $_POST['dateto']));
        $datefrom =  date_create(str_replace('/', '-', $_POST['datefrom']));
        $cv_dateto = strtotime(date_format($dateto,"m/d/Y"));
        $cv_datefrom = strtotime(date_format($datefrom,"m/d/Y 23:59"));
        $data_sh = array();
        $sh_month = 'SELECT amount, user_id, SUM(amount) AS sumamount  FROM sh_transfer WHERE created_at >= '.$cv_dateto.' AND created_at <= '.$cv_datefrom.' GROUP BY user_id ORDER BY  sumamount DESC';
        $top = ShTransfer::findBySql($sh_month)->all();
        foreach ($top as $key => $valuesh) {
           $sh_userm = User::find()->where(['id'=>$valuesh->user_id])->orderBy(['level' => SORT_DESC, 'created_at' => SORT_DESC])->all();
           foreach ($sh_userm as $key => $value22) {
               $data_sh[] = $value22->id;
           }  
        }

        $string_sh2 = '';

        $string_sh2 = '<thead>
            <tr>
                <th><img src="'.Yii::$app->params['url_file'].'/images/top-icon-i.png"> Top</th>                                           
                <th><img src="'.Yii::$app->params['url_file'].'/images/i-status.png"> Member</th>
                <th><img src="'.Yii::$app->params['url_file'].'/images/ib-rank.png"> Level</th>
                <th><img src="'.Yii::$app->params['url_file'].'/images/i-total-sh.png"> Send Help Amount</th>
            </tr>
        </thead>                                        
        <tbody>';

        foreach ($data_sh as $key =>  $value33) {
            $leveltop = '';
            $user = User::findOne($value33);
            if($key < 10){
           		$key = $key + 1;            
	            $string_sh2 .= '<tr><td><div class="bor-number">'.$key.'</div></td><td>'.$user->username.'</td><td>';
	                $rank = $user->level;
	                    switch ($rank)
	                    {
	                        case 0 :
	                            $leveltop = '';
	                            break;
	                        case 1:
	                            $leveltop = 'Bronze';
	                            break;
	                        case 2:
	                            $leveltop = 'Silver';
	                            break;
	                        case 3:
	                            $leveltop = 'Gold';
	                            break;
	                        case 4 :
	                            $leveltop = 'Platinum';
	                            break;
	                        case 5 :
	                            $leveltop = 'Diamond';
	                            break;
	                        case 6 :
	                            $leveltop = 'Master';
	                            break;
	                        case 7 :
	                            $leveltop = 'Grandmaster';
	                            break;
	                        case 8 :
	                            $leveltop = 'Legendary';
	                            break;
	                        default:
	                            $leveltop = '';
	                            break;
	                    }
	                $string_sh2 .=$leveltop.'</td><td>';
	                if (!empty($user->getUserSh($user->id))) {
	                        $string_sh2 .= number_format($user->getUserSh($user->id), 8, '.', '').' '.'BTC';
	                    }else
	                    {
	                        $string_sh2 .= '0 BTC';
	                    }
	                $string_sh2 .='</td>                                                                                                 
	            </tr>';
        		}
            }                                                                                       
        $string_sh2 .='</tbody>';

        return $string_sh2;
    }



    public function actionUsertop(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //Top Leader1
        
        $dateto = date_create(str_replace('/', '-', $_POST['dateto']));
        $datefrom =  date_create(str_replace('/', '-', $_POST['datefrom']));
        $cv_dateto = strtotime(date_format($dateto,"m/d/Y"));
        $cv_datefrom = strtotime(date_format($datefrom,"m/d/Y 23:59"));

   
    	$sql_sh_month = 'SELECT amount, user_id,  SUM(amount) AS sumamount  FROM sh_transfer WHERE created_at >= '.$cv_dateto.' AND created_at <= '.$cv_datefrom.' GROUP BY user_id ORDER BY  sumamount DESC';
    	$top_leader_sh = ShTransfer::findBySql($sql_sh_month)->all();
    	$dataleader1 = array();
		foreach ($top_leader_sh as $key => $value2) {
    		$ref_sh = User::findOne($value2->user_id);
			if (!empty($ref_sh->referral_user_id)) {
				$dataleader1[] .= $ref_sh->referral_user_id;
			}
    	}
    	if(count($dataleader1) > 0 && count($dataleader1) < 3){
    		$leaders = implode(",",$dataleader1);
    		$users = User::find()->where(['NOT IN', 'id', $leaders])->andWhere(['>=', 'created_at', $cv_dateto])->andWhere(['<=', 'created_at', $cv_datefrom])->orderBy(['number_f1shactive' => SORT_DESC, 'downline' => SORT_DESC, 'level' => SORT_DESC, 'created_at' => SORT_DESC])->limit(13)->all();
    		foreach ($users as $key => $value) {
    			$dataleader1[] .= $value->id;
    		}
    	}

    	$string_leader = implode(",",$dataleader1);
    	$query = User::find()->where(['id' => $dataleader1])->andWhere(['>', 'downline', 0])->orderBy(['number_f1shactive' => SORT_DESC, 'downline' => SORT_DESC, 'level' => SORT_DESC, 'created_at' => SORT_DESC])->all();
    	$data_value = array();
    	foreach ($query as $key => $top_value) {    		
    		$data_value[] .= $top_value->id;
    	}
    	
        $string_user2 = '';
        $string_user2 ='<thead>
            <tr>
                <th><img src="'.Yii::$app->params['url_file'].'/images/top-icon-i.png"> Top</th>                                           
                <th><img src="'.Yii::$app->params['url_file'].'/images/i-status.png"> Member</th>
                <th><img src="'.Yii::$app->params['url_file'].'/images/ib-rank.png"> Level</th>
                <th><img src="'.Yii::$app->params['url_file'].'/images/ib-top.png"> Direct Members</th>
            </tr>
        </thead>                                        
        <tbody>';
	    foreach ($data_value as $key => $lv2) {
	        $user = User::findOne($lv2);
	        $key2 = $key + 1;
	        if ($key < 10) {
	        	 $string_user2 .= '<tr><td><div class="bor-number">'.$key2.'</div></td><td>'.$user->username.'</td><td>';                                                        
			        $rank = $user->level;
		                    switch ($rank)
		                    {
		                        case 0 :
		                            $leveltop = '';
		                            break;
		                        case 1:
		                            $leveltop = 'Bronze';
		                            break;
		                        case 2:
		                            $leveltop = 'Silver';
		                            break;
		                        case 3:
		                            $leveltop = 'Gold';
		                            break;
		                        case 4 :
		                            $leveltop = 'Platinum';
		                            break;
		                        case 5 :
		                            $leveltop = 'Diamond';
		                            break;
		                        case 6 :
		                            $leveltop = 'Master';
		                            break;
		                        case 7 :
		                            $leveltop = 'Grandmaster';
		                            break;
		                        case 8 :
		                            $leveltop = 'Legendary';
		                            break;
		                        default:
		                            $leveltop = '';
		                            break;
		                    }
		            $string_user2 .=$leveltop.'</td><td>';
			        $string_user2 .=count($user->getUserReferralMonth($user->id, $cv_dateto, $cv_datefrom)).'</td></tr>';
	        }
	       
	    }                                                                         
	     $string_user2 .='</tbody>';
        return $string_user2;
    }


    public function actionUsercharity(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $sql_select_topcharity2 = 'SELECT amount, user_id, SUM(amount) AS sumamount  FROM charity_donors GROUP BY user_id ORDER BY  sumamount DESC LIMIT 3';
        $model = CharityDonors::findBySql($sql_select_topcharity2)->all();
        $data_charity = array();
        $dateto = date_create(str_replace('/', '-', $_POST['dateto']));
        $datefrom =  date_create(str_replace('/', '-', $_POST['datefrom']));
        $cv_dateto = strtotime(date_format($dateto,"m/d/Y"));
        $cv_datefrom = strtotime(date_format($datefrom,"m/d/Y 23:59"));
        foreach ($model as $key => $value) {
            $charity_month = CharityDonors::find()->where(['user_id'=>$value->user_id])->andWhere(['>=', 'created_at', $cv_dateto])->andWhere(['<=', 'created_at', $cv_datefrom])->groupBy(['user_id'])->all();
            $data_charity[] = $value->user_id;
        }

        $string_charity2 = '';

        $string_charity2 = '<thead>
            <tr>
                <th><img src="'.Yii::$app->params['url_file'].'/images/top-icon-i.png"> Top</th>                                           
                <th><img src="'.Yii::$app->params['url_file'].'/images/i-status.png"> Member</th>
                <th><img src="'.Yii::$app->params['url_file'].'/images/ib-rank.png"> Level</th>
                <th><img src="'.Yii::$app->params['url_file'].'/images/ib-donate.png"> Charity Donors</th>
            </tr>
        </thead>                                        
        <tbody>';

        foreach ($data_charity as $key =>  $value) {
            $leveltop = '';
            $user = User::findOne($value);
                $string_charity2 .= '<tr>
                    <td>
                        <div class="bor-number">
                            '.$key.'
                        </div>
                    </td>
                    <td>'.$user->username.'</td>
                    <td>';

                $rank = $user->level;
                switch ($rank)
                {
                    case 0 :
                        $leveltop = '';
                        break;
                    case 1:
                        $leveltop = 'Bronze';
                        break;
                    case 2:
                        $leveltop = 'Silver';
                        break;
                    case 3:
                        $leveltop = 'Gold';
                        break;
                    case 4 :
                        $leveltop = 'Platinum';
                        break;
                    case 5 :
                        $leveltop = 'Diamond';
                        break;
                    case 6 :
                        $leveltop = 'Master';
                        break;
                    case 7 :
                        $leveltop = 'Grandmaster';
                        break;
                    case 8 :
                        $leveltop = 'Legendary';
                        break;
                    default:
                        $leveltop = '';
                        break;
                }
                $string_charity2 .= $leveltop.'</td>                                                    
                    <td>';
                    if (!empty($user->getUserDn($user->id))) {
                            $string_charity2 .= $user->getUserDn($user->id).' '.'BTC';
                        }else
                        {
                            $string_charity2 .= '0 BTC';
                        }                                                       
               $string_charity2 .='</td>                                                
                </tr>';
            }                                                                                      
        $string_charity2 .='</tbody>';
        return $string_charity2;
    }
}
