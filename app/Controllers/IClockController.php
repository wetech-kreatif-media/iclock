<?php

namespace App\Controllers;

use App\Models\AttlogModel;
use CodeIgniter\RESTful\ResourceController;
use Config\Services;

class IClockController extends ResourceController
{
    public function cdata()
    {
        // Get the SN, options, language, and pushver parameters from the URL
        // Get the request data
        $SN = $this->request->getGet('SN');
        $table = $this->request->getGet('table');
        // Get the raw POST data
        $rawData = file_get_contents('php://input');

        // Split the raw data into lines
        $rawData = explode("\n", $rawData);

        switch ($table) {
            case 'ATTLOG':
                $this->attlog($SN, $rawData);
                break;

            default:
                echo 'OK';
                break;
        }
    }


    function get_cdata()
    {
        // Get the SN, options, language, and pushver parameters from the URL
        $sn = $this->request->getGet('SN');
        $pushver = $this->request->getGet('pushver');

        // Perform any parsing or processing here if needed
        log_message('info', 'SN: ' . $sn);
        log_message('info', 'pushver: ' . $pushver);
        if (isset($pushver)) {
            return $this->response->setBody("GET OPTION FROM: $sn
ATTLOGStamp=None
OPERLOGStamp=9999
ATTPHOTOStamp=None
ErrorDelay=30
Delay=10
TransTimes=00:00;14: 05
Transinterval=1
TransFlag=AttLog
TimeZone=7
Realtime=1
Encrypt=None");
        }
        return "";
    }

    public function getrequest()
    {
        return $this->response->setBody('OK');
    }

    public function attlog(
        string $SN,
        array $rawData
    ) {
        $options = [
            'baseURI' => env('main.server_host'),
            'timeout' => 3,
            'headers' => [
                'key' => env('main.server_key'),
            ],
            'verify' => false
        ];
        $client = Services::curlrequest($options);
        $attlogModel = new AttlogModel();
        log_message('info', 'SN: ' . $SN);
        log_message('info', 'RawData: ' . json_encode($rawData));
        // Loop through each line and parse the data
        foreach ($rawData as $line) {
            $data = explode("\t", $line);
            if ($line != '') {
                $user_id = $data[0];//contains the first value (e.g., 114)
                $date = $data[1];//contains the timestamp (e.g., 2023-09-23 01:28:15)
                $status = $data[2]; //, $data[3], $data[4], $data[5], etc., contain other values
                // Do something with the parsed data
                // For example, you can insert it into a database or perform any other processing

                $data = [
                    'user_id' => $user_id,
                    'sn' => $SN,
                    'status' => $status,
                    'date' => $date,
                    'upload' => 0
                ];
                $getLogId = $attlogModel->insert($data);
                $respond = $client->request('POST', '/attlog', [
                    'form_params' => [
                        'user_id' => $user_id,
                        'sn' => $SN,
                        'status' => $status,
                        'date' => $date,
                    ]
                ]);
                log_message('info', 'Respond: ' . $respond->getBody());
                if ($respond->getBody() == 'OK') {
                    $attlogModel->update($getLogId, ['upload' => 1]);
                }
            }
        }
        echo 'OK';
        return $this->response->setBody('OK');
    }
}
