<?php

//$url = "http://ihr.nhso.go.th/lm/FrontEnd/LineMsg";
$url = "http://ihr.nhso.go.th/lm/FrontEnd/LineMsg?bureauID=NC4wNw=="; //it
//$url = "http://ihr.nhso.go.th/lm/FrontEnd/LineMsg?bureauID=NS42MQ=="; //1330
//$url = "http://ihr.nhso.go.th/lm/FrontEnd/LineMsg?bureauID=NS4zMg=="; //zone 3

$message = curlExecuteGet($url);
//echo "m1=>" . strlen($message) . " | " . $message . "<br/>";
if (strlen($message) <= 1) {
    $message = file_get_contents($url);
    //echo "m2=>" . strlen($message) . " | " . $message . "<br/>";
    if (strlen($message) <= 1) {
        $message = getSslPage($url);
        //echo "m3=>" . strlen($message) . " | " . $message . "<br/>";
    }
}
//$message .= "birthday1. a\n2.b\n";
//echo "msg1=>" . $message . "<br/>";
$message = "\n" . trim(str_replace(array("\n", "\\n"), array("", "\n"), $message));
//echo "msg2=>" . $message . "<br/>";

if (isset($_GET["node"]) && $_GET["node"] == "hbd") {
    if(stristr($message, "xxxxx")) {
        sendlinemesg();
        $res = notify_message($message);
    }
} else if (!stristr($message, "weekend") && !stristr($message, "holiday")) {
    sendlinemesg();
    $res = notify_message($message);
}

function sendlinemesg()
{
    $token = 'vG1VEFyWpU0wZN75XNYUSslmlPbNQdtezmSlw9alyaP'; //breakfast
    //$token = 'Ga0sPA6J6XGSxrYAgP4IqYRvpyiC7gcDarSbfh5Ha2c'; //it nhso
    //$token = 'xrYwtPB6YLQazTTAW0DpDahsOvRMCCMCz10yEgdsNhn'; //1330
    //$token = 'gRlphJoXXqraqXB358oEWmBxqjclPhkoxOkEbXvpQF2'; //zone 3
    define('LINE_API', "https://notify-api.line.me/api/notify");
    define('LINE_TOKEN', $token);
}

function notify_message($message)
{
    //echo "msg3=>" . $message . "<br/>";
    //echo "1)" . (isset($_GET["node"]) ? "1" : "2") . "<br/>";
    //echo "2)" . ($_GET["node"] == "hbd" ? "1" : "2") . "<br/>";
    //echo "3)" . (stristr($message, "xxxxx") ? "1" : "2") . "<br/>";
    $birthday = false;
    $tmp_msg = explode("xxxxx", $message);
    if (isset($_GET["node"]) && $_GET["node"] == "hbd" && stristr($message, "xxxxx")) {
        $birthday = true;
        //$message = $tmp_msg[1];
		echo "if1". "<br/>";
    }else{
	//echo "else1=>" . $message . "<br/>";
	$message = $tmp_msg[0];
	}
	//echo "msg4=>" . $message . "<br/>";

    if ($birthday) {
        $stk_arr[1] = array(
            "stkid" => 257,
            "stkpkgid" => 3,
        );
        $stk_arr[2] = array(
            "stkid" => 427,
            "stkpkgid" => 1,
        );
        $rid = $stk_arr[array_rand($stk_arr)];
        //
        $queryData = array(
            'message' => $message,
            'stickerPackageId' => $rid["stkpkgid"],
            'stickerId' => $rid["stkid"]
        );
		//echo "if2" . "<br/>";
    } else {
		//echo "else2=>" . $message . "<br/>";
        $queryData = array('message' => $message);
    }
/*
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
    $res = json_decode($result);*/
    return $res;
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

?>
