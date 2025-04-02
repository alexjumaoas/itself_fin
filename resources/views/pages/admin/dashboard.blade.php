@extends('layouts.app')
@section('content')

<style>
    .dash {
        display: block;
        transition: transform 0.3s ease, background-color 0.3s ease;
        text-decoration: none; /* Remove underline */
    }

    .dash:hover {
        transform: scale(1.05); /* Slightly enlarge the card */
    }

    .dash:hover .card {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Add shadow to the card */
    }

    @keyframes moveDown {
        0% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(10px);
        }
        100% {
            transform: translateY(0);
        }
    }
    .arrow-down {
        display: inline-block;
        animation: moveDown 1s infinite;
    }

</style>

<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="fw-bold mb-3">Dashboard</h3>
        @if($userInfo->usertype == 1)
            <h6 class="op-7 mb-2">Administrator Management Dashboard</h6>
        @else
            <h6 class="op-7 mb-2">Technician Dashboard</h6>
        @endif
        
    </div>
    <!-- <div class="ms-md-auto py-2 py-md-0">
        <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
        <a href="#" class="btn btn-primary btn-round">Add Customer</a>
    </div> -->
</div>

<div class="row">
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div
                            class="icon-big text-center icon-primary bubble-shadow-small"
                        >
                        <i class="fas fa-chart-bar"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Total</p>
                            <h4 class="card-title">{{$acceptedCount}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="col-sm-6 col-md-3 dash" href="{{ route('admin.request') }}">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div
                            class="icon-big text-center icon-secondary bubble-shadow-small"
                        >
                        <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Pending</p>
                            <h4 class="card-title">{{$pendingCount}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>

    <a class="col-sm-6 col-md-3 dash" href="{{ route('admin.request') }}">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div
                            class="icon-big text-center icon-danger bubble-shadow-small"
                        >
                        <i class="fas fa-arrow-down arrow-down"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Accepted</p>
                            <h4 class="card-title">{{$cancelledCount}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>

    {{-- <a class="col-sm-6 col-md-2 dash" href="">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div
                            class="icon-big text-center icon-danger bubble-shadow-small"
                        >
                        <i class="fas fa-arrow-down arrow-down"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Transfer</p>
                            <h4 class="card-title">0</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a> --}}

    <a class="col-sm-6 col-md-3 dash" href="{{ route('finished') }}">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div
                            class="icon-big text-center icon-success bubble-shadow-small"
                        >
                        <i class="far fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Finished</p>
                            <h4 class="card-title">{{$completedCount}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
@endsection
