<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Account;
use common\models\BitcoinWallet;
use common\extensions\jsonRPCClient;
use common\extensions\Client;
use common\extensions\ConvertBitcoin;
use backend\models\TransferBitcoin;
/**
 * Site controller
 */
class BitcoinwalletController extends BackendController
{
	public function actionWalletpacket($id)
    {

        define("IN_WALLET", true);
        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);

        $model = new BitcoinWallet;

        switch ($id) {
            case BitcoinWallet::TYPE_ShAndGhwallet:
                $type = 'SH and GH wallet';
                break;
            case BitcoinWallet::TYPE_Tokenwallet:
                $type = 'Token wallet';
                break;
            case BitcoinWallet::TYPE_Charitywallet:
                $type = 'Charity wallet';
                break;
            case BitcoinWallet::TYPE_Luckydrawwallet:
                $type = 'Luckydraw wallet';
                break;
            case BitcoinWallet::TYPE_Penaltywallet:
                $type = 'Penalty wallet';
                break;  
            case BitcoinWallet::TYPE_Cashwithdraw:
                $type = 'Cash withdraw wallet';
                break;        
            default:
                $type = 'SH and GH wallet';
        } 

        $BitcoinWallet = BitcoinWallet::find()->where(['type'=>$id])->orderBy(['created_at'=> SORT_DESC])->all();

        if ($model->load(Yii::$app->request->post())){
            $model->username = $model->username;
            $model->type = $id;
            $model->publish = BitcoinWallet::PUBLISH_ACTIVE;
            $model->created_at = time();
            if($model->save()){
                $client->getNewAddress('btcwallet'.$model->username);
                $BitcoinWallet = BitcoinWallet::find()->where(['type'=>$id])->orderBy(['created_at'=> SORT_DESC])->all();
                return $this->render('walletpacket', [
                    'id'=>$id,
                    'type' => $type,
                    'client' => $client,
                    'BitcoinWallet' => $BitcoinWallet,
                    'model' => $model,
                ]);
            }
        }

        
        return $this->render('walletpacket', [
            'type' => $type,
            'client' => $client,
            'BitcoinWallet' => $BitcoinWallet,
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        define("IN_WALLET", true);
        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);

        $BitcoinWallet = BitcoinWallet::findOne($id);
        $TransferBitcoin = new TransferBitcoin;
        if ($BitcoinWallet->username == "") {
            $transactions = $client->getTransactionList($BitcoinWallet->username);
            $bitcoinaddress = $client->getAddress($BitcoinWallet->username);
            $balance = $client->getBalance($BitcoinWallet->username);
        } else {
            $transactions = $client->getTransactionList('btcwallet'.$BitcoinWallet->username);
            $bitcoinaddress = $client->getAddress('btcwallet'.$BitcoinWallet->username);
            $balance = $client->getBalance('btcwallet'.$BitcoinWallet->username);
        }

        if ($TransferBitcoin->load(Yii::$app->request->post())){
            if($balance < $TransferBitcoin->amount ){
                Yii::$app->session->setFlash('error', 'Your balance not enough!');
            } else{
                //send bitcoin to SH/GH bitcoin wallet
                if ($BitcoinWallet->username == "") {
                    $sendbitcoin = $client->withdraw($BitcoinWallet->username, $TransferBitcoin->address, $TransferBitcoin->amount);
                }
                else {
                    $sendbitcoin = $client->withdraw('btcwallet'.$BitcoinWallet->username, $TransferBitcoin->address, $TransferBitcoin->amount);
                }
                
                if($sendbitcoin){
                    Yii::$app->getSession()->setFlash('success', 'Withdraw successfully!');
                }else{
                    Yii::$app->getSession()->setFlash('success', 'Withdraw fail!');
                }
            }

        }


        switch ($BitcoinWallet->type) {
            case BitcoinWallet::TYPE_ShAndGhwallet:
                $type = 'SH and GH wallet';
                break;
            case BitcoinWallet::TYPE_Tokenwallet:
                $type = 'Token wallet';
                break;
            case BitcoinWallet::TYPE_Charitywallet:
                $type = 'Charity wallet';
                break;
            case BitcoinWallet::TYPE_Luckydrawwallet:
                $type = 'Luckydraw wallet';
                break;
            default:
                $type = 'SH and GH wallet';
        } 


        return $this->render('view',[
            'balance' => $balance,
            'bitcoinaddress' => $bitcoinaddress,
            'BitcoinWallet' => $BitcoinWallet,
            'client' => $client,
            'transactions' => $transactions,
            'type' => $type,
            'TransferBitcoin' => $TransferBitcoin,
        ]);
    }

    public function actionPublish()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = BitcoinWallet::findOne($_POST['id']);
        if ($model->publish == BitcoinWallet::PUBLISH_ACTIVE){
            $publish = BitcoinWallet::PUBLISH_NOACTIVE;
        }else{
            $publish = BitcoinWallet::PUBLISH_ACTIVE;
        }
        $model->publish = $publish;
        if($model->save()){
            return ['ok'];
        }
    }
}
?>