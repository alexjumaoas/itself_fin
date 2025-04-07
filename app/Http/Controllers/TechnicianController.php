<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Job_request;
use App\Models\Request_History;
use App\Models\Technician;
use App\Models\Transfered_Request;
use App\Models\Activity_request;
use Carbon\Carbon;
use App\Services\JobRequestService;
use Illuminate\Support\Facades\Redirect;

class TechnicianController extends Controller
{
    protected $jobRequestService;

    public function __construct(JobRequestService $jobRequestService)
    {
        $this->jobRequestService = $jobRequestService;
    }

    public function requestor(Request $req){

        $user = $req->get('currentUser'); 

        $get_technician = Technician::where('status', 'active')
        ->select('userid')
        ->with('dtrUser:username,fname,lname')
        ->where('userid', '!=', $user->userid)
        ->get();
        
        // $job_pending = $this->jobRequestService->getJobRequestByStatus('pending');
        // $job_pending = $this->jobRequestService->getJobRequestByStatus('transferred');

        $job_pending = collect($this->jobRequestService->getJobRequestByStatus('pending'))
            ->merge($this->jobRequestService->getJobRequestByStatus('transferred'));

        $job_accepted = $this->jobRequestService->getJobRequestByStatus('accepted');
        $job_transferred = $this->jobRequestService->getJobRequestByStatus('transferred');
     
        return view('pages.admin.request',  compact('job_pending','job_accepted','get_technician','job_transferred'));
    }

    // public function requestor(Request $req){
    //     $user = $req->get('currentUser');  
    //     // $job_requests = Job_request::where("status", "pending")->get();
    //     $get_technician = Technician::where('status', 'active')
    //         ->select('userid')
    //         ->with('dtrUser:username,fname,lname')
    //         ->where('userid', '!=', $user->userid)
    //         ->get();
      
    //     $job_pending = self::jobRequestStatus('pending');
    //     $job_accepted = self::jobRequestStatus('accepted');
    //     $job_tranferred = self::jobRequestStatus('transferred');



    //     return view('pages.admin.request',  compact('job_pending', 'job_accepted','get_technician','job_tranferred'));
    //}

    // private function jobRequestStatus($status){

    //     return  Job_request::where("status", $status)
    //     ->with(['requester.divisionRel', 'requester.sectionRel','technician','request_history','transferedRequests']) // Eager load relationships
    //     ->orderby('id', 'desc')
    //     ->get();
    // }

    public function acceptRequest(Request $req, $id, $code)
    {

            $latestaccepted =  Activity_request::where('request_code', $code)
            ->where('status', 'accepted')
            ->orderBy('created_at', 'desc')
            ->first();
            
            $hasaccepted = $latestaccepted ? 1 : 0;
      
            $user = $req->get('currentUser');
            $activityRequest = null;
            $job_req = null;
            if($hasaccepted === 0){

                $act_req = new Activity_request();
                $act_req->tech_from = $user->userid;
                $act_req->request_code = $code;
                $act_req->job_request_id = $id;
                $act_req->status = "accepted";
                $act_req->save();
    
                $job_req = Job_request::where('request_code', $code)->first();
        
    
                $activityRequest = Activity_request::with(['job_req.requester.sectionRel', 'job_req.requester.divisionRel'])
                ->where('id', $act_req->id)
                ->first();
    
                $firebaseData = [
                    'request_code' => $code,
                    'tech_name' => $user->fname . ' ' . $user->lname,
                    'tech_id' => $user->userid,
                    'description' => $job_req->description,
                    'requester_name' => $activityRequest->job_req->requester->fname . ' ' . $activityRequest->job_req->requester->lname,
                    'section' => $activityRequest->job_req->requester->sectionRel->acronym,
                    'division' => $activityRequest->job_req->requester->divisionRel->description,
                    'timestamp' => Carbon::now()->toIso8601String(),
                    'status' => 'accepted'
                ];
    
                session()->flash('success', 'Successfully accepted request!');
                session()->flash('firebaseData', $firebaseData);

            }   

            if ($req->ajax() || $req->wantsJson()) {
                try {
                    
                return response()->json([
                        'success' => true,
                        'fullname' => $activityRequest->job_req->requester->fname . ' ' . $activityRequest->job_req->requester->lname,
                        'message' => 'Successfully accepted request!',
                        'firebaseData' => $firebaseData,
                        'isAccepted' =>  $hasaccepted 
                    ]);
                } catch (\Exception $e) {
                    // Return JSON error response
                    return response()->json([
                        'success' => false,
                        'message' => 'Error: ' . $e->getMessage()
                    ], 500);
                }
            }

            return redirect()->route('technician.request');

       
    }

    public function finished(){

        $job_completed =  $this->jobRequestService->getJobRequestByStatus('completed');

        return view('pages.admin.finished', compact('job_completed'));
    }

    public function done(Request $req){
        
        $user = $req->get('currentUser');
        
        $done_req = new Activity_request();
        $done_req->tech_from = $user->userid;
        $done_req->request_code = $req->code;
        $done_req->job_request_id = $req->request_id;
        $done_req->status = "completed";
        $done_req->action = $req->action;
        $done_req->diagnosis = $req->diagnosis;
        $done_req->resolution_notes = $req->resolution;
        $done_req->save();

        // $done = Request_History::where('request_code', $req->code)->first();
        // $done->action = $req->action;
        // $done->diagnosis = $req->diagnosis;
        // $done->resolution_notes = $req->resolution;
        // $done->completion_date = Carbon::now();
        // $done->save();

        return Redirect::back()->with('success', 'Job well done!');
    }

    public function Transfer(Request $req){
        //Transfered_Request
        $user = $req->get('currentUser');
            
        $tranferred = new Activity_request();
        $tranferred->tech_from = $user->userid;
        $tranferred->tech_to = $req->transferTo;
        $tranferred->request_code = $req->code;
        $tranferred->job_request_id = $req->request_id;
        $tranferred->remarks = $req->transferReason;
        $tranferred->status = "transferred";
        $tranferred->save();

        return Redirect::back()->with('success', 'Request is successfuly transferred');
    }

    public function isAccepted(Request $req){

       $tatestaccepted =  Activity_request::where('request_code', $req->code)
                        ->where('status', 'accpeted')
                        ->orderBy('created_at', 'desc')
                        ->first();

        return response()->json([ 
            'success' =>  $tatestaccepted
        ]);

    }   
}   
