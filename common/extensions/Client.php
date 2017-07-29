<?php 
namespace common\extensions;
use Yii;
?>
<?php if (!defined("IN_WALLET")) { die("Auth Error!"); } ?>
<?php
//To enable developer mode (no need for an RPC server, replace this file with the snipet at https://gist.github.com/d3e148deb5969c0e4b60 

class Client  {
	private $uri;
	private $jsonrpc;

	function __construct($host, $port, $user, $pass)
	{
		$this->uri = "http://" . $user . ":" . $pass . "@" . $host . ":" . $port . "/";
		//$this->jsonrpc = new jsonRPCClient($this->uri);
		$this->jsonrpc = new Bitcoin($user, $pass, $host, $port);

	}

	function getBalance($user_session)
	{
		$balance =  $this->jsonrpc->getbalance("zelles(" . $user_session . ")"); 
		//var_dump($this->jsonrpc); die();
		if($balance >= Yii::$app->params['fee']){
			return $balance - Yii::$app->params['fee'];
		}else{
			return 0;
		}
	}

    function getAddress($user_session)
    {
        return $this->jsonrpc->getaccountaddress("zelles(" . $user_session . ")");
	}

	function getAddressList($user_session)
	{
		return $this->jsonrpc->getaddressesbyaccount("zelles(" . $user_session . ")");
	}

	function getTransactionList($user_session)
	{
		return $this->jsonrpc->listtransactions("zelles(" . $user_session . ")");
	}

	function getNewAddress($user_session)
	{
		return $this->jsonrpc->getnewaddress("zelles(" . $user_session . ")");
	}

	function withdraw($user_session, $address, $amount)
	{
		return $this->jsonrpc->sendfrom("zelles(" . $user_session . ")", $address, (float)$amount );
	}

	function getaccount($address)
	{
		return $this->jsonrpc->getaccount($address);
	}

	function gettransaction($txid){
		return $this->jsonrpc->gettransaction($txid);
	}

	function getwalletinfo()
	{
		return $this->jsonrpc->getwalletinfo();
	}

	function getlistaccount(){
		return $this->jsonrpc->listaccounts();
	}
}
?>
