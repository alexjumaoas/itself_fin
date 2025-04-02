<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Technician;
use App\Models\Dtruser;
use App\Models\Dts_user;
use App\Models\Job_request;
use App\Models\Request_History;
use App\Models\Activity_request;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    //

    // public function index(){
    //     // , 'division', 'section'
    //     $dts_users = Dts_user::select('id', 'username', 'designation', 'division', 'section')
    //         ->with([
    //             'designationRel' => function ($query){

    //                 $query->select('id', 'description');
    //             },
    //             'divisionRel' => function ($query){
    //                 $query->select('id', 'description');
    //             },
    //             'sectionRel' => function ($query){
    //                 $query->select('id', 'description');
    //             },
    //             'dtrUsers'
    //             ])
    //         ->where('division', 3)
    //         ->where('section', 80)
    //         ->orderBy('id','desc')
    //         ->paginate(10);

    //     // return view('pages.admin.technician', compact('dts_users'));
    //     return view('pages.admin.display_tech', compact('dts_users'));
    // }

    public function index()
    {
        $pendingCount = Activity_request::where('status', 'pending')->count();
        $acceptedCount = Activity_request::where('status', 'accepted')->count();
        $cancelledCount = Activity_request::where('status', 'cancelled')->count();
        $completedCount = Activity_request::where('status', 'completed')->count();
        $completedCount = Activity_request::where('status', 'transferred')->count();
       
        return view("pages.admin.dashboard", compact('pendingCount', 'acceptedCount', 'completedCount','cancelledCount'));
    }

    public function getAllTechnican(){


        $dts_users = Dts_user::select('id', 'username', 'designation', 'division', 'section')
        ->with([
            'designationRel' => function ($query){

                $query->select('id', 'description');
            },
            'divisionRel' => function ($query){
                $query->select('id', 'description');
            },
            'sectionRel' => function ($query){
                $query->select('id', 'description');
            },
            'dtrUsers' => function ($query) {
                // Apply the filter inside the relation itself
                $query->where('usertype', '!=', 2);
                $query->where('usertype', '!=', 1);
            }
            ])
        ->where('division', 3)
        ->where('section', 80)
        ->orderBy('id','desc')
        ->get();

        $technicians = Technician::with('dtrUser.dtsUser.designationRel')
        ->where('status', 'active')
        ->orderBy('id','desc')
        ->paginate(10);
        // dd($technicians);
        return view('pages.admin.display_tech', compact('technicians','dts_users'));
    }

    public function SavedTechnician(Request $req){

        $userId = $req->username;
        $AddTech = Technician::where('userid',  $userId)->first();

        if($AddTech){
            $AddTech->status = "active";
            $AddTech->save();
        }else{
            $AddTech = new Technician();
            $AddTech->userid = $userId;
            $AddTech->status = "active";
        }
      

        $DtruserType = Dtruser::where('username', $userId)->first();
        $DtruserType->usertype = 2;
        $DtruserType->save();

        // $DtsuserType = Dts_user::where('username', $userId)->first();
        // $DtsuserType->user_priv = 2;

        $AddTech->save();

        return response()->json(['message' => 'User added as technician successfully']);
    }

    public function RemoveTechnician(Request $req)
    {

        $removeTech = Technician::where('userid',$req->username)->first();

        if ($removeTech) {
            $removeTech->status = 'inactive';
            $removeTech->save();
        }

        $DtruserType = Dtruser::where('username', $req->username)->first();

        if ($DtruserType) {
            $DtruserType->usertype = 0;
            $DtruserType->save();
        }

        return response()->json(['message' => 'User removed as technician successfully']);
    }

    public function adminCancel(Request $req)
    {
        $user = $req->get('currentUser');

        $cancelled_admin  = new Activity_request();

        $cancelled_admin->job_request_id = $req->request_id;
        $cancelled_admin->request_code = $req->code;
        $cancelled_admin->tech_from = $user->userid;
        $cancelled_admin->remarks = $req->input('cancelRemarks');
        $cancelled_admin->status = "cancelled";
        $cancelled_admin->save();

        return Redirect::back()->with('success', 'Request cancelled successfully');
    }





}
