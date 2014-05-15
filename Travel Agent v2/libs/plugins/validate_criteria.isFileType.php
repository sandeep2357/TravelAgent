<?php

/**
 * test if a value is a valid file type. This only checks the
 * file extention, it does not test the actual file type.
 *
 * @param string $value the value being tested
 * @param boolean $empty if field can be empty
 * @param array params validate parameter values
 * @param array formvars form var values
 */
function smarty_validate_criteria_isFileType($value, $empty, &$params, &$formvars) {
    if(!isset($_FILES[$value]))
        // nothing in the form
        return false;
    
    if($_FILES[$value]['error'] == 4)
        // no file uploaded
        return $empty;

    if(!preg_match('!\.(\w+)$!i', $_FILES[$value]['name'], $_match))
        // not valid filename
        return false;
    
    $_file_ext = $_match[1];            
    $_types = preg_split('![\s,]+!', $params['type'], -1, PREG_SPLIT_NO_EMPTY);
    foreach($_types as $_key => $_val) {
        $_types[$_key] = strtolower($_types[$_key]);   
    }
        
    if(!in_array(strtolower($_file_ext),$_types))
        // not valid file extention
        return false;
        
    return true;
}

?>
