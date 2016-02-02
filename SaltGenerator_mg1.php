<?php
/*
035309b3af0e9afe88e15fc0c8b4aabe:4RxL1artfvVO0ctJXUF2lU1uqrsptO1D
*/
Class SaltedpasswordGenerator{

	private $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

	private function getBase62Char($idx) {
    	return $this->chars[$idx];
	}

	function generateRandomString($saltLength){
	    $randString="";

	    for($i=0; $i < $saltLength; $i++){
	        $randChar = $this->getBase62Char(mt_rand(0,61));
	        $randString .= $randChar;
	    }

	    return $randString;
	}
	function getSaltedHash($password, $salt) {
	    $hash = $salt .$password;
	    return md5($hash);
	}

}
$opt = getopt("n:p:s:");
$setNum = $opt['n']?: 1;
$pwdLength = array_key_exists('p',$opt)? $opt['p']: 8;
$saltLength = array_key_exists('s',$opt)? $opt['s']: 32;
$fileName = 'saltedpassword-mg1';
$fileType = 'csv';
$fileIdx = 1;
$fileCheck = $fileName ; 
while(file_exists('./'.$fileCheck.'.'.$fileType)){
	$fileCheck = $fileName.'-'.$fileIdx;
	$fileIdx++;
}
$fileName = $fileCheck;
$fileContent = "password, salt, magento1_format \n";
$genertor = new SaltedpasswordGenerator;
for($i=0;$i<$setNum; $i++){
	$password = $genertor->generateRandomString($pwdLength);
	$salt = $genertor->generateRandomString($saltLength);
	$saltedpassword = $genertor->getSaltedHash('logic123',$salt);
	$magento_form = $saltedpassword.':'.$salt;
	$fileContent .= $password.','.$salt.','.$magento_form."\n";
}
file_put_contents('./'.$fileName.'.'.$fileType,$fileContent);

