<?php

 /**
 * test if a value is a valid credit card expiration date
 *
 * @param string $value the value being tested
 * @param boolean $empty if field can be empty
 * @param array params validate parameter values
 * @param array formvars form var values
 */
function smarty_validate_criteria_isCCExpDate($value, $empty, &$params, &$formvars) {
    if(strlen($value) == 0)
        return $empty;

    if(!preg_match('!^(\d+)\D+(\d+)$!', $value, $_match))
        return false;

    $_month = $_match[1];
    $_year = $_match[2];

    if(strlen($_year) == 2)
        $_year = substr(date('Y', time()),0,2) . $_year;

	if(!is_int($_month))
		return false;
	if($_month < 1 || $_month > 12)
		return false;
	if(!is_int($_year))
		return false;
	if(date('Y',time()) > $_year)
		return false;
	if(date('Y',time()) == $_year && date('m', time()) > $_month)
		return false;

	return true;

}

?>
