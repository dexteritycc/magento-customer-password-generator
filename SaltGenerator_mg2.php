<?php
/*

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
	    return hash('sha256', $hash);
	}

}
$opt = getopt("n:p:s:");
$setNum = $opt['n']?: 1;
$pwdLength = array_key_exists('p',$opt)? $opt['p']: 8;
$saltLength = array_key_exists('s',$opt)? $opt['s']: 32;
$fileName = 'saltedpassword-mg2';
$fileType = 'csv';
$fileIdx = 1;
$fileCheck = $fileName ; 
while(file_exists('./'.$fileCheck.'.'.$fileType)){
	$fileCheck = $fileName.'-'.$fileIdx;
	$fileIdx++;
}
$fileName = $fileCheck;
$fileContent = "password, salt, magento2_format \n";
$genertor = new SaltedpasswordGenerator;
for($i=0;$i<$setNum; $i++){
	$password = $genertor->generateRandomString($pwdLength);
	$salt = $genertor->generateRandomString($saltLength);
	$saltedpassword = $genertor->getSaltedHash('logic123',$salt);
	$magento_form = $saltedpassword.':'.$salt.':1';
	$fileContent .= $password.','.$salt.','.$magento_form."\n";
}
file_put_contents('./'.$fileName.'.'.$fileType,$fileContent);

