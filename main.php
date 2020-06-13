<?php

$credentials = [
  'login' => 'rudemoru',
  'password' => 'rudemo123456',
];
$url = 'https://online.omnicomm.ru/auth/login?jwt=1';

$curl = curl_init($url);

curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($credentials, '', '&'));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_HEADER, false);

$result = curl_exec($curl);

curl_close($curl);

var_dump(json_decode($result)->{'jwt'});
