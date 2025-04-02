@extends('layouts.appClient')
@section('content')

<?php



?>

<div class="container">
    <!-- CURRENT REQUEST-->
    <div class="row">
        <div class="page-header">
            <h3 class="fw-bold">CURRENT REQUEST(S)</h3>
        </div>
        @forelse($activity_reqs as $pending)
            <div class="col-md-4">
                <div class="card card-post card-round" style="border-top: 3px solid #f25961;">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="avatar">
                                <img src="{{ asset('assets/img/profile2.jpg') }}" alt="..." class="avatar-img rounded-circle">
                            </div>
                            <div class="info-post ms-2">
                                <p class="username">{{$pending->job_req->requester->fname . ' ' . $pending->job_req->requester->lname}}</p>
                                <p class="text text-muted">{{$pending->job_req->requester->sectionRel->acronym}} Section {{ $pending->job_req->requester->divisionRel->description}}</p>    
                            </div>
                        </div>
                        <div class="separator-solid"></div>
                        <p class="card-category text-info mb-1">
                            <a>{{ \Carbon\Carbon::parse($pending->job_req->request_date)->format('F d, Y h:i A') }}</a>
                        </p>
                        <h3 class="card-title">
                            <a>{{$pending->request_code}}</a>
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
                     <button class="btn btn-danger bubble-shadow" data-bs-toggle="modal" data-bs-target="#cancelRequestModal"
                        onclick="setCancelRequest('{{ $pending->job_req->id }}', '{{ $pending->job_req->request_code ?? '' }}')">
                        Cancel Request
                    </button> 
                </div>
            </div>
        @empty
            <!-- FOR CURRENT REQUEST, IF EMPTY OR NOT -->
            <div class="col-sm-6 col-md-12">
                <div class="card card-stats card-danger card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="timeline-heading">
                                    <h4 class="timeline-title">There are no CURRENT request</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- ONGOING REQUEST-->
    <div class="row">
        <div class="page-header" style="margin-bottom: 0; margin-top: 10px;">
            <h3 class="fw-bold mb-3">ONGOING REQUEST(S)</h3>
        </div>
        @forelse($activity_acept as $accepted)
        <div class="col-md-4">
            <div class="card card-post card-round" style="border-top: 3px solid #6861ce;">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="avatar">
                            <img src="{{ asset('assets/img/profile2.jpg') }}" alt="..." class="avatar-img rounded-circle">
                        </div>
                        <div class="info-post ms-2">
                            <p class="username">{{$accepted->job_req->requester->fname . ' ' . $accepted->job_req->requester->lname}}</p>
                            <p class="date text-muted">{{$accepted->job_req->requester->sectionRel->acronym}} Section {{ $accepted->job_req->requester->divisionRel->description}}</p>
                        </div>
                    </div>
                    <div class="separator-solid"></div>
                    <p class="card-category text-info mb-1">
                        <a>{{\Carbon\Carbon::parse($accepted->job_req->request_date)->format('F d, Y h:i A')}}</a>
                    </p>
                    <h3 class="card-title">
                        <a>{{$accepted->request_code}}</a>
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
                </div>
                @php
                    $user = App\Models\Dtruser::where('username', $accepted->tech_from)->first();
                @endphp
                <div class="card-footer text-center bubble-shadow" style="background-color: #6861ce; color: white; padding: 10px;">
                    <strong> {{$user ? $user->fname. ' ' . $user->mname. ' ' . $user->lname : 'N/A'}}</strong> is on the way
                </div>
            </div>
        </div>
        @empty
            <!-- FOR ONGOING REQUEST, IF EMPTY OR NOT -->
            <div class="col-sm-6 col-md-12">
                <div class="card card-stats card-round" style="background-color: #8F99E8; color: white;">
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
</div>

@include('pages.modal.cancelCurrentReqModal')

<script>
    function setCancelRequest(jobId, requestCode) {
        console.log("requestCode", requestCode);
        let form = document.getElementById('cancelRequestForm');
        let action = form.getAttribute('action').replace(':id', jobId);
        form.setAttribute('action', action);
        document.getElementById('cancelJobId').value = jobId;
        document.getElementById('req_code').value = requestCode;
    }
</script>

@endsection
