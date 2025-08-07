<?php
function loadXML($filepath) {
    if (!file_exists($filepath)) {
        return null;
    }
    return simplexml_load_file($filepath);
}

function saveXML($xmlObject, $filepath) {
    $xmlObject->asXML($filepath);
}
?>
