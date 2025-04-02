@extends('layouts.app')
@section('content')
<?php

use App\Models\Dtruser;

?>
<!-- PENDING CARDS -->
<div class="row">
    <div class="page-header">
        <h1 class="fw-bold">PENDING</h1>
    </div>
    @php
        $firstEnabled = true; // Enable only the first pending job
    @endphp
    @forelse($job_pending as $pending)
        @php
            $user = App\Models\Dtruser::where('username', $pending->tech_from)->first();
        @endphp
   
        @if($pending->status == "transferred" && (int) $userInfo->username === $pending->tech_from)

        @else
            <div class="col-md-3">
                <div class="card card-post card-round" style="border-top: 3px solid #f25961;">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="avatar">
                                <img src="{{ asset('assets/img/profile2.jpg') }}" alt="..." class="avatar-img rounded-circle">
                            </div>
                            <div class="info-post ms-2">
                                <p class="username"> {{$pending->job_req->requester->fname . ' ' . $pending->job_req->requester->lname}} </p>
                                <p class="date text-muted">{{$pending->job_req->requester->sectionRel->acronym}} Section {{ $pending->job_req->requester->divisionRel->description}}</p>
                            </div>
                        </div>
                        <div class="separator-solid"></div>
                        @if($userInfo->usertype === 2)
                            @if($pending->status == "transferred")
                                Transfer From <strong>: {{ $user ? $user->fname. ' ' . $user->mname. ' ' . $user->lname : 'N/A'}}</strong>
                            @endif
                        @endif
                        <p class="card-category text-info mb-1">
                            <a>{{ \Carbon\Carbon::parse($pending->job_req->request_date)->format('F d, Y h:i A') }}</a>
                        </p>
                        <h3 class="card-title">
                            <a>{{$pending->request_code}} </a>
                        </h3>
                        <div>
                            <p style="line-height: .5; font-weight: 600; display: inline-block; margin-right: 10px;">Request(s):</p>
                            <ul>
                            @php
                                $tasks = explode(',', $pending->job_req->description);
                                $tasks = array_map('trim', $tasks); // Trim whitespace from each item
                            @endphp
                            @foreach($tasks as $index => $task)
                                @if($task === 'Others' && isset($tasks[$index + 1]))
                                    <li>
                                        <label>Others:</label>
                                        {{ $tasks[$index + 1] }}
                                    </li>
                                @elseif($index === 0 || ($tasks[$index - 1] !== 'Others'))
                                    <li>
                                        <label>{{ $task }}</label>
                                    </li>
                                @endif
                            @endforeach
                            </ul>
                        </div>
                    </div>
                    @if($userInfo->usertype === 2)
                    @if($pending->status == "transferred")
                            <form id="acceptForm" style="margin-bottom: 0px;"
                                action="{{ route('technician.accept', ['job' => $pending->job_req->id, 'code' => $pending->job_req->request_code]) }}"
                                method="POST">
                                @csrf
                                <button class="btn btn-warning w-100 bubble-shadow" id="alert_demo_8">
                                    Accept
                                </button>
                            </form> 
                    @else
                        <form id="acceptForm" style="margin-bottom: 0px;"
                                action="{{ route('technician.accept', ['job' => $pending->job_req->id, 'code' => $pending->job_req->request_code]) }}"
                                method="POST">
                                @csrf
                                <button class="btn btn-danger w-100 bubble-shadow" id="alert_demo_8"
                                    @if(!$firstEnabled) disabled @endif>
                                    Accept
                                </button>
                            </form> 
                            @php
                                $firstEnabled = false; // Disable all other buttons after the first one
                            @endphp
                    @endif
                    @endif
                    @if($userInfo->usertype === 1)
                        <button class="btn btn-danger w-100 bubble-shadow"
                            data-bs-toggle="modal"
                            data-bs-target="#cancelModal"
                            data-id="{{ $pending->job_req->id }}"
                            data-code="{{$pending->job_req->request_code}}">
                            Cancel
                        </button> 
                    @endif
                </div>

            </div>
        @endif
    @empty
        <!-- FOR ONGOING REQUEST, IF EMPTY OR NOT -->
        <div class="col-sm-6 col-md-12">
            <div class="card card-stats card-round" style="background-color: #B8E7BA;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">There are no PENDING request</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- ONGOING CARDS -->
