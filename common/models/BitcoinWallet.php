<?php

namespace common\models;

use Yii;
use common\models\Account;
use common\models\BitcoinWallet;
use common\extensions\jsonRPCClient;
use common\extensions\Client;

/**
 * This is the model class for table "bitcoin_wallet".
 *
 * @property integer $id
 * @property string $username
 * @property integer $type
 * @property integer $publish
 * @property integer $created_at
 */
class BitcoinWallet extends \yii\db\ActiveRecord
{
    
    const PUBLISH_NOACTIVE = 1;
    const PUBLISH_ACTIVE = 2;

    const TYPE_ShAndGhwallet = 1;
    const TYPE_Tokenwallet = 2;
    const TYPE_Charitywallet = 3;
    const TYPE_Luckydrawwallet = 4;
    const TYPE_Penaltywallet = 5;
    const TYPE_Cashwithdraw = 6;
    const TYPE_Ticketwallet = 7;

    public static function tableName()
    {
        return 'bitcoin_wallet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'type'], 'required'],
            [['type', 'publish', 'created_at'], 'integer'],
            [['username'], 'string', 'max' => 255],
            ['username', 'unique', 'targetAttribute' => 'username', 'message' => 'This {attribute} already exists in the system!'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'type' => 'Type',
            'publish' => 'Publish',
            'created_at' => 'Created At',
        ];
    }

    public static function findBitcoinaddress($id, $type){
        //define("IN_WALLET", true);
        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);
        $bitcwallet = new BitcoinWallet;
        $BitcoinWallet = BitcoinWallet::find()->where(['type'=>$id, 'publish'=>BitcoinWallet::PUBLISH_ACTIVE])->orderBy(['created_at'=> SORT_DESC])->all();
        $array_wallet = array();
        foreach ($BitcoinWallet as $key => $btcwallet) {
            if ($btcwallet->username == "") {
                $array_wallet[$key]['add'] =  $client->getAddress($btcwallet->username);
                $array_wallet[$key]['balance'] =  $client->getBalance($btcwallet->username);
                $array_wallet[$key]['account'] =  $btcwallet->username;
            } else {
                $array_wallet[$key]['add'] =  $client->getAddress('btcwallet'.$btcwallet->username);
                $array_wallet[$key]['balance'] =  $client->getBalance('btcwallet'.$btcwallet->username);
                $array_wallet[$key]['account'] =  'btcwallet'.$btcwallet->username;
            }
            
        }
        
        if($type == 'min'){
            return $bitcwallet->minValueInArray($array_wallet);
        }else{

            return $bitcwallet->maxValueInArray($array_wallet);
        }
    }

    public static function minValueInArray($array)
    {
        $prices = array_column($array, 'balance');
        $min_array = $array[array_search(min($prices), $prices)];
        return $min_array['add'];
    }

    public static function maxValueInArray($array)
    {
        $prices = array_column($array, 'balance');
        $min_array = $array[array_search(max($prices), $prices)];
        return $min_array['account'];
    }


    public static function findBalancebitcoin($type){
        //define("IN_WALLET", true);
        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);
        $bitcwallet = new BitcoinWallet;
        $BitcoinWallet = BitcoinWallet::find()->where(['type'=>$type, 'publish'=>BitcoinWallet::PUBLISH_ACTIVE])->orderBy(['created_at'=> SORT_DESC])->all();
        $totalbalance = 0;
        foreach ($BitcoinWallet as $key => $btcwallet) {
            $balance_wallet =  $client->getBalance('btcwallet'.$btcwallet->username);
            $totalbalance += $balance_wallet;
        }
        return $totalbalance;
    }

    public static function transfersBitcoin($type, $address, $amount){
        define("IN_WALLET", true);
        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);
        $bitcwallet = new BitcoinWallet;
        $BitcoinWallets = BitcoinWallet::find()->where(['type'=>$type, 'publish'=>BitcoinWallet::PUBLISH_ACTIVE])->orderBy(['created_at'=> SORT_DESC])->all();

        foreach ($BitcoinWallets as $key => $bitcoinwallet) {
            $balance_wallet =  $client->getBalance('btcwallet'.$bitcoinwallet->username);
            if($balance_wallet >= $amount){
                $sendbitcoin = $client->withdraw('btcwallet'.$bitcoinwallet->username, $address, $amount - Yii::$app->params['fee']);
            } else {
                $sendbitcoin = $client->withdraw('btcwallet'.$bitcoinwallet->username, $address, $amount - Yii::$app->params['fee']);
                $amount = $amount - $balance_wallet;
            }
        }
    }
}
