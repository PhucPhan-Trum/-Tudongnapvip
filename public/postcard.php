<?php
$partner_id = '15569199337';
$partner_key = '378492999ae7be538a6a2917cc30b0cd';
$url = 'https://thesieure.com/chargingws/v2';

$telco = $_POST['telco'] ?? '';
$code = $_POST['code'] ?? '';
$serial = $_POST['serial'] ?? '';
$amount = $_POST['amount'] ?? '';
$request_id = time();
$command = 'charging';

$sign = md5($partner_key . $code . $serial);
$dataPost = [
    'telco' => strtoupper($telco),
    'code' => $code,
    'serial' => $serial,
    'amount' => $amount,
    'request_id' => $request_id,
    'partner_id' => $partner_id,
    'command' => $command,
    'sign' => $sign,
    'callback_url' => 'https://YOUR-RENDER-URL.onrender.com/callback.php'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataPost);
$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>