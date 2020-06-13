<?php

$credentials = [
  'login' => 'rudemoru',
  'password' => 'rudemo123456',
];
$authorizationUrl = 'https://online.omnicomm.ru/auth/login?jwt=1';

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $authorizationUrl);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($credentials, '', '&'));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$header[0] = 'Authorization: JWT '.json_decode(curl_exec($curl))->{'jwt'};

curl_close($curl);

$treeVehicleUrl = 'https://online.omnicomm.ru/ls/api/v2/tree/vehicle';

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $treeVehicleUrl);
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$treeVehicles = json_decode(curl_exec($curl));

curl_close($curl);

function flatVehicle($vehicles)
{
  $result = [];
  $childrens = $vehicles->{'children'};
  foreach($childrens as $children) {
    flatVehicle($children);
  }

  $result = array_merge($result, $vehicles->{'objects'});
  
  return $result;
}

$vehicles = flatVehicle($treeVehicles);

var_dump($vehicles);
