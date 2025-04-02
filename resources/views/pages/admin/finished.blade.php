@extends('layouts.app')
@section('content')

<style>
* {
  box-sizing: border-box;
  font-family: sans-serif;
}

.box .header .part_one,
.box .header .part_two,
.box .content {
  /* background-color: #1572e8; */
  background-color: #2A73BA;
}

.box .header {
  display: flex;
}

.box .header .part_one {
  width: 200px;
  height: 30px;
}

.box .header .part_two {
  width: 100px;
  height: 30px;
  position: relative;
}

.box .header .part_two:before {
  content: "";
  position: absolute;
  bottom: 0px;
  left: 0;
  height: 30px;
  width: 100%;
  border-bottom-left-radius: 10px;
  background: white;
}

.box .content {
  height: 200px;
  border-radius: 0px 10px 10px 10px;
  padding: 10px;
  color: white;
}

.box .header .part_one {
  width: 200px;
  border-radius: 10px 10px 0px 0px;
}

.clearfix::after {
    content: "";
    clear: both;
    display: table;
}

@keyframes shake {
    0% { transform: translateX(0); }
    25% { transform: translateX(-3px); }
    50% { transform: translateX(3px); }
    75% { transform: translateX(-3px); }
    100% { transform: translateX(0); }
}

.box:hover {
    animation: shake 0.3s ease-in-out;
}

#dateFilter, #dateGenerate{
    background: white !important;
    border-color: #ebedf2 !important;
    opacity: 1 !important;
}
</style>

<h3 class="fw-bold mb-3">REPORTS</h3>
<div class="row">
    <div class="col-md-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #5867dd;">
                        <div class="card-title" style="color: white;">Filter</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="dateFilter">Date Range</label>
                            <input type="text" class="form-control" id="dateFilter" placeholder="Select Date Range">
                        </div>
                        <div class="form-group">
                            <label for="defaultSelect">Division</label>
                            <select class="form-select form-control" id="defaultSelect">
                                <option></option>
                                <option>RD/ARD</option>
                                <option>LHSD</option>
                                <option>RLED</option>
                                <option>MSD</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="defaultSelect">Section</label>
                            <select class="form-select form-control" id="defaultSelect">
                                <option></option>
                                <option>ICTU</option>
                                <option>Planning</option>
                                <option>Budget</option>
                                <option>PU</option>
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-secondary w-100">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #5867dd;">
                        <div class="card-title" style="color: white;">Genarate Report</div>
                    </div>
                    <div class="card-body">
                        <!-- <div class="form-group">
                            <label for="startMonth">Start Month</label>
                            <input type="text" class="form-control" id="startMonth" placeholder="Start Month">
                        </div>
                        <div class="form-group">
                            <label for="endMonth">End Month</label>
                            <input type="text" class="form-control" id="endMonth" placeholder="End Month">
                        </div> -->
                        <div class="form-group">
                            <label for="dateGenerate">Date Range</label>
                            <input type="text" class="form-control" id="dateGenerate" placeholder="Select Date Range">
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-secondary w-100">Generate</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-header" style="background-color: #5867dd;">
                <div class="card-title" style="color: white;">Finished Request</div>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($job_completed as $completed)
                        <div class="col-md-3 mb-4">
                            <div class="box bubble-shadow">
                                <div class="header">
                                    <div class="part_one"><p style="margin-left: 8px; margin-top: 4px; color: white; font-size: 18px;">
                                        <!-- {{ \Carbon\Carbon::parse($completed->request_history->completion_date)->format('F j, Y') }} -->
                                          2025-001
                                    </p></div>
                                    <div class="part_two"></div>
                                </div>
                                <div class="content">
                                    <div class="mb-2" style="text-align: right;">{{ \Carbon\Carbon::parse($completed->request_history->completion_date)->format('F j, Y') }}</div>
                                    <div class="mb-2" style="font-size: 18px;">{{$completed->request_history->request_code}}</div>
                                    <div class="op-8">Started: {{ \Carbon\Carbon::parse($completed->request_history->assigned_date)->format('h:i:s A') }}</div>
                                    <div class="op-8">Ended: {{ \Carbon\Carbon::parse($completed->request_history->completion_date)->format('h:i:s A') }}</div>
                                    <div class="mt-5">
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#jobModal{{$completed->id}}">Show Request</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('pages.modal.showRequestModal')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        flatpickr("#dateFilter, #dateGenerate", {
            mode: "range",
            dateFormat: "M j, Y",
        });
    });
</script>

@endsection
