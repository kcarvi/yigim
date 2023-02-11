<?php

$reference = $_REQUEST["reference"];
$url = "https://sandbox.api.pay.yigim.az/payment/status?reference=".$reference;
$secretkey = "0000000"; // replace

$signature = base64_encode(md5($reference.$secretkey, true));

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'X-Merchant: 0000000', // replace
    'X-Signature:'.$signature,
    'X-Type: json'
));
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
echo $response = curl_exec($ch);
curl_close($ch);

file_put_contents($_SERVER["DOCUMENT_ROOT"].'/path/to/log.txt', $response."\n", FILE_APPEND);


if($_REQUEST["reference"]!="") {

	$order_id = explode("_",$_REQUEST["reference"]);
	$order_id = intval($order_id[0]);
	
	if($order_id > 0) {
		
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	        'X-Merchant: 0000000', // replace
	        'X-Signature:'.$signature,
	        'X-Type: json'
	    ));
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	    echo $response = curl_exec($ch);
	    curl_close($ch);

		preg_match("/<code>(.+)<\/code>/is", $response, $respCode);
		preg_match("/<status>(.+)<\/status>/is", $response, $respStatus);
    	preg_match("/<message>(.+)<\/message>/is", $response, $respMessage);
		
		if($respStatus[1]=="00"&&$respCode[1]=="0") {
			
			// change order status

		}
	}
}

?>