<?php

//header('Content-Type: text/html; charset=UTF-8');
//$url = "http://webdev10g.nhso.go.th/ihr/lm/FrontEnd/LineMsg";
//$url = "http://66.23.242.79/api.php";
$url = "http://ihr.nhso.go.th/lm/FrontEnd/LineMsg";

$message = curlExecuteGet($url);
//echo $message . "<br/>";

/* $tab = array("UTF-8", "ASCII", "Windows-1252", "ISO-8859-15", "ISO-8859-1", "ISO-8859-6", "CP1256", "windows-874", "tis-620"); 
  $chain = "";
  foreach ($tab as $i)
  {
  foreach ($tab as $j)
  {
  $chain .= " $i$j ".iconv($i, $j, "$message") . "<br/>";
  }
  }
  echo $chain; */

//$message = iconv("windows-874", "UTF-8", $message);
$message = "\n" . trim(str_replace(array("\n", "\\n"), array("", "\n"), $message));

if (!stristr($message, "weekend") and ! stristr($message, "holiday")) {
    sendlinemesg();
    $res = notify_message($message);
} else {
    //echo "e";
}

$message = "สวัสดีชาว สบค. (ทดสอบระบบจาก moobot)";

function sendlinemesg() {
    //$token = 'GRlw90niM9BbRj7Gzi0mJ7he8nNTud2vfPPwLMnBYkI'; //intranet group
    //$token = 'vG1VEFyWpU0wZN75XNYUSslmlPbNQdtezmSlw9alyaP'; //breakfast group
    //$token = 'Ga0sPA6J6XGSxrYAgP4IqYRvpyiC7gcDarSbfh5Ha2c'; //IT NHSO
    //$token = 'lvBdlEMMUvaLvHvVLxiDAfRIZ44tpY5RPQcGwLReeXC'; //for document
    $token = 'xrYwtPB6YLQazTTAW0DpDahsOvRMCCMCz10yEgdsNhn' //1330

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
