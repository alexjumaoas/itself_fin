<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfered_Request extends Model
{
    protected $table = 'transfered__requests';

    protected $fillable = [
        'job_request_id', 'transfer_from','transfer_to'
    ];
}
