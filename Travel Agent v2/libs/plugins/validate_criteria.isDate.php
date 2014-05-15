<?php

/**
 * test if a value is a valid date (parsable by strtotime)
 *
 * @param string $value the value being tested
 * @param boolean $empty if field can be empty
 * @param array params validate parameter values
 * @param array formvars form var values
 */
function smarty_validate_criteria_isDate($value, $empty, &$params, &$formvars) {
    if(strlen($value) == 0)
        return $empty;

    return strtotime($value) != -1;
}

?>
