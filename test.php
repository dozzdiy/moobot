<?php
//$url = "http://ihr.nhso.go.th/lm/FrontEnd/LineMsg";
$url = "http://ihr.nhso.go.th/lm/FrontEnd/LineMsg?bureauID=NC4wNw==";

$message = "\n" . trim(str_replace(array("\n", "\\n"), array("", "\n"), curlExecuteGet($url)));
echo "m1=>" . strlen($message) . " | " . $message . "<br/>";
if (strlen($message) <= 1) {
    $message = file_get_contents($url);
    echo "m2=>" . strlen($message) . " | " . $message . "<br/>";
    if (strlen($message) <= 1) {
        $message = getSslPage($url);
        echo "m3=>" . strlen($message) . " | " . $message . "<br/>";
    }
}

function curlExecuteGet($url)
{
    $ch = curl_init();
    $timeout = 0;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $file_contents = curl_exec($ch);
    curl_close($ch);
    return $file_contents;
}

function getSslPage($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}