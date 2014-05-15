<?php

 /**
 * test if a value is a valid e-mail address
 *
 * @param string $value the value being tested
 * @param boolean $empty if field can be empty
 * @param array params validate parameter values
 * @param array formvars form var values
 */

function smarty_validate_criteria_isEmail($value, $empty, &$params, &$formvars) {
    if(strlen($value) == 0)
        return $empty;

    // in case value is several addresses separated by newlines
    $_addresses = preg_split('![\n\r]+!', $value);

    foreach($_addresses as $_address) {
		if(preg_match('!@.*@|\.\.|\,!', $_address) ||
            !preg_match('!^.+\@(\[?)[a-zA-Z0-9\.\-]+\.([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$!', $_address)) {
            return false;
        }
    }
    return true;
}

?>
