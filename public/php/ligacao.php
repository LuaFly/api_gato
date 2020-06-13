<?php 
$key = 1;
$header = [
    'typ' => 'JWT',
    'alg' => 'HS256'
];

$payload = [
    'exp' => (new DateTime("now"))->add(new DateInterval('P1M'))->getTimestamp(), // 1m = 1mês, 1w = 1 semana, 1d = 1 dia
    
];

$header = json_encode($header);
$payload = json_encode($payload);

$header = base64_encode($header);
$payload = base64_encode($payload);

$sign = hash_hmac('sha256', $header . "." . $payload, $key, true);
$sign = base64_encode($sign);

$token = $header . '.' . $payload . '.' . $sign;

print json_encode(['token' => $token]);
?>