<div class="row">
    <div class="page-header" style="margin-bottom: 0; margin-top: 10px;">
        <h1 class="fw-bold mb-3">ONGOING</h1>
    </div>
    <!-- PUT A FOR-LOOP CONTITION HERE -->
    @forelse($job_accepted as $accepted)
        <div class="col-md-3">
            <div class="card card-post card-round" style="border-top: 3px solid #6861ce;">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="avatar">
                            <img src="{{ asset('assets/img/profile2.jpg') }}" alt="..." class="avatar-img rounded-circle">
                        </div>
                        <div class="info-post ms-2">
                            <p class="username"> {{$accepted->job_req->requester->fname . ' ' . $accepted->job_req->requester->lname}}</p>
                            <p class="text text-muted">{{$accepted->job_req->requester->sectionRel->acronym}} Section {{ $accepted->job_req->requester->divisionRel->description}}</p>
                        </div>
                    </div>
                    <div class="separator-solid"></div>
                    <p class="card-category text-info mb-1">
                        <a>{{\Carbon\Carbon::parse($accepted->job_req->request_date)->format('F d, Y h:i A')}}</a>
                    </p>
                    <h3 class="card-title">
                        <a>{{$accepted->job_req->request_code}}</a>
                    </h3>
                    <div>
                        <p style="line-height: .5; font-weight: 600; display: inline-block; margin-right: 10px;">Request(s):</p>
                        <ul>
                            @php
                                $tasks = explode(',', $accepted->job_req->description);
                                $tasks = array_map('trim', $tasks); // Trim whitespace from each item
                            @endphp
                            @foreach($tasks as $index => $task)
                                @if($task === 'Others' && isset($tasks[$index + 1]))
                                    <li>
                                        <label>Others:</label>
                                        {{ $tasks[$index + 1] }}
                                    </li>
                                @elseif($index === 0 || ($tasks[$index - 1] !== 'Others'))
                                    <li>
                                        <label>{{ $task }}</label>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    @if($userInfo->usertype == 2)
                        @if($accepted->tech_from == $userInfo->userid)
                            <button class="text-center btn btn-warning mt-2"
                                style="color: white; padding: 4px 6px;"
                                data-bs-placement="right"
                                data-bs-toggle="modal" data-bs-target="#transferModal"
                                title="Transfer" id="transferBtn"
                                data-code='{{$accepted->job_req->request_code}}'
                                data-id = '{{$accepted->job_req->id}}'
                                data-technicians='@json($get_technician)'>
                                <i class="fas fa-handshake" style="font-size: 18px;"></i>
                            </button>
                        @endif
                    @endif
                </div>
                @php
                    $user = App\Models\Dtruser::where('username', $accepted->tech_from)->first();
                @endphp
                @if($userInfo->usertype == 1)
                    <div class="card-footer text-center bubble-shadow" style="background-color: #6861ce; color: white; padding: 10px;">
                      <strong>Accepted by : {{$user ? $user->fname. ' ' . $user->mname. ' ' . $user->lname : 'N/A'}}</strong>
                    </div>
                @else
                    @if($accepted->tech_from == $userInfo->userid)
                    <div class="card-footer text-center bubble-shadow" style="background-color: #6861ce; color: white; padding: 10px; cursor: pointer"
                        data-code='{{$accepted->job_req->request_code}}'
                        data-id = '{{$accepted->job_req->id}}'
                        data-bs-toggle="modal" data-bs-target="#technicianModal">
                        Done
                    </div>
                    @else
                    <div class="card-footer text-center bubble-shadow" style="background-color: #6861ce; color: white; padding: 10px;">
                       <strong>Accepted by : {{ $user ? $user->fname. ' ' . $user->mname. ' ' . $user->lname : 'N/A'}}</strong> 
                    </div>
                    @endif
                @endif
            </div>
        </div>
    @empty
        <!-- FOR ONGOING REQUEST, IF EMPTY OR NOT -->
        <div class="col-sm-6 col-md-12">
            <div class="card card-stats card-round" style="background-color: #B8E7BA;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">There are no ONGOING request</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforelse
