<?php

 /**
 * test if a value is a valid credit card checksum
 *
 * @param string $value the value being tested
 * @param boolean $empty if field can be empty
 * @param array params validate parameter values
 * @param array formvars form var values
 */
function smarty_validate_criteria_isCCNum($value, $empty, &$params, &$formvars) {
    if(strlen($value) == 0)
        return $empty;

	// strip everything but digits
	$value = preg_replace('!\D+!', '', $value);

	if (empty($value))
		return false;

	$_c_digits = preg_split('//', $value, -1, PREG_SPLIT_NO_EMPTY);

	$_max_digit   = count($_c_digits)-1;
	$_even_odd    = $_max_digit % 2;

	$_sum = 0;
	for ($_count=0; $_count <= $_max_digit; $_count++) {
		$_digit = $_c_digits[$_count];
		if ($_even_odd) {
			$_digit = $_digit * 2;
			if ($_digit > 9) {
				$_digit = substr($_digit, 1, 1) + 1;
			}
		}
		$_even_odd = 1 - $_even_odd;
		$_sum += $_digit;
	}
	$_sum = $_sum % 10;
	if($_sum)
		return false;
	return true;

}

?>
