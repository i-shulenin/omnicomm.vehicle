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

//$treeVehicles = json_decode(curl_exec($curl));
$treeVehicles = json_decode('{
  "id": 4101,
  "parentGroupId": null,
  "name": "Демо Русский",
  "objects": [{
      "uuid": "3c635eff-77ae-3c09-bf5b-410c64f2ac13",
      "name": "VOLVO",
      "terminal_type": "FAS",
      "terminal_id": 202002469
    },
    {
      "uuid": "ba10ce0e-3613-379d-a5b8-7383faac29b1",
      "name": "ДГУ_4",
      "terminal_type": "FAS",
      "terminal_id": 203028739
    },
    {
      "uuid": "ba10ce0e-3613-379d-a5b8-7383faac29b1",
      "name": "ДГУ_4",
      "terminal_type": "FAS",
      "terminal_id": 203028739
    }
  ],
  "autocheck_id": 4101,
  "children": [{
      "id": 5662,
      "parentGroupId": 4101,
      "name": "IQFreeze",
      "objects": [{
          "uuid": "d8d513ea-416c-3027-86de-059895c5a84b",
          "name": "реф ам501433",
          "terminal_type": "FAS",
          "terminal_id": 265001525
        },
        {
          "uuid": "26804259-2e29-3300-ad1f-4852df7800ee",
          "name": "реф ам501633",
          "terminal_type": "FAS",
          "terminal_id": 265004218
        },
        {
          "uuid": "1d6f21e0-0d37-3b42-8f2f-fa65ec72eed9",
          "name": "реф ам501533",
          "terminal_type": "FAS",
          "terminal_id": 336003771
        },
        {
          "uuid": "2a4914a2-ae92-3b05-9a57-da11b513d5a9",
          "name": "реф ам503333",
          "terminal_type": "FAS",
          "terminal_id": 336003821
        }
      ],
      "autocheck_id": 5662,
      "children": [{
        "id": 5663,
        "parentGroupId": 4101,
        "name": "TPMS",
        "objects": [{
          "uuid": "e9db7638-ca9c-316e-8794-11ba4c996dbd",
          "name": "TPMS",
          "terminal_type": "FAS",
          "terminal_id": 203031366
        }],
        "autocheck_id": 5663,
        "children": []
      }]
    },
    {
      "id": 5664,
      "parentGroupId": 4101,
      "name": "CAN bus",
      "objects": [{
          "uuid": "c949b995-c3d7-3946-9767-3c5b73a64349",
          "name": "Камаз (CAN)",
          "terminal_type": "FAS",
          "terminal_id": 203026865
        },
        {
          "uuid": "765ed63d-e831-305c-81db-af99180365a6",
          "name": "Камаз Самосвал (CAN)",
          "terminal_type": "FAS",
          "terminal_id": 203028996
        }
      ],
      "autocheck_id": 5664,
      "children": []
    },
    {
      "id": 5690,
      "parentGroupId": 4101,
      "name": "AGRO",
      "objects": [{
          "uuid": "b87f53a5-0874-30f8-bc20-922bb2a25a7d",
          "name": "Трактор 1",
          "terminal_type": "FAS",
          "terminal_id": 236012050
        },
        {
          "uuid": "7abd30e2-9298-3f5b-88ec-b5eff4003a10",
          "name": "Трактор 2",
          "terminal_type": "FAS",
          "terminal_id": 236019119
        },
        {
          "uuid": "3022978c-2377-370d-ac50-12dc32d98a6a",
          "name": "Трактор",
          "terminal_type": "FAS",
          "terminal_id": 236036827
        }
      ],
      "autocheck_id": 5690,
      "children": []
    }
  ]
}');

curl_close($curl);

function flatVehicle($vehicles)
{
  $result = [];
  $childrens = $vehicles->{'children'};
  foreach($childrens as $children) {
    $result = array_merge($result, flatVehicle($children));
  }

  $result = array_merge($result, $vehicles->{'objects'});
  
  return $result;
}

$flatVehicles = flatVehicle($treeVehicles);
$data = [
['e9db7638-ca9c-316e-8794-11ba4c996dbd', 203031366,],
['1d6f21e0-0d37-3b42-8f2f-fa65ec72eed9', 336003771,],
['2a4914a2-ae92-3b05-9a57-da11b513d5a9', 336003821,],
['d8d513ea-416c-3027-86de-059895c5a84b', 265001525,],
['26804259-2e29-3300-ad1f-4852df7800ee', 265004218,],
];

$vehicles = array_unique(array_map(function ($item)
{
  return [$item->{'uuid'}, $item->{'terminal_id'}];
}, $flatVehicles), SORT_REGULAR);

//var_dump($vehicles);
//var_dump(array_intersect($data, $vehicles));
var_dump(array_diff_ukey($data, $vehicles));
