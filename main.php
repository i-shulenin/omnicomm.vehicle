<?php

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
      "uuid": "1828d132-fcad-3be1-a14e-1bc48ceea4eb",
      "name": "ДГУ_5",
      "terminal_type": "FAS",
      "terminal_id": 203028815
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
        "children": []
      }]
    },
    {
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
    },
    {
      "id": 5664,
      "parentGroupId": 4101,
      "name": "CAN bus",
      "objects": [],
      "autocheck_id": 5664,
      "children": []
    },
    {
      "id": 5667,
      "parentGroupId": 4101,
      "name": "АТЗ",
      "objects": [{
        "uuid": "0bf23869-2c22-3594-85df-2d1217e98ee6",
        "name": "АТЗ",
        "terminal_type": "FTC",
        "terminal_id": 216002404
      }],
      "autocheck_id": 5667,
      "children": []
    },
    {
      "id": 5862,
      "parentGroupId": 4101,
      "name": "Fuel per kg",
      "objects": [{
        "uuid": "d240a4bb-4a8b-3c69-9332-3f7b13be68ee",
        "name": "ТС_КГ",
        "terminal_type": "FAS",
        "terminal_id": 203031689
      }],
      "autocheck_id": 5862,
      "children": []
    }
  ]
}');

$existingVehicles = [
  [
    'c949b995-c3d7-3946-9767-3c5b73a64349',
    203026865,
  ],
  [
    '765ed63d-e831-305c-81db-af99180365a6',
    203028996,
  ],
  [
    'd8d513ea-416c-3027-86de-059895c5a84b',
    265001525,
  ],
  [
    '26804259-2e29-3300-ad1f-4852df7800ee',
    265004218,
  ],
  [
    '1d6f21e0-0d37-3b42-8f2f-fa65ec72eed9',
    336003771,
  ],
  [
    '2a4914a2-ae92-3b05-9a57-da11b513d5a9',
    336003821,
  ],
  [
    'e9db7638-ca9c-316e-8794-11ba4c996dbd',
    203031366,
  ],
  [
    '0bf23869-2c22-3594-85df-2d1217e98ee6',
    216002404,
  ],
  [
    'd240a4bb-4a8b-3c69-9332-3f7b13be68ee',
    203031689,
  ],
  [
    '3c635eff-77ae-3c09-bf5b-410c64f2ac13',
    202002469,
  ],
  [
    'ba10ce0e-3613-379d-a5b8-7383faac29b1',
    203028739,
  ],
  [
    '1828d132-fcad-3be1-a14e-1bc48ceea4eb',
    203028815,
  ],
];

function flatVehicle($vehicles): array
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
$uniqueVehicles = array_unique(array_map(function ($item)
{

  return [$item->{'uuid'}, $item->{'terminal_id'}];
}, $flatVehicles), SORT_REGULAR);

var_dump($flatVehicles);
var_dump($existingVehicles);
var_dump($uniqueVehicles);
