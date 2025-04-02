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
 

    public function index()
    {
        $activity_reqs = $this->jobRequestService->getJobRequestByStatus('pending');
        $activity_acept = $this->jobRequestService->getJobRequestByStatus('accepted');
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
        $activity->request_code = $request_it->request_code;
        $activity->status = "pending";
        $activity->save();

        return redirect()->route('requestForm')->with('success', 'Request submitted successfully!');
    }

  public function cancelRequest(Request $req, $id){
       $user = $req->get('currentUser');
 
        $act_req = new Activity_request();
        $act_req->job_request_id = $id;
        $act_req->request_code = $req->req_code;
        $act_req->tech_from = $user->userid;
        $act_req->status = "cancelled";
        $act_req->remarks = $req->cancelRemarks;
        $act_req->save();
        return redirect()->route('currentRequest')->with('success', 'successfully cancelled request!');
  }
}
