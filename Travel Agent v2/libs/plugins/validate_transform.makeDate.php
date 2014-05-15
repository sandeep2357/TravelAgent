<?php

 /**
 * transform fuction, make a date out of three other form fields
 *
 * @param string $value the value of the field being transformed
 * @param array  $params the parameters passed to the transform function
 * @param array  $formvars the form variables
 */

function smarty_validate_transform_makeDate($value, $params, &$formvars) {

    if(!empty($params['date_fields'])) {
        list($_year, $_month, $_day) = preg_split('![\s,]+!',$params['date_fields']);
    } else {
        $_year = $params['field'] . 'Year';
        $_month = $params['field'] . 'Month';
        $_day = $params['field'] . 'Day';
    }

    if(!isset($formvars[$_year]) || strlen($formvars[$_year]) == 0) {
        trigger_error("SmartyValidate: [makeDate] form field '$_year' is empty.");
        return $value;
    } elseif(!isset($formvars[$_month]) || strlen($formvars[$_month]) == 0) {
        trigger_error("SmartyValidate: [makeDate] form field '$_month' is empty.");
        return $value;
    } elseif(!isset($formvars[$_day]) || strlen($formvars[$_day]) == 0) {
        trigger_error("SmartyValidate: [makeDate] form field '$_day' is empty.");
        return $value;
    } else {
        return $formvars[$_year] . '-' . $formvars[$_month] . '-' . $formvars[$_day];
    }           
}

?>
