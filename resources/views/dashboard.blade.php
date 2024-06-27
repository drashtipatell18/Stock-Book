@extends('layouts.main')

@section('content')
<div class="col-md-12 col-sm-12 ">
    <div class="card">
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="overview-wrap">
                                <h2 class="title-1">overview</h2>
                                <button class="au-btn au-btn-icon au-btn--blue">
                                    </button>
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
                                            <h2>{{ $category}}</h2>
                                            <span>Total Category</span>
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
                                            <h2>{{ $stall }}</h2>
                                            <span>Total Store</span>
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
                                            <h2> {{ $stock }}</h2>
                                            <span>Total Stock</span>
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
                                            <h2>{{ $book }}</h2>
                                            <span>Total Book</span>
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
                                    <h3 class="title-2">recent reports</h3>
                                    <div class="chart-info">
                                        <div class="chart-info__left">
                                            {{-- <div class="chart-note">
                                                <span class="dot dot--blue"></span>
                                                <span>products</span>
                                            </div> --}}
                                            <div class="chart-note mr-0">
                                                <span class="dot dot--green"></span>
                                                <span>services</span>
                                            </div>
                                        </div>
                                        <div class="chart-info__right">
                                            {{-- <div class="chart-statis">
                                                <span class="index incre">
                                                    <i class="zmdi zmdi-long-arrow-up"></i>25%</span>
                                                <span class="label">products</span>
                                            </div> --}}
                                            <div class="chart-statis mr-0">
                                                <span id="ratio" class="index"> {{-- class=decre --}}
                                                    {{-- <i id="" class="zmdi zmdi-long-arrow-down"></i>10%</span> --}}
                                                    <i id="ratioDiff" class="zmdi"></i>
                                                    <span id="diff"></span>
                                                </span>
                                                <span class="label">services</span>
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
                                    <h3 class="title-2 tm-b-5">char by %</h3>
                                    <div class="row no-gutters">
                                        <div class="col-xl-6">
                                            <div class="chart-note-wrap">
                                                <div class="chart-note mr-0 d-block">
                                                    <span class="dot dot--blue"></span>
                                                    <span>Store</span>
                                                </div>
                                                <div class="chart-note mr-0 d-block">
                                                    <span class="dot dot--red"></span>
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
    document.addEventListener('DOMContentLoaded', function(){
        const brandProduct = 'rgba(0,181,233,0.8)'
        const brandService = 'rgba(0,173,95,0.8)'

        var elements = 10
        var data1 = [52, 60, 55, 50, 65, 80, 57, 70, 105, 115, 10, 12, 18]
        $.ajax({
            type: "GET",
            method: "GET",
            url: "{{ route('getDashboardChart') }}",
            async: false,
            success: function(response){
                data1 = response
                let date = new Date();
                let percent = data1[date.getMonth()]
                let greaterThenBefore = true;
                if(data1[date.getMonth()-1] != 0)
                {
                    percent = ((data1[date.getMonth()] - data1[date.getMonth()-1]) / data1[date.getMonth()-1]) * 100
                    if((data1[date.getMonth()] - data1[date.getMonth()-1]) <= 0)
                    {
                        greaterThenBefore = false
                    }
                }
                if(greaterThenBefore)
                {
                    $("#ratio").addClass('incre')
                    $("#ratioDiff").addClass('zmdi-long-arrow-up')
                }
                else
                {
                    $("#ratio").addClass('decre')
                    $("#ratioDiff").addClass('zmdi-long-arrow-down')
                }
                $("#diff").text(percent + "%")
            }
        })
        // var data2 = [102, 70, 80, 100, 56, 53, 80, 75, 65, 90, 10, 12, 18]

        var ctx = document.getElementById("recent-rep-chart1");
        if (ctx) {
        ctx.height = 250;
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [
                    {
                    label: 'My First dataset',
                    backgroundColor: brandService,
                    borderColor: 'transparent',
                    pointHoverBackgroundColor: '#fff',
                    borderWidth: 0,
                    data: data1

                    },
                    // {
                    // label: 'My Second dataset',
                    // backgroundColor: brandProduct,
                    // borderColor: 'transparent',
                    // pointHoverBackgroundColor: '#fff',
                    // borderWidth: 0,
                    // data: data2

                    // }
                ]
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

        // Percent Chart
    var ctx = document.getElementById("percent-chart1");
    if (ctx) {
        ctx.height = 280;
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
            datasets: [
                {
                label: "My First dataset",
                data: ["{{ $stall }}", "{{ $stock }}"],
                backgroundColor: [
                    '#00b5e9',
                    '#fa4251'
                ],
                hoverBackgroundColor: [
                    '#00b5e9',
                    '#fa4251'
                ],
                borderWidth: [
                    0, 0
                ],
                hoverBorderColor: [
                    'transparent',
                    'transparent'
                ]
                }
            ],
            labels: [
                'Store',
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
    })
</script>
@endsection