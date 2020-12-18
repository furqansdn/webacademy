@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-purple">
                <div class="inner">
                    <h3>{{$allUser}}</h3>
                    <p>Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users fa-3x"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-mint">
                <div class="inner">
                    <h3>@currency($totalPayment)</h3>
                    <p>Total Payment</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill fa-3x"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-yarrow">
                <div class="inner">
                    <h3>{{$allSeries}}</h3>
                    <p>Series</p>
                </div>
                <div class="icon">
                    <i class="fas fa-server fa-3x"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-electron">
                <div class="inner">
                    <h3>{{$allLecture}}</h3>
                    <p>Lecture</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book-open fa-3x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card ">
                <div class="card-header bg-electron">
                  <h3 class="card-title">Pembayaran Perbulan</h3>
                </div>
                <div class="card-body">
                  <div class="chart">
                    <canvas id="line-chart" style="min-height: 250px; height: 450px; max-height: 450px; max-width: 100%;"></canvas>
                  </div>
                </div>
            </div>
            {{-- <canvas id="line-chart" width="800" height="450" class="col-md-12"></canvas> --}}
        </div>

        <div class="col-md-6">
            <div class="card ">
                <div class="card-header bg-mint">
                  <h3 class="card-title">Seri Pembelajaran Terpopuler</h3>
                </div>
                <div class="card-body">
                  <div class="chart">
                    <canvas id="bar-chart" style="min-height: 250px; height: 450px; max-height: 450px; max-width: 100%;"></canvas>
                  </div>
                </div>
            </div>
            {{-- <canvas id="line-chart" width="800" height="450" class="col-md-12"></canvas> --}}
        </div>
    </div>
</div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.js"></script>
    <script>
        const lineCtx  = document.getElementById('line-chart');
        const barCtx  = document.getElementById('bar-chart');

        const renderChart = (doc ,type, data, dataLabel) => {
            let newLabel = [];
            let newData = [];
            let fill = (type === 'bar') ? true : false;
            console.log(fill);

            data.forEach(element => {
                newData.push(element.totals);
                newLabel.push(element.label);
            });

            var chart = new Chart(doc, {
                                type:type,
                                data: {
                                    labels:newLabel,
                                    datasets: [
                                        {
                                            label:dataLabel,
                                            data: newData,
                                            borderWidth: 2,
                                            borderColor: "#3e95cd",
                                            fill,
                                            backgroundColor:[
                                                'rgba(0, 184, 148,1.0)'
                                            ]
                                        }
                                    ]
                                },
                                options: {
                                    scales: {
                                        xAxes: [],
                                        yAxes: [{
                                        ticks: {
                                            beginAtZero:true
                                        }
                                        }]
                                    }
                                }
                            });

        }

        const updateLineChart = (dataLabel) => {
            $.ajax({
                url:"{{route('admin::dashboard.data.getpayment')}}",
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    renderChart(lineCtx,'line',response,dataLabel);
                }
            })
        }

        const updateBarChart = (dataLabel) => {
            $.ajax({
                url:"{{route('admin::dashboard.data.popular')}}",
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    renderChart(barCtx,'bar',response, dataLabel);
                }
            })
        }
        window.addEventListener("load", function(){
            updateLineChart('PembayaranRp');
            updateBarChart('Popular Series');
        })
    </script>
@endpush

@push('style')
    <style>
        .bg-mint {
            background: #00b894;
            color: #fff;
        }

        .bg-yarrow {
            background: #fdcb6e;
            color: #fff;
        }

        .bg-electron {
            background: #0984e3;
            color: #fff;
        }
    </style>
@endpush