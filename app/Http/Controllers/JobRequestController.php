<?php

namespace App\Http\Controllers;

use App\Models\Job_request;
use App\Models\Dtruser;
use App\Models\Activity_request;
use App\Services\JobRequestService;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class JobRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $jobRequestService;

     public function __construct(JobRequestService $jobRequestService)
     {
         $this->jobRequestService = $jobRequestService;
     }
 

    public function index(Request $req)
    {
        $user = $req->get('currentUser');
        $activity_reqs = $this->jobRequestService->getJobRequestByStatus('pending',null,$user->username);
        $activity_finish = $this->jobRequestService->getJobRequestByStatus('completed',null,$user->username);
        $activity_acept = $this->jobRequestService->getJobRequestByStatus('accepted',null,$user->username)
            ->merge($this->jobRequestService->getJobRequestByStatus('transferred',null,$user->username));
     
        return view('pages.requestor.newRequest', compact('activity_reqs','activity_acept'));
    }
    
    public function saverequest(Request $req){
        $user = $req->get('currentUser');

        $descriptions = [
            $req->check_comp,
            $req->check_intern,
            $req->check_Mon,
            $req->check_mouse,
            $req->install_print,
            $req->install_soft,
            $req->bio_reg,
            $req->system_tech,
            $req->check_others, // Ensure it is not null if applicable
            $req->others_input, // This is a text input
        ];

        $filteredDescriptions = array_filter($descriptions, function ($value) {
            return !is_null($value) && $value !== '';
        });

        // Implode array into a comma-separated string
        $descriptionString = implode(', ', $filteredDescriptions);

        $request_it = new Job_request();

        $request_it->request_code = now()->format('YmdHis') . '-' . rand(1000, 9999);
        $request_it->description = $descriptionString;
        $request_it->requester_id = $user->userid;
        $request_it->request_date = Carbon::now();
        $request_it->save();

        $activity = new Activity_request();
        $activity->job_request_id = $request_it->id;
        $activity->requester_id = $user->username;
        $activity->request_code = $request_it->request_code;
        $activity->status = "pending";
        $activity->save();

        $activityRequest = Activity_request::with(['job_req.requester.sectionRel', 'job_req.requester.divisionRel'])
        ->where('id', $activity->id)
        ->first();

        return redirect()->route('currentRequest')
        ->with('success', 'Successfully created request!')
        ->with('PendingData', [
            'request_code' =>  $request_it->request_code,
            'request_date' => $request_it->request_date,
            'job_request_id' => $request_it->id,
            'description' => $request_it->description,
            'requester_name' => optional($activityRequest->job_req->requester)->fname . ' ' . optional($activityRequest->job_req->requester)->lname,
            'section' => $activityRequest->job_req->requester->sectionRel->acronym,
            'division' => $activityRequest->job_req->requester->divisionRel->description,
            'timestamp' => Carbon::now()->toIso8601String(),
            'status' => 'pending'
        ]);
    }

    public function cancelRequest(Request $req, $id){
        $user = $req->get('currentUser');

        $existing = Activity_request::where('job_request_id', $id)
            ->whereIn('status', ['accepted', 'cancelled'])
            ->orderBy('created_at', 'desc')
            ->first();

            if ($existing) {
                return response()->json([
                    'status' => 'exists',
                    'message' => 'This request has already been ' . $existing->status . '.'
                ]);
            }

        $job_req = Job_request::where('request_code', $req->req_code)->first();
        
        $act_req = new Activity_request();
        $act_req->job_request_id = $id;
        $act_req->requester_id = $job_req->requester_id;
        $act_req->request_code = $req->req_code;
        $act_req->tech_from = $user->userid;
        $act_req->status = "cancelled";
        $act_req->remarks = $req->cancelRemarks;
        $act_req->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully cancelled request!'
        ]);
    }
}
