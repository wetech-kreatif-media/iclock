<?php

namespace App\Models;

use CodeIgniter\Model;

class AttlogModel extends Model
{
    protected $table = 'attlog'; // Set the table name

    protected $primaryKey = 'id'; // Set the primary key field name

    protected $allowedFields = ['user_id', 'sn', 'status', 'date', 'upload']; // Define the fields that can be inserted or updated

    protected $useTimestamps = false; // Set to true if you want to use created_at and updated_at timestamps

    // Define validation rules if needed
    protected $validationRules = [];


    // Other model methods and properties can be added as needed
}
