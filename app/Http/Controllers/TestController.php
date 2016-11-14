<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    private function String2Hex($string)
    {
	    $hex='';
	    for ($i=0; $i < strlen($string); $i++){
	        $hex .= dechex(ord($string[$i]));
	    }
	    return $hex;
	} 
 
	private function Hex2String($hex)
	{
	    $string='';
	    for ($i=0; $i < strlen($hex)-1; $i+=2){
	        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
	    }
	    return $string;
	}

	public function index()
	{
		$str = 'bismillah';
		$hex = $this->String2Hex($str);
		echo $hex;
		echo '<br/>';
		echo $this->Hex2String($hex);
	}
 
}
