<?php

/**
 * test if a value is an integer
 *
 * @param string $value the value being tested
 * @param boolean $empty if field can be empty
 * @param array params validate parameter values
 * @param array formvars form var values
 */
function smarty_validate_criteria_isValidCode($value, $empty, &$params, &$formvars) {
		global $fingerprint;
		$datekey = date("F j");
		$scode=$_POST["scode"];
		$random_code=$_POST["random_code"];
		$rcode = hexdec(md5($_SERVER[HTTP_USER_AGENT] . $fingerprint . $random_code . $datekey));
		$code = substr($rcode, 2, 6);
		if($code==$scode){
			return true;
		}else{
			return false;
		}

}

?>
