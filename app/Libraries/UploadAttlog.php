<?php

namespace App\Libraries;

use App\Data\AttlogEntity;
use App\Models\AttlogModel;
use Config\Services;

class UploadAttlog
{
    function post(AttlogEntity $attlogEntity): bool
    {
        $options = [
            'baseURI' => env('main.server_host'),
            'timeout' => 3,
            'headers' => [
                'key' => env('main.server_key'),
            ],
            'verify' => false,
            'debug' => true
        ];
        $client = Services::curlrequest($options);
        $client->request('POST', '/attlog', [
            'form_params' => [
                'user_id' => $attlogEntity->getUserId(),
                'sn' => $attlogEntity->getSn(),
                'status' => $attlogEntity->getStatus(),
                'date' => $attlogEntity->getDate(),
            ]
        ]);
        if ($client->getBody() == 'OK') {
            try {
                return (new AttlogModel)->update($attlogEntity->getId(), ['upload' => 1]);
            } catch (\ReflectionException $e) {
                log_message('error', "gagal update " . $e->getMessage());
                return false;
            }
        }
        return false;
    }
}