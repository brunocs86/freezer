<?php
header('Content-Type: application/json');

function isoToUtf($arr)
{
    foreach ($arr as $i => $element) {
        if (is_array($element)) {
            $output[$i] = isoToUtf($element);
        } else {
            if (is_string($element)) {
                $output[$i] = utf8_encode($element);
            } else {
                $output[$i] = $element;
            }
        }
    }

    return $output;
}

require_once dirname(__FILE__) . '/../class/Freezer.php';

$config = $_GET['config'];
$Freezer = new Freezer($config);
$diff = $Freezer->load();

if (is_array($diff) && $Freezer->getEncoding() != 'UTF-8') {
    $diff = isoToUtf($diff);
}
$json = json_encode($diff);

echo $json;