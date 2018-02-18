<?php 
	
	function sk_XSS($var){
		$var =  htmlspecialchars($var, ENT_QUOTES,'UTF-8');
		return $var;	
	}
	
?>