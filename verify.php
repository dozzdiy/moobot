<?php
$proxy = 'http://velodrome.usefixie.com:80';
$proxyauth = 'fixie:sq025rsPlndXgXu';

$access_token = '976f/MsdT5+5rqsngTjGaLwTTy5sDD5Elzo4Q/k9RtHoiufsYFd2qWuHkKHp+XxeidqM0FOx7DKBdj2uryxrd2ZOvgiLu3YTukYUDgc60MhqEQAoJA5RNPbXz4xslAkUryvxZR+hovIaPY/XNY4LOAdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
