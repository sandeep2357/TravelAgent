<?php

/**
 * test if a value is a price
 *
 * @param string $value the value being tested
 * @param boolean $empty if field can be empty
 * @param array params validate parameter values
 * @param array formvars form var values
 */
function smarty_validate_criteria_isPrice($value, $empty, &$params, &$formvars) {
    if(strlen($value) == 0)
        return $empty;

    return preg_match('/^\d+(\.\d{1,2})?$/', $value);
}

?>
