<?php

namespace App\Commands;

use App\Data\AttlogEntity;
use App\Libraries\UploadAttlog;
use App\Models\AttlogModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CheckReupload extends BaseCommand
{
    protected $group = 'Check';
    protected $name = 'check:reupload';
    protected $description = 'Displays basic application information.';

    public function run(array $params): void
    {
        CLI::write('Begin running script', 'green');
        $data = (new AttlogModel)->check_zero_upload();
        $attlogEntity = new AttlogEntity(0, '', '', '', '', 0);
        foreach ($data as $value) {
            $attlogEntity->setId($value['id']);
            $attlogEntity->setUserId($value['user_id']);
            $attlogEntity->setSn($value['sn']);
            $attlogEntity->setStatus($value['status']);
            $attlogEntity->setDate($value['date']);
            $attlogEntity->setUpload($value['upload']);
            $status = (new UploadAttlog())->post($attlogEntity);
            CLI::write("ID: $value[id] $status", 'green');
        }
        CLI::write('Finish run script', 'green');
    }
}