<?php

/**
 * test if a value is a valid range
 *
 * @param string $value the value being tested
 * @param boolean $empty if field can be empty
 * @param array params validate parameter values
 * @param array formvars form var values
 */
function smarty_validate_criteria_isEqual($value, $empty, &$params, &$formvars) {
        if(!isset($params['field2'])) {
                trigger_error("SmartyValidate: [isEqual] parameter 'field2' is missing.");            
                return false;
        }
        if(strlen($value) == 0)
            return $empty;
        
        return $value == $formvars[$params['field2']];
}

?>