</div>


<!-- TRANSFER CARDS -->
<div class="row">
    <div class="page-header" style="margin-bottom: 0; margin-top: 10px;">
        <h1 class="fw-bold mb-3">TRANSFERRED</h1>
    </div>
    <!-- PUT A FOR-LOOP CONTITION HERE -->
    @forelse($job_transferred as $transferred) 
       {{-- @foreach($transferred->transferedRequests as $trans) --}}
           @if((int)$transferred->tech_from === (int)$userInfo->userid || $userInfo->usertype == 1)
                <div class="col-md-3">
                    <div class="card card-post card-round" style="border-top: 3px solid #ffad46;">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="avatar">
                                    <img src="{{ asset('assets/img/profile2.jpg') }}" alt="..." class="avatar-img rounded-circle">
                                </div>
                                <div class="info-post ms-2">
                                    <p class="username"> {{$transferred->job_req->requester->fname . ' ' . $transferred->job_req->requester->lnamee}}</p>
                                    <p class="date text-muted">{{$transferred->job_req->requester->sectionRel->acronym}} Section {{ $transferred->job_req->requester->divisionRel->description}}</p>
                                </div>
                            </div>
                            <div class="separator-solid"></div>
                            <p class="card-category text-info mb-1">
                                <a>{{\Carbon\Carbon::parse($transferred->job_req->request_date)->format('F d, Y h:i A')}}</a>
                            </p>
                            <h3 class="card-title">
                                <a>{{$transferred->request_code}}</a>
                            </h3>
                            <div>
                                <p style="line-height: .5; font-weight: 600; display: inline-block; margin-right: 10px;">Request(s):</p>
                                <ul>
                                @php
                                    $tasks = explode(',', $transferred->job_req->description);
                                    $tasks = array_map('trim', $tasks); // Trim whitespace from each item
                                @endphp
                                @foreach($tasks as $index => $task)
                                    @if($task === 'Others' && isset($tasks[$index + 1]))
                                        <li>
                                            <label>Others:</label>
                                            {{ $tasks[$index + 1] }}
                                        </li>
                                    @elseif($index === 0 || ($tasks[$index - 1] !== 'Others'))
                                        <li>
                                            <label>{{ $task }}</label>
                                        </li>
                                    @endif
                                @endforeach
                                </ul>
                            </div>
                        </div>
                        @php
                            $dtrUser = Dtruser::where('userid',$transferred->tech_from)->first();
                            $dtrUser_to = Dtruser::where('userid',$transferred->tech_to)->first();
                        @endphp
                        @if($userInfo->usertype == 1)
                            <div class="card-footer text-center bubble-shadow" style="background-color: #ffad46; color: white; padding: 10px;">
                                <strong>Transferred from : {{ $dtrUser ? $dtrUser->fname . ' ' . $dtrUser->lname : 'N/A' }}</strong><br>
                                <strong>Transferred to : {{ $dtrUser_to ? $dtrUser_to->fname . ' ' . $dtrUser_to->lname : 'N/A' }}</strong>
                            </div>
                        @else
                            <div class="card-footer text-center bubble-shadow" style="background-color: #ffad46; color: white; padding: 10px;">
                                <strong>Transferred to : {{ $dtrUser_to ? $dtrUser_to->fname . ' ' . $dtrUser_to->lname : 'N/A' }}</strong><br>
                            </div>
                        @endif
                    </div>
                </div>
            @endif 
        {{--@endforeach --}}
    @empty
        <!-- PUT CONDITION HERE FOR TRANSFER REQUEST, IF EMPTY OR NOT -->
        <div class="col-sm-6 col-md-12">
            <div class="card card-stats card-round" style="background-color: #B8E7BA;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">There are no TRANSFER request</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforelse
</div> 

@include('pages.modal.cancelAdminReqModal')
@include('pages.modal.doneRequestModal')
@include('pages.modal.transferModal')


@if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            swal({
                title: "Success!",
                text: "{{ session('success') }}",
                icon: "success",
                button: "OK",
                timer: 5000 // Auto close after 3 seconds
            });
        });

    </script>
@endif

@endsection
