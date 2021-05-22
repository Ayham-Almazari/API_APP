@extends('layouts.admin')
@section('title','Home')
@section('css',asset('css/home.css'))
@section('content')
    <!--__CONTENT__-->
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#">
                        <em class="fa fa-home"></em>
                    </a></li>
                <li class="active">TallyBills</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
        </div><!--/.row-->

        <div class="panel panel-container mt-5" >
            <div class="row">
                <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
                    <div class="panel panel-teal panel-widget border-right">
                        <div class="row no-padding"><em class="fa fa-xl fa-city color-blue"></em>
                            <div class="large">{{$factories}}</div>
                            <div class="text-muted">FACTORIES</div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
                    <div class="panel panel-blue panel-widget border-right">
                        <div class="row no-padding"><em class="fa fa-xl fa-users color-red"></em>
                            <div class="large">{{$admins}}</div>
                            <div class="text-muted">ADMINS</div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
                    <div class="panel panel-orange panel-widget border-right">
                        <div class="row no-padding"><em class="fa fa-xl fa-users color-teal"></em>
                            <div class="large">{{$buyers}}</div>
                            <div class="text-muted">BUYERS</div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
                    <div class="panel panel-red panel-widget ">
                        <div class="row no-padding"><em class="fa fa-xl fa-users color-gray"></em>
                            <div class="large">{{$owners}}</div>
                            <div class="text-muted">OWNERS</div>
                        </div>
                    </div>
                </div>
            </div><!--/.row-->
        </div>
        <hr >
        <div class="panel panel-container mt-5">
            <div class="row">
                <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
                    <div class="panel panel-teal panel-widget border-right">
                        <div class="row no-padding"><em class="fas fa-xl fa-file-invoice" style="color: rebeccapurple"></em>
                            <div class="large">{{$orders}}</div>
                            <div class="text-muted">Orders</div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
                    <div class="panel panel-blue panel-widget border-right">
                        <div class="row no-padding"><em class="fa fa-xl fa-shopping-cart color-orange"></em>
                            <div class="large">{{$carts}}</div>
                            <div class="text-muted">Carts</div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
                    <div class="panel panel-orange panel-widget border-right">
                        <div class="row no-padding"><em class="fas fa-xl fa-money-check-alt" style="color: darkgreen"></em>
                            <div class="large">{{$payment}}</div>
                            <div class="text-muted">Total Payment</div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
                    <div class="panel panel-red panel-widget ">
                        <div class="row no-padding"><em class="fab fa-xl fa-product-hunt" style="color: #101214"></em>
                            <div class="large">{{$products>=1000?number_format($products,0):$products}}</div>
                            <div class="text-muted">Products</div>
                        </div>
                    </div>
                </div>
            </div><!--/.row-->
        </div>
        <hr >
        <div class="row mt-5" >
            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body easypiechart-panel">
                        <h4>Buyers Have Bills</h4>
                        <div class="easypiechart" id="easypiechart-blue" data-percent="{{$buyers_percentage}}" ><span class="percent">{{$buyers_percentage}}%</span></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body easypiechart-panel">
                        <h4>Factories Have Bills</h4>
                        <div class="easypiechart" id="easypiechart-orange" data-percent="{{$factories_percentage}}" ><span class="percent">{{$factories_percentage}}%</span></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body easypiechart-panel">
                        <h4>Buyers Have Carts</h4>
                        <div class="easypiechart" id="easypiechart-teal" data-percent="{{$cart_percentage}}" ><span class="percent">{{$cart_percentage}}%</span></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body easypiechart-panel">
                        <h4>Products Added To Carts</h4>
                        <div class="easypiechart" id="easypiechart-red" data-percent="{{$product_percentage}}" ><span class="percent">{{$product_percentage}}%</span></div>
                    </div>
                </div>
            </div>
        </div><!--/.row-->
        <hr >

    </div>
    <!--/.main-->
    <script async src="{{mix('js/HomeAdmin.js')}}"></script>
    <script src="{{asset('js/html5shiv.min.js')}}"></script>
    <script src="{{asset('js/respond.min.js')}}"></script>
    <script src="{{asset('js/chart.min.js')}}"></script>
    <script src="{{asset('js/chart-data.js')}}"></script>
    <script src="{{asset('js/easypiechart.js')}}"></script>
    <script src="{{asset('js/easypiechart-data.js')}}"></script>
    <script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('js/custom.js')}}">

    <!--END__CONTENT__-->
@endsection
