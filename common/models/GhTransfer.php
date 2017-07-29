<?php

namespace common\models;

use Yii;
use common\models\Converted;

/**
 * This is the model class for table "gh_transfer".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $amount
 * @property integer $status
 * @property integer $publish
 * @property integer $created_at
 * @property integer $updated_at
 */
class GhTransfer extends \yii\db\ActiveRecord
{

    const STATUS_BONUS = 1; //gh from bonus wallet
    const STATUS_MAIN = 2; //gh from main wallet

    const PUBLISH_NOACTIVE = 1;
    const PUBLISH_ACTIVE = 2;



    public static function tableName()
    {
        return 'gh_transfer';
    }

    public function rules()
    {
        return [
            [['amount'], 'required', 'message' => 'This field is required!'],
            ['amount', 'number', 'min' => 0.005],
        ];
    }

    public function validateAmount()
    {
        if ($this->amount <= 0) {
            $this->addError('amount', 'Amount should be greater than 0!');
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'amount' => 'Amount',
            'status' => 'Status',
            'publish' => 'Publish',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function findTotalghinmonth($id){
        $date_time_now = date('Y/m/d', time());
        $first_gh_transfer = GhTransfer::find()->where(['user_id'=>$id])->orderBy(['created_at'=>SORT_ASC])->one();
        if(!empty($first_gh_transfer)){
            $first_gh_transfer_date = date('d', $first_gh_transfer->created_at);
            //first day of month
            $first_day_ofmonth = substr($date_time_now, 0, -2).$first_gh_transfer_date.' '.date('H:i:s', $first_gh_transfer->created_at);
            //last day of month
            $last_day_ofmonth = date("Y-m-d H:i:s", strtotime("+1 month", strtotime($first_day_ofmonth)));

            $strtime_firstday = strtotime($first_day_ofmonth);
            $strtime_lastday = strtotime($last_day_ofmonth);

            $sum_amount = GhTransfer::find()->where(['user_id'=>$id])->andWhere(['>','created_at', $strtime_firstday])->andWhere(['<','created_at', $strtime_lastday])->sum('amount');
        }else{
            $sum_amount = 0;
        }

        return $sum_amount;
    }

    public static function getTokenamount($amount, $type){
        if($type == GhTransfer::STATUS_BONUS){
            $TokenForgethelp = TokenForgethelp::find()->where(['<', 'min_bonusw', (float)$amount])->andWhere(['>=', 'max_bonusw', (float)$amount])->one();
        }
        if($type == GhTransfer::STATUS_MAIN){
            $TokenForgethelp = TokenForgethelp::find()->where(['<', 'min_mainw', (float)$amount])->andWhere(['>=', 'max_mainw', (float)$amount])->one();
        }
        if(!empty($TokenForgethelp)){
            return $TokenForgethelp->token;
        } else {
            return 0;
        }
        
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function Updatepublishghtransfer(){
        define("IN_WALLET", true);
        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);
        $standbytimegh = Converted::find()->where(['object'=>'standbytimegh'])->one();
        $ghtransfer  = GhTransfer::find()->where(['publish'=>GhTransfer::PUBLISH_NOACTIVE])->all();
        $$BitcoinWallet = new BitcoinWallet;
        foreach ($ghtransfer as $key => $gethelp) {
            if( (60 * $standbytimegh->value +$gethelp->created_at) <= time() ){
                $gh = GhTransfer::findOne($gethelp->id);
                if(!empty($gh)){
                    //get address bitcoin user gethelp
                    $user = User::findOne($gh->user_id);
                    $addressbitcoin_user = $client->getAddress($user->username);
                    //get total balance bitcoin system wallet 
                    $account_wallettoken = $BitcoinWallet->findBalancebitcoin(BitcoinWallet::TYPE_ShAndGhwallet);
                    if($account_wallettoken > $gh->amount){
                        $transfer_bitcoin = $BitcoinWallet->transfersBitcoin(BitcoinWallet::TYPE_ShAndGhwallet, $addressbitcoin_user, $gh->amount);

                        if($transfer_bitcoin){
                            $gh->publish = GhTransfer::PUBLISH_ACTIVE;
                            $gh->save();
                            return 'ok';
                        }
                    }
                }
            }
        }
    }


}
