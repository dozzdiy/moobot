<?php

$url = "http://ihr.nhso.go.th/lm/FrontEnd/LineMsg";

$message = curlExecuteGet($url);

$message = "\n" . trim(str_replace(array("\n","\\n"),array("","\n"), $message));

if(!stristr($message, "weekend") and !stristr($message, "holiday")){
	sendlinemesg();
	$res = notify_message($message);
}

function sendlinemesg() {
    $token = 'Ga0sPA6J6XGSxrYAgP4IqYRvpyiC7gcDarSbfh5Ha2c'; //it nhso
    define('LINE_API', "https://notify-api.line.me/api/notify");
    define('LINE_TOKEN', $token);
}

function notify_message($message) {
    $queryData = array('message' => $message);
    $queryData = http_build_query($queryData, '', '&');
    //echo $queryData;
    $headerOptions = array(
        'http' => array(
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
            . "Authorization: Bearer " . LINE_TOKEN . "\r\n"
            . "Content-Length: " . strlen($queryData) . "\r\n",
            'content' => $queryData
        )
    );
    $context = stream_context_create($headerOptions);
    $result = file_get_contents(LINE_API, FALSE, $context);
    $res = json_decode($result);
    return $res;
}

function curlExecuteGet($url) {
    $ch = curl_init();
    $timeout = 0;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $file_contents = curl_exec($ch);
    curl_close($ch);
    return $file_contents;
}

?>
