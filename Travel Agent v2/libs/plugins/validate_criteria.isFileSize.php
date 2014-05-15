<?php

/**
 * test if a value is a valid file size.
 *
 * @param string $value the value being tested
 * @param boolean $empty if field can be empty
 * @param array params validate parameter values
 * @param array formvars form var values
 */
function smarty_validate_criteria_isFileSize($value, $empty, &$params, &$formvars) {
    if(!isset($_FILES[$value]))
        // nothing in the form
        return false;
    
    if($_FILES[$value]['error'] == 4)
        // no file uploaded
        return $empty;

    if(!isset($params['max'])) {
        trigger_error("SmartyValidate: [isFileSize] 'max' attribute is missing.");        
        return false;           
    }
    
    $_max = trim($params['max']);
    
    if(!preg_match('!^(\d+)([bkmg](b)?)?$!i', $_max, $_match)) {
        trigger_error("SmartyValidate: [isFileSize] 'max' attribute is invalid.");        
        return false;   
    }
    $_size = $_match[1];
    $_type = strtolower($_match[2]);
    
    switch($_type) {
        case 'k':
            $_maxsize = $_size * 1024;            
            break;
        case 'm':
            $_maxsize = $_size * 1024 * 1024;            
            break;
        case 'g':
            $_maxsize = $_size * 1024 * 1024 * 1024;
            break;
        case 'b':
        default:
            $_maxsize = $_size;
            break;   
    }
    
    return $_FILES[$value]['size'] <= $_maxsize;
}

?>
