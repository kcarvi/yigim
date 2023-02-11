<?
	
	$orderId = '1'; // replace

	$reference = $orderId;
	$description = $orderId;

	$currency = '944';
	$biller = '0000000'; // replace
	$template = 'TPL0001';
	$language = 'az';
	$callback = "https://example.com/callback.php";

	$secretKey = '0000000'; // replace

	$amount = 100; // replace

	$extra = "reference=".$reference.
			 ";amount=".$amount.
			 ";currency=".$currency.
			 ";biller=".$biller.
			 ";description=".$description.
			 ";template=".$template.
			 ";language=".$language;


	file_put_contents($_SERVER["DOCUMENT_ROOT"].'/path/to/log.txt', $extra."\n", FILE_APPEND);

	$signature = base64_encode(md5($reference.$amount.$currency.$biller.$description.$template.$language.$callback.$extra.$secretKey, true));

	$url = "https://sandbox.api.pay.yigim.az/payment/create?reference=".$reference."&amount=".$amount."&currency=".$currency."&biller=".$biller."&description=".$description."&template=".$template."&language=".$language."&callback=".$callback."&extra=".$extra;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    'X-Merchant: 0000000', // replace
	    'X-Signature: '.$signature,
	    'X-Type: XML'
	));
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);                                            
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	
	$response = curl_exec($ch);

	preg_match("/<url>(.+)<\/url>/is", $response, $respUrl);
	preg_match("/<code>(.+)<\/code>/is", $response, $respCode);

?>

<a href="<?php echo $respUrl[1] ?>" class="btn btn-default has-ripple">Оплатить</a>

