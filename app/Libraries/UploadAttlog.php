<?php

namespace App\Libraries;

use App\Data\AttlogEntity;
use App\Models\AttlogModel;

class UploadAttlog
{
    function post(AttlogEntity $attlogEntity): bool
    {
        $dataForm = [
            'user_id' => $attlogEntity->getUserId(),
            'sn' => $attlogEntity->getSn(),
            'status' => $attlogEntity->getStatus(),
            'date' => $attlogEntity->getDate(),
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('main.server_host') . '/attlog',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $dataForm,
            CURLOPT_HTTPHEADER => array(
                'key: ' . env('main.server_key'),
                'Cookie: ci_session=' . bin2hex(random_bytes(32)) . '; csrf_cookie_name=' . bin2hex(random_bytes(32))
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        if ($response == "OK") {
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