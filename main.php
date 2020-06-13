<?php

$credentials = [
  'login' => 'rudemoru',
  'password' => 'rudemo123456',
];
$authorization = 'https://online.omnicomm.ru/auth/login?jwt=1';

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $authorization);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($credentials, '', '&'));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_HEADER, false);

$header[0] = 'Authorization: JWT '.json_decode(curl_exec($curl))->{'jwt'};

curl_close($curl);

$treeVehicle = 'https://online.omnicomm.ru/ls/api/v2/tree/vehicle';

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $treeVehicle);
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

$response = curl_exec($curl);

curl_close($curl);

var_dump($response);
