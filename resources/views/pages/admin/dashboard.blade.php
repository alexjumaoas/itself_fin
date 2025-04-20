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
                            <h4 class="card-title">{{$totalRequest}}</h4>
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
                            <h4 class="card-title">{{$totalpending}}</h4>
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
                            <h4 class="card-title">{{$acceptedCount}}</h4>
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

    {{-- <a class="col-sm-6 col-md-3 dash">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div
                            class="icon-big text-center icon-warning bubble-shadow-small"
                        >
                        <i class="fas fa-undo-alt"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Cancelled</p>
                            <h4 class="card-title">{{$cancelledCount}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a> --}}
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Line Chart</div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Bar Chart</div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Pie Chart</div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="pieChart" style="width: 50%; height: 50%"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('/assets/js/plugin/chart.js/chart.min.js') }}"></script>
<script>
    var lineChart = document.getElementById("lineChart").getContext("2d"),
        barChart = document.getElementById("barChart").getContext("2d"),
        pieChart = document.getElementById("pieChart").getContext("2d");

    var myLineChart = new Chart(lineChart, {
        type: "line",
        data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: "Active Users",
            borderColor: "#1d7af3",
            pointBorderColor: "#FFF",
            pointBackgroundColor: "#1d7af3",
            pointBorderWidth: 2,
            pointHoverRadius: 4,
            pointHoverBorderWidth: 1,
            pointRadius: 4,
            backgroundColor: "transparent",
            fill: true,
            borderWidth: 2,
            data: [542, 480, 430, 550, 530, 453, 380, 434, 568, 610, 700, 900],
        }],
        },
        options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            position: "bottom",
            labels: {
            padding: 10,
            fontColor: "#1d7af3",
            },
        },
        tooltips: {
            bodySpacing: 4,
            mode: "nearest",
            intersect: 0,
            position: "nearest",
            xPadding: 10,
            yPadding: 10,
            caretPadding: 10,
        },
        layout: {
            padding: { left: 15, right: 15, top: 15, bottom: 15 },
        },
        },
    });

    var myBarChart = new Chart(barChart, {
        type: "bar",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Request",
                backgroundColor: "rgb(23, 125, 255)",
                borderColor: "rgb(23, 125, 255)",
                // data: [3, 2, 9, 5, 4, 6, 4, 6, 7, 8, 7, 4],
                data: @json($data),
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        // stepSize: 1
                        callback: function(value) {
                            return Number.isInteger(value) ? value : null; // Only show whole numbers
                        }
                    },
                }],
            },
        },
    });

    var myPieChart = new Chart(pieChart, {
        type: "pie",
        data: {
        datasets: [{
            data: [50, 35, 15],
            backgroundColor: ["#1d7af3", "#f3545d", "#fdaf4b"],
            borderWidth: 0,
        }],
        labels: ["New Visitors", "Subscribers", "Active Users"],
        },
        options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            position: "bottom",
            labels: {
            fontColor: "rgb(154, 154, 154)",
            fontSize: 11,
            usePointStyle: true,
            padding: 20,
            },
        },
        pieceLabel: {
            render: "percentage",
            fontColor: "white",
            fontSize: 14,
        },
        tooltips: false,
        layout: {
            padding: {
            left: 20,
            right: 20,
            top: 20,
            bottom: 20,
            },
        },
        },
    });
</script>




@endsection
