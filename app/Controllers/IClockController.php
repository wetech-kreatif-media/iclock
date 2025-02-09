<?php

namespace App\Controllers;

use App\Data\AttlogEntity;
use App\Libraries\UploadAttlog;
use App\Models\AttlogModel;
use CodeIgniter\RESTful\ResourceController;

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
        array  $rawData
    )
    {
//        222310045	2023-11-16 17:31:37	1	1	0	0	0	0	0	0
//        222310045	2023-11-16 17:31:37	1	1	0	0	0	0	0	0

        $attlogModel = new AttlogModel();
        log_message('info', 'SN: ' . $SN);
        log_message('info', 'RawData: ' . json_encode($rawData));
        // Loop through each line and parse the data
        foreach ($rawData as $line) {
            $data = explode("\t", $line);
            if ($line != '') {
                $user_id = $data[0];//contains the first value (e.g., 114)
                $date = $data[1];//contains the timestamp (e.g., 2023-09-23 01:28:15)
                $status = $data[2]; //, $data[3], $data[4], $data[5], etc., contain other
                if ($attlogModel->check($user_id, $date, $status) == 0 && $data[0] != '') {
                    $attlogEntity = new AttlogEntity(
                        0,
                        $user_id,
                        $SN,
                        $status,
                        $date,
                        0
                    );

                    log_message('info', 'HumanData: ' . json_encode($data));
                    $getLogId = $attlogModel->insert($attlogEntity->getDataArray());
                    $attlogEntity->setId($getLogId);
                     (new UploadAttlog())->post($attlogEntity);
                }
            }
        }
        echo "OK";
    }
}
