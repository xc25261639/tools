<?php
namespace tools\Supports;
use tools\Exceptions\Exception;

class IcbcCa{
	public static function sign($content,$privatekey,$password){

		if (!extension_loaded('infosec'))
		{
			if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
	  		{
				dl('php_infosec.dll');
			}
	   		else
			{
				dl('infosec.so');
			}
	 	}
		else
		{
			//echo "loaded infosec module success <br/>";
		}

		$plaint=$content;
		if(strlen($plaint) <= 0)
		{
			echo "WARNING : no source data input";
			throw new Exception("no source data input");
		}
/*		$keyfile=$keyfilepath;
		if(strlen($keyfile) <= 0)
		{
			echo "WARNING : no key data input<br/>";
			exit();
		}*/
		//read private key from file
		//$fd = "pri-CEA.key";
/*		$fp = fopen($keyfile,"rb");
		if($fp == NULL)
		{
			echo "open file error<br/>";
			exit();
		}

		fseek($fp,0,SEEK_END);
		$filelen=ftell($fp);
		fseek($fp,0,SEEK_SET);
		$contents = fread($fp,$filelen);
		fclose($fp);*/
		$contents = base64_decode($privatekey);
		$key = substr($contents,2);
		//echo "key:",base64_encode($key),"\n";

		$pass=$password;
		if(strlen($pass) <= 0)
		{
			echo "WARNING : no key password input";
			throw new Exception("no key password input");
		}else{

			$signature = sign($plaint,$key,$pass);
			$code = current($signature);
			$len = next($signature);
			$signcode = base64enc($code);
			return current($signcode);
	/*			echo "signature : ",current($signcode),"\n";
			echo "signature len: ",$len,"\n";*/
		}
	
	}

	public static function verify($content,$publicKey,$password){

	}

}