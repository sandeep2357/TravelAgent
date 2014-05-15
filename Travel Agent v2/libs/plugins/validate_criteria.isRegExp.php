<?php

 /**
 * test if a value is a valid regular expression match
 *
 * @param string $value the value being tested
 * @param boolean $empty if field can be empty
 * @param array params validate parameter values
 * @param array formvars form var values
 */
function smarty_validate_criteria_isRegExp($value, $empty, &$params, &$formvars) {
        if(!isset($params['expression'])) {
                trigger_error("SmartyValidate: [isRegExp] parameter 'expression' is missing.");            
                return false;
        }
        if(strlen($value) == 0)
            return $empty;
        
        return (preg_match($params['expression'], $value));
}

?>
