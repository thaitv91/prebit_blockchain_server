<?php

namespace common\models;

use Yii;
use common\models\TokenForsendhelp;
use common\models\ProfitForsendhelp;
use common\models\ShTransfer;

/**
 * This is the model class for table "sh_transfer".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $amount
 * @property integer $inc_days
 * @property integer $sh_packet_id
 * @property integer $min_days
 * @property integer $max_days
 * @property integer $status
 * @property integer $publish
 * @property integer $created_at
 * @property integer $updated_at
 */
class ShTransfer extends \yii\db\ActiveRecord
{

    
    const STATUS_HOLD = 1;
    const STATUS_WITHDRAW = 2;
    const STATUS_CAPITAL_WITHDRAW = 3;
    const STATUS_COMPLETED = 4;

    const PUBLISH_NOACTIVE = 1;
    const PUBLISH_ACTIVE = 2;

    const MODE_NOACTIVE = 1; // SH chưa tính refferall và manager bonus
    const MODE_ACTIVE = 2; // SH đã được tính refferall và manager bonus


    public static function tableName()
    {
        return 'sh_transfer';
    }

    public function rules()
    {
        return [
            // [['user_id', 'amount', 'inc_days', 'sh_packet_id', 'min_days', 'max_days', 'status', 'publish', 'created_at', 'updated_at'], 'required'],
            // [['user_id', 'inc_days', 'sh_packet_id', 'min_days', 'max_days', 'status', 'publish', 'mode', 'created_at', 'updated_at'], 'integer'],
            // ['amount', 'number', 'min' => 0.1],
        ];
    }

