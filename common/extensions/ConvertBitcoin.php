<?php
namespace common\extensions;


class ConvertBitcoin
{
   //Author: Ngoc thach || ngocthach.ho91@gmail.com
   //Sources from https://blockchain.info/ticker || https://bitpay.com/api/rates
   //Currency can convert from bitcoin
   //USD, ISK, HKD, TWD, CHF, EUR, DKK, CLP, CAD, CNY, THB, AUD, SGD, KRW, JPY, PLN, GBP, SEK, NZD, BRL, RUB, ...

   public function getConvertBitcoin($currency, $properties){
      $data = file_get_contents('https://bitpay.com/api/rates');
      $arrData = json_decode($data,true);

      foreach ($arrData as $key => $value) {
         if($value['code'] == $currency){
            $result = $value[$properties];
         }
      }
      return $result;
      
   }


   //Currency can convert from bitcoin
   //USD, ISK, HKD, TWD, CHF, EUR, DKK, CLP, CAD, CNY, THB, AUD, SGD, KRW, JPY, PLN, GBP, SEK, NZD, BRL, RUB

   public function getConvertBitcoin2(){
      $getBitcoinBlockchain = preg_replace('/\s+/', '', file_get_contents('https://blockchain.info/ticker'));
      //delete last character in string 
      $convertString = substr($getBitcoinBlockchain, 0, -1);
      //delete first character in string 
      $convertString2 = substr($convertString, 1);
      //add character ; to last string item for convert to array from string
      $convertString3 = str_replace('},', '},;', $convertString2);
      //convert string to array
      $convertString4 = explode(";",$convertString3);

      $array = array();
      foreach ($convertString4 as $getkeyvalue) {
         //delete character " in all string    
         $getkeyvalue1 = str_replace('"', '', $getkeyvalue);
         //convert to array from string property of currency
         $getkeyvalue2 = explode(":{",$getkeyvalue1);
         //create array with key = currency, value = string 
         $array[$getkeyvalue2[0]] = $getkeyvalue2[1];
      }

      $data = array();
      foreach ($array as $key => $value) {
          $value1 = $currency = str_replace('},', '', $value);
          $value2 = explode(",",$value1);
          foreach ($value2 as $key2 => $val) {
              $value3 = explode(":",$val);
              $data[$key][$value3[0]] = $value3[1];
          }
      }
      return $data;
   }

   public function ConvertBitcoinToCurrency($currency, $properties)
   {
   	$convertBitcoin = $this->getConvertBitcoin();
      if(isset($convertBitcoin[$currency][$properties])){
        return $convertBitcoin[$currency][$properties];
      } else {
        return false;
      }
   }
}
