<?php

/**
 * test if a value is a valid range
 *
 * @param string $value the value being tested
 * @param boolean $empty if field can be empty
 * @param array params validate parameter values
 * @param array formvars form var values
 */
function smarty_validate_criteria_isLength($value, $empty, &$params, &$formvars) {

        if(!isset($params['min'])) {
                trigger_error("SmartyValidate: [isLength] parameter 'min' is missing.");            
                return false;
        }
        if(!isset($params['max'])) {
                trigger_error("SmartyValidate: [isLength] parameter 'max' is missing.");            
                return false;
        }

        $_length = strlen($value);
                
        if($_length >= $params['min'] && $_length <= $params['max'])
            return true;
        elseif($_length == 0)
            return $empty;
        else
            return false;
}

?>
