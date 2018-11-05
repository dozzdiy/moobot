<?php
//$url = "http://ihr.nhso.go.th/lm/FrontEnd/LineMsg";
$url = "http://ihr.nhso.go.th/lm/FrontEnd/LineMsg?bureauID=NC4wNw==";

$message = curlExecuteGet($url);

$message = "\n" . trim(str_replace(array("\n", "\\n"), array("", "\n"), $message));

echo "m1=>" . len($message) . " | " . $message . "<br/>";

$message2 = file_get_contents($url);
echo "m2=>" . len($message) . " | " . $message2 . "<br/>";

$message3 = getSslPage($url);
echo "m3=>" . len($message) . " | " . $message3 . "<br/>";

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