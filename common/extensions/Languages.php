<?php
namespace common\extensions;


class Languages
{
	public function getLanguage(){
		$language = isset($_SESSION['language']) ? $_SESSION['language'] : 'en';
		$content = file_get_contents(dirname(__FILE__) . '/languages/'.$language.'.lang');
            $data = $this->delete_all_between('</**', '**/>', $content);
      	$myArray = explode(";",$data);
      	$array = array();
      	foreach ($myArray as $key => $value) {
                  $myArray = explode("=",$value);
                  if(!empty($myArray[1]) && !empty($myArray[1])){
                        $array[$myArray[0]] = $myArray[1];
                  }
                  
      	}
      	return $array;
	}

      public function delete_all_between($beginning, $end, $string) {
            $beginningPos = strpos($string, $beginning);
            $endPos = strpos($string, $end);
            if ($beginningPos === false || $endPos === false) {
                  return $string;
            }

            $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

            return str_replace($textToDelete, '', $string);
      }
}