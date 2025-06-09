<?php
$partner_key = '378492999ae7be538a6a2917cc30b0cd';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$data = $_POST;
$required = ['status','code','serial','callback_sign'];
foreach ($required as $f) {
    if (!isset($data[$f])) {
        http_response_code(400);
        exit("Missing field: $f");
    }
}

if ($data['callback_sign'] !== md5($partner_key . $data['code'] . $data['serial'])) {
    http_response_code(403);
    exit('Invalid signature');
}

file_put_contents(__DIR__ . '/../logs/log_callback.txt', json_encode($data).PHP_EOL, FILE_APPEND);

if ($data['status'] == '1') {
    file_put_contents(__DIR__ . '/../logs/credit_success.txt',
        "User {$data['request_id']} nạp {$data['amount']} ({$data['telco']})".PHP_EOL,
        FILE_APPEND
    );
    echo "Success";
} else {
    echo "Received";
}
?>