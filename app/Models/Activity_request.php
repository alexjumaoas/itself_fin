<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity_request extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'job_request_id','request_code','tech_from','tech_to','remarks','status'
    ];

    public function job_req()
    {
        return $this->belongsTo(Job_request::class, 'job_request_id', 'id');
    }

    // public function requester()
    // {
    //     return $this->belongsTo(Dts_user::class, 'requester_id', 'username');
    // }

    // // Accessing the requester through job_req
    // public function job_req_requester()
    // {
    //     return $this->hasOneThrough(
    //         Dts_user::class,           // Final Model (Target)
    //         Job_request::class,        // Intermediate Model
    //         'requester_id',                      // Job_request's primary key
    //         'username',                // Dts_user's primary key (Assuming username is the key)
    //         'job_request_id',          // Activity_request's foreign key
    //         'requester_id'             // Job_request's foreign key
    //     );
    // }
}
