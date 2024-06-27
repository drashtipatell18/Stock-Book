@extends('layouts.main')

@section('content')
    <style>
        .overview-item--c1 {
            background: linear-gradient(135deg, #c7a9e9, #a1c4fd);
           
            color: white;
        }

        .overview-item--c2 {
            background: linear-gradient(135deg, #a2c0cc, #fceea7); 

            color: white;
        }

        .overview-item--c3 {
 
            background: linear-gradient(135deg, #9cd8db, #93a5cf);
       
            color: white;
        }

        .overview-item--c4 {
            background: linear-gradient(135deg, #ffd3a5, #fd6585); 

            color: white;
        }

        /* Additional styling for the inner elements */
        .overview-item .icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .overview-item .text {
            text-align: center;
        }

        .overview-item .text h2 {
            font-size: 2rem;
            margin-bottom: 5px;
        }

        .overview-item .text span {
            font-size: 1.2rem;
        }
    </style>
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Overview</h2>
                                    <button class="au-btn au-btn-icon au-btn--blue"></button>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-25">
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="bi bi-tags"></i>
                                            </div>
                                            <div class="text">
                                                <span>Total Category</span>
                                                <h2>{{ $category }}</h2>
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                            <canvas id="widgetChart1"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c2">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="bi bi-bookmark"></i>
                                            </div>
                                            <div class="text">
                                                <span>Total Stall</span>
                                                <h2>{{ $stall }}</h2>
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                            <canvas id="widgetChart2"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c3">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="bi bi-bookmark"></i>
                                            </div>
                                            <div class="text">
                                                <span>Total Stock</span>
                                                <h2>{{ $stock }}</h2>
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                            <canvas id="widgetChart3"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c4">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="bi bi-book-half"></i>
                                            </div>
                                            <div class="text">
                                                <span>Total Book</span>
                                                <h2>{{ $book }}</h2>
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                            <canvas id="widgetChart4"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="au-card recent-report">
                                    <div class="au-card-inner">
                                        <h3 class="title-2">Recent Reports</h3>
                                        <div class="chart-info">
                                            <div class="chart-info__left">
                                                <div class="chart-note mr-0">
                                                    <span class="dot dot--green"></span>
                                                    <span>Services</span>
                                                </div>
                                            </div>
                                            <div class="chart-info__right">
                                                <div class="chart-statis mr-0">
                                                    <span id="ratio" class="index">
                                                        <i id="ratioDiff" class="zmdi"></i>
                                                        <span id="diff"></span>
                                                    </span>
                                                    <span class="label">Services</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="recent-report__chart">
                                            <canvas id="recent-rep-chart1"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="au-card chart-percent-card">
                                    <div class="au-card-inner">
                                        <h3 class="title-2 tm-b-5">Chart by %</h3>
                                        <div class="row no-gutters">
                                            <div class="col-xl-6">
                                                <div class="chart-note-wrap">
                                                    <div class="chart-note mr-0 d-block">
                                                        <span class="dot dot--blue" style="background: linear-gradient(135deg, #ffd3a5, #fd6585);"></span>
                                                        <span>Stall</span>
                                                    </div>
                                                    <div class="chart-note mr-0 d-block">
                                                        <span class="dot dot--red" style="background: linear-gradient(135deg, #a2c0cc, #fceea7);"></span>
                                                        <span>Stock</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="percent-chart">
                                                    <canvas id="percent-chart1"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const brandProduct = 'rgba(75,192,192,0.8)';
            const brandService = 'rgba(153,102,255,0.8)';

            var elements = 10;
            var data1 = [52, 60, 55, 50, 65, 80, 57, 70, 105, 115, 10, 12, 18];
            $.ajax({
                type: "GET",
                url: "{{ route('getDashboardChart') }}",
                async: false,
                success: function(response) {
                    data1 = response;
                    let date = new Date();
                    let percent = data1[date.getMonth()];
                    let greaterThenBefore = true;
                    if (data1[date.getMonth() - 1] != 0) {
                        percent = ((data1[date.getMonth()] - data1[date.getMonth() - 1]) / data1[date
                            .getMonth() - 1]) * 100;
                        if ((data1[date.getMonth()] - data1[date.getMonth() - 1]) <= 0) {
                            greaterThenBefore = false;
                        }
                    }
                    if (greaterThenBefore) {
                        $("#ratio").addClass('incre');
                        $("#ratioDiff").addClass('zmdi-long-arrow-up');
                    } else {
                        $("#ratio").addClass('decre');
                        $("#ratioDiff").addClass('zmdi-long-arrow-down');
                    }
                    $("#diff").text(percent + "%");
                }
            });

            var ctx = document.getElementById("recent-rep-chart1");
            if (ctx) {
                ctx.height = 250;
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                            'September', 'October', 'November', 'December'
                        ],
                        datasets: [{
                            label: 'Services',
                            backgroundColor: brandService,
                            borderColor: 'transparent',
                            pointHoverBackgroundColor: '#fff',
                            borderWidth: 0,
                            data: data1
                        }]
                    },
                    options: {
                        maintainAspectRatio: true,
                        legend: {
                            display: false
                        },
                        responsive: true,
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    drawOnChartArea: true,
                                    color: '#f2f2f2'
                                },
                                ticks: {
                                    fontFamily: "Poppins",
                                    fontSize: 12
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    maxTicksLimit: 5,
                                    stepSize: 50,
                                    max: 150,
                                    fontFamily: "Poppins",
                                    fontSize: 12
                                },
                                gridLines: {
                                    display: true,
                                    color: '#f2f2f2'
                                }
                            }]
                        },
                        elements: {
                            point: {
                                radius: 0,
                                hitRadius: 10,
                                hoverRadius: 4,
                                hoverBorderWidth: 3
                            }
                        }
                    }
                });
            }

            var ctx = document.getElementById("percent-chart1");
            if (ctx) {
                ctx.height = 280;
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            label: "My First dataset",
                            data: ["{{ $stall }}", "{{ $stock }}"],
                            backgroundColor: [
                                '#ff6384',
                                '#36a2eb'
                            ],
                            hoverBackgroundColor: [
                                '#ff6384',
                                '#36a2eb'
                            ],
                            borderWidth: [
                                0, 0
                            ],
                            hoverBorderColor: [
                                'transparent',
                                'transparent'
                            ]
                        }],
                        labels: [
                            'Stall',
                            'Stock'
                        ]
                    },
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        cutoutPercentage: 55,
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            titleFontFamily: "Poppins",
                            xPadding: 15,
                            yPadding: 10,
                            caretPadding: 0,
                            bodyFontSize: 16
                        }
                    }
                });
            }
        });
    </script>
@endsection
