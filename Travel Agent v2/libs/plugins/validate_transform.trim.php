<?php

 /**
 * transform fuction, trim a value
 *
 * @param string $value the value being trimmed
 * @param array  $params the parameters passed to the transform function
 * @param array  $formvars the form variables
 */

function smarty_validate_transform_trim($value, $params, &$formvars) {
    return trim($value);
}

?>