    public function validateAmount()
    {
        if ($this->amount <= 0) {
            $this->addError('amount', 'Amount should be greater than 0!');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'amount' => 'Amount',
            'inc_days' => 'Inc Days',
            'sh_packet_id' => 'Sh Packet ID',
            'min_days' => 'Min Days',
            'max_days' => 'Max Days',
            'status' => 'Status',
            'publish' => 'Publish',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function getTokenamount($amount){
        $TokenForsendhelp = TokenForsendhelp::find()->where(['<', 'min_amount', (int)$amount])->andWhere(['>=', 'max_amount', (int)$amount])->one();
        if(empty($TokenForsendhelp)){
            $token = TokenForsendhelp::find()->orderBy(['token' => SORT_ASC])->one();
        }else{
            $token = $TokenForsendhelp;
        }
        return $token->token;
    }

    public static function findTotalshinmonth($id){
        $date_time_now = date('Y/m/d', time());
        $first_sh_transfer = ShTransfer::find()->where(['user_id'=>$id])->orderBy(['created_at'=>SORT_ASC])->one();
        if(!empty($first_sh_transfer)){
            $first_sh_transfer_date = date('d', $first_sh_transfer->created_at);
            //first day of month
            $first_day_ofmonth = substr($date_time_now, 0, -2).$first_sh_transfer_date.' '.date('H:i:s', $first_sh_transfer->created_at);
            //last day of month
            $last_day_ofmonth = date("Y-m-d H:i:s", strtotime("+1 month", strtotime($first_day_ofmonth)));

            // $strtime_firstday = strtotime($first_day_ofmonth);
            // $strtime_lastday = strtotime($last_day_ofmonth);
            $strtime_firstday = strtotime(date("Y-n-j", strtotime("first day of this month")));
            $strtime_lastday = strtotime(date("Y-n-j", strtotime("last day of this month")));
            //var_dump($strtime_lastday); exit;

            $sum_amount = ShTransfer::find()->where(['user_id'=>$id])->andWhere(['>=','created_at', $strtime_firstday])->andWhere(['<=','created_at', $strtime_lastday])->sum('amount');
        }else{
            $sum_amount = 0;
        }
        return $sum_amount;
    }

    public static function findAmountshActiveThismonth($id){
        $strtime_firstday = strtotime(date("Y-n-j", strtotime("first day of this month")));
        $strtime_lastday = strtotime(date("Y-n-j", strtotime("last day of this month")));
        $active_sh = ShTransfer::find()->where(['user_id'=>$id, 'publish'=>ShTransfer::PUBLISH_ACTIVE])->andWhere(['<', 'status', ShTransfer::STATUS_COMPLETED])->andWhere(['>=','created_at', $strtime_firstday])->andWhere(['<=','created_at', $strtime_lastday])->orderBy(['created_at'=>SORT_ASC])->all();
        return $active_sh;
    }

    public static function getTotalprofit($id){
        //get total the amount of interest was drawn by user 
        $total = ShWithdraw::find()->where(['id_shtransfer' => $id])->sum('amount');
        if(!empty($total)){
            $total_profit = round($total, 8);
        }else{
            $total_profit = 0;
        }
        return $total_profit;
    }

    public static function getShwithdraw($id){
        return ShWithdraw::find()->where(['id_shtransfer'=>$id])->all();
    }

    public static function getProfitdaily($id){
        $sendhelp = ShTransfer::findOne($id);
        $ProfitForsendhelp = ProfitForsendhelp::find()->where(['packet_sh'=> $sendhelp->sh_packet_id])->one();
        $created_sh = $sendhelp->created_at;
        $profit = 0;
        //staged 1 profit sendelp: 0 - 30 day
        if( (time() - $created_sh) <= 30*86400 ){
            $profit = $ProfitForsendhelp->staged1;
        }
        //staged 2 profit sendelp: 31 - 60 day
        if( ( (time() - $created_sh) > 30*86400 ) && ( (time() - $created_sh) <= 60*86400 ) ){
            $profit = $ProfitForsendhelp->staged2;
        }
        //staged 3 profit sendelp: 61 - 90 day
        if( ( (time() - $created_sh) > 60*86400 ) && ( (time() - $created_sh) <= 90*86400 ) ){
            $profit = $ProfitForsendhelp->staged3;
        }
        //staged 4 profit sendelp: 91 - 120 day
        if( ( (time() - $created_sh) > 90*86400 ) && ( (time() - $created_sh) <= 120*86400 ) ){
            $profit = $ProfitForsendhelp->staged4;
        }
        //staged 4 profit sendelp: 121 - 150 day
        if( ( (time() - $created_sh) > 120*86400 ) && ( (time() - $created_sh) <= 150*86400 ) ){
            $profit = $ProfitForsendhelp->staged4;
        }
        //staged 4 profit sendelp: 121 - 180 day
        if( ( (time() - $created_sh) > 150*86400 ) && ( (time() - $created_sh) <= 180*86400 ) ){
            $profit = $ProfitForsendhelp->staged4;
        }
        return $profit;
    }

    // profit follow user level
    public static function getProfitdailyUserlevel($id){
        $sendhelp = ShTransfer::findOne($id);
        $ProfitForsendhelp = ProfitForsendhelp::find()->where(['packet_sh'=> $sendhelp->sh_packet_id])->one();
        $created_sh = $sendhelp->created_at;
        $profit = 0;
        if(Yii::$app->user->identity) {

            $level = Yii::$app->user->identity->level;

            //$level == 1
            if( $level == 1 ){
                $profit = $ProfitForsendhelp->staged1;
            }
            //$level == 2
            if(  $level == 2 ){
                $profit = $ProfitForsendhelp->staged2;
            }
            //$level == 3
            if( $level == 3 ){
                $profit = $ProfitForsendhelp->staged3;
            }
            //$level == 4
            if( $level == 4 ){
                $profit = $ProfitForsendhelp->staged4;
            }
            //$level == 5
            if( $level == 5 ){
                $profit = $ProfitForsendhelp->staged5;
            }
            //$level == 6
            if( $level == 6 ){
                $profit = $ProfitForsendhelp->staged6;
            }
        }
        return $profit;
    }


    // check all shtransfer to completed
    public function getCheckallShtransfer(){
        $sh_transfer = ShTransfer::find()->where(['<','status', ShTransfer::STATUS_COMPLETED])->orderBy(['created_at'=>SORT_ASC])->all();
        $shtransfer = new ShTransfer;
        foreach ($sh_transfer as $sh_transfer_id) {
            $shtransfer->checkCompleteShtransfer($sh_transfer_id->id);
        }
    }


    // check sh transfer of user id to completed
    public static function updateShtransfer($id){
        $sh_transfer = ShTransfer::find()->where(['user_id'=>$id])->andWhere(['<','status', ShTransfer::STATUS_COMPLETED])->orderBy(['created_at'=>SORT_ASC])->all();
        $shtransfer = new ShTransfer;
        foreach ($sh_transfer as $sh_transfer_id) {
            $shtransfer->checkCompleteShtransfer($sh_transfer_id->id);
        }
    }

    public static function getProfit($id){
        return ShWithdraw::find()->where(['id_shtransfer'=>$id])->sum('amount');
    }

    public static function checkCompleteShtransfer($id){
        $sh_transfer = ShTransfer::findOne($id);

        //$profit_packet = $sh_transfer->getProfitdaily($sh_transfer->id);
        $profit_packet = $sh_transfer->getProfitdailyUserlevel($sh_transfer->id);
        $maturity = $sh_transfer->min_days * 86400 + $sh_transfer->created_at;
        $endday = $sh_transfer->max_days * 86400 + $sh_transfer->created_at;
        if( (time() >= $maturity) && (time() < $endday) ){
            $sh_transfer->status = ShTransfer::STATUS_CAPITAL_WITHDRAW;
            $sh_transfer->save();
        }
        if(time() >= $endday){
            // sh expired
            $id_sh = $id;
            $id_user = $sh_transfer->user_id;
            $user = User::find($id_user)->one();
            
            $level = $user->level;

            $sh_transfer = ShTransfer::findOne($id_sh);
            //$profit_packet = $sh_transfer->getProfitdaily($sh_transfer->id);
            $profit_packet = $sh_transfer->getProfitdailyUserlevel($sh_transfer->id);
            //daily profit in 1 second
            $daily_profit = $sh_transfer->amount * $profit_packet / 100 / 86400;
            //total daily profit from last withdraw to now
            $amount_profit = (time()- $sh_transfer->inc_days) * $daily_profit;

            $profit = round($amount_profit, 8);

            //add to gh wallet
            $user->wallet = $user->wallet + $profit + $sh_transfer->amount;
            $user->save();

            //update inc_days in sh transfer
            $sh_transfer->inc_days = time();
            $sh_transfer->status = ShTransfer::STATUS_COMPLETED;
            $sh_transfer->save();

            //referal bonus and manager bonus for previous sh transfer
            //find previous sh transfer
            $prev_sh_transfer = ShTransfer::find()->where(['user_id'=>$id_user, 'status'=>ShTransfer::STATUS_COMPLETED])->andWhere(['<>','id', $id_sh])->orderBy(['created_at'=>SORT_DESC])->One();
            if(!empty($prev_sh_transfer)){
                //daily profit in 1 second
                $daily_profit = $prev_sh_transfer->amount * $packet->daily_profit / 100 / 86400;
                //total daily profit from last withdraw to now
                $amount_profit = (time()- $prev_sh_transfer->created_at) * $daily_profit;
                $profit = round($amount_profit, 8);
                //get total profit and capital of sh_transfer
                $withdraw_capital = $profit + $prev_sh_transfer->amount;

                //get referral parent 
                $referral_parent =  $user->referral_user_id;
                if(!empty($referral_parent)){
                    $user_referral = User::findOne($referral_parent);
                    $profit_referral = ReferralBonus::find()->where(['level'=>$user_referral->level])->one();
                    $referral_bonus = $sh_transfer->amount *  $profit_referral->profit / 100;
                    $user_referral->referral_bonus = $user_referral->referral_bonus + $referral_bonus;
                    $user_referral->save();

                    //insert bonus_history
                    $bonus_history = new BonusHistory;
                    $bonus_history->user_id = $id_user;
                    $bonus_history->reciever_id = $referral_parent;
                    $bonus_history->sh_transfer_id = $id_sh;
                    $bonus_history->amount = $referral_bonus;
                    $bonus_history->wall_type = BonusHistory::REFERRAL_BONUS;
                    $bonus_history->created_at = time();
                    $bonus_history->updated_at = time();
                    $bonus_history->save();
                }

                // get manager parent 
                $manager_parent = $user->findManagerparent($id_user);
                if(!empty($manager_parent)){
                    foreach ($manager_parent as $key => $userid) {
                        $user_manager = User::findOne($userid);
                        //kiểm tra số tầng mà user_manager này có thể hưởng manager bonus
                        $floor = LevelSetting::find()->where(['level'=>$user_manager->level])->one();

                        if($floor->manager_bonus >= $key+1){

                            $profit_manager = ManagerBonus::find()->where(['floor'=>$key+1])->one();
                            $manager_bonus = $sh_transfer->amount *  $profit_manager->profit / 100;
                            
                            if(!empty($user_manager)){
                                $user_manager->manager_bonus = $user_manager->manager_bonus + $manager_bonus;
                                $user_manager->save();

                                //insert bonus_history
                                $bonus_history = new BonusHistory;
                                $bonus_history->user_id = $id_user;
                                $bonus_history->reciever_id = $userid;
                                $bonus_history->sh_transfer_id = $id_sh;
                                $bonus_history->amount = $manager_bonus;
                                $bonus_history->wall_type = BonusHistory::MANAGER_BONUS;
                                $bonus_history->created_at = time();
                                $bonus_history->updated_at = time();
                                $bonus_history->save();
                            }

                        }
                    }
                }
            }

            //update level all member
            $user->updateLevel($id_user);

            //insert sh withdraw
            $sh_withdraw = new ShWithdraw;
            $sh_withdraw->id_shtransfer = $id_sh;
            $sh_withdraw->amount = $profit;
            $sh_withdraw->created_at = time();
            if($sh_withdraw->save()){
                return $profit + $sh_transfer->amount;
            }
        }
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function getShtransfer($id){
        return ShTransfer::findOne($id);
    }
}
