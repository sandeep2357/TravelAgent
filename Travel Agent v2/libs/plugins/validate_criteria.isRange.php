<?php

/**
 * test if a value is a valid range
 *
 * @param string $value the value being tested
 * @param boolean $empty if field can be empty
 * @param array params validate parameter values
 * @param array formvars form var values
 */
function smarty_validate_criteria_isRange($value, $empty, &$params, &$formvars) {
        if(!isset($params['low'])) {
                trigger_error("SmartyValidate: [isRange] parameter 'low' is missing.");            
                return false;
        }
        if(!isset($params['high'])) {
                trigger_error("SmartyValidate: [isRange] parameter 'high' is missing.");            
                return false;
        }
        if(strlen($value) == 0)
            return $empty;
        
        return ($value >= $params['low'] && $value <= $params['high']);
}

?>
