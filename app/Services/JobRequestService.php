<?php

namespace App\Services;

use App\Models\Activity_request;
use Illuminate\Support\Facades\DB;

class JobRequestService
{
    public function getJobRequestByStatus($status, $technicianId = null)
    {

        $latestIds = Activity_request::select(DB::raw('MAX(id) as max_id'))
            ->groupBy('job_request_id')
            ->pluck('max_id');
      
        $query =  Activity_request::whereIn('id', $latestIds);

        if($query !== null){
            $query->where('status', $status);
        }
        
        if ($technicianId) {

            if ($status === 'transferred') {
                $query->where('tech_to', $technicianId); // Filter by tech_to for transferred jobs
            } else {
                $query->where('tech_from', $technicianId); // Filter by tech_from for all other statuses
            }
        }
      
        return $query->with('job_req.requester.divisionRel', 'job_req.requester.sectionRel')
        ->get();
    }
}