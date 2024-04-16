@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <a href="{{ route('customer.index') }}">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Customer</p>
                                <h5 class="font-weight-bolder">
                                    {{ $customer }}
                                </h5>
                                <p class="mb-0">
                                    <span class="{{ $customerPercentage >= 1 ? 'text-success' : 'text-danger'}} text-sm font-weight-bolder">{{ $customerPercentage }}%</span>
                                    since yesterday
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                <i class="ni fa fa-user-friends text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <a href="{{ route('supplier.index') }}">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Supplier</p>
                                <h5 class="font-weight-bolder">
                                    {{ $supplier }}
                                </h5>
                                <p class="mb-0">
                                    <span class="{{ $supplierPercentage >= 1 ? 'text-success' : 'text-danger'}} text-sm font-weight-bolder">{{ $supplierPercentage }}%</span>
                                    since last week
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <a href="{{ route('product.index') }}">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Product</p>
                                <h5 class="font-weight-bolder">
                                    {{ $product }}
                                </h5>
                                <p class="mb-0">
                                    <span class="{{ $productPercentage >= 1 ? 'text-success' : 'text-danger'}} text-sm font-weight-bolder">{{ $productPercentage }}%</span>
                                    since last quarter
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-dark shadow-success text-center rounded-circle">
                                <i class="ni fab fa-product-hunt text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-sm-6">
        <a href="{{ route('users.index') }}">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">User</p>
                                <h5 class="font-weight-bolder">
                                    {{ $user }}
                                </h5>
                                <p class="mb-0">
                                    <span class="{{ $userPercentage >= 1 ? 'text-success' : 'text-danger'}} text-sm font-weight-bolder">{{ $userPercentage }}%</span> than last month
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                <i class="ni fa fa-user text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row mt-4">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <a href="{{ route('category.index') }}">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Category</p>
                                <h5 class="font-weight-bolder">
                                    {{ $category }}
                                </h5>
                                <p class="mb-0">
                                    <span class="{{ $categoryPercentage >= 1 ? 'text-success' : 'text-danger'}} text-sm font-weight-bolder">{{ $categoryPercentage }}%</span>
                                    since yesterday
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-secondary shadow-primary text-center rounded-circle">
                                <i class="ni fas fa-server text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <a href="{{ route('manage-purchase.index') }}">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Payment</p>
                                    <h5 class="font-weight-bolder">
                                        {{ $payment }}
                                    </h5>
                                    <p class="mb-0">
                                        <span class="{{ $salePaymentPercentage >= 1 ? 'text-success' : 'text-danger'}} text-sm font-weight-bolder">{{ $salePaymentPercentage }}%</span>
                                        since last week
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow-danger text-center rounded-circle">
                                    <i class="ni fas fa-money-bill-alt text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <a href="{{ route('sale.index') }}">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Sales</p>
                                <h5 class="font-weight-bolder">
                                    {{ $sale }}
                                </h5>
                                <p class="mb-0">
                                    <span class="{{ $salePercentage >= 1 ? 'text-success' : 'text-danger'}} text-sm font-weight-bolder">{{ $salePercentage }}%</span>
                                    since last quarter
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-sm-6">
        <a href="{{ route('purchase.index') }}">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Purchase</p>
                                <h5 class="font-weight-bolder">
                                    {{ $purchase }}
                                </h5>
                                <p class="mb-0">
                                    <span class="{{ $purchasePercentage >= 1 ? 'text-success' : 'text-danger'}} text-sm font-weight-bolder">{{ $purchasePercentage }}%</span> than last month
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-info shadow-warning text-center rounded-circle">
                                <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>


<div class="row mt-4">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header pb-0 p-3">
                <h6 class="mb-0">Recent 5 Products</h6>
            </div>
            <div class="card-body p-3">
                <ul class="list-group">
                    @foreach ($products as $product)
                        <?php
                            $stock = 0;
                            $salesHistory = 0;
                            if($product->Product) {
                                $salesHistory = \App\Models\SaleHistory::where('product_id', $product->product_id)->sum('quantity');
                                if($salesHistory){
                                    $stock = $product->Product->quantity - $salesHistory;
                                } else {
                                    $stock = $product->Product->quantity;
                                }
                            }
                        ?>
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                <i class="ni ni-mobile-button text-white opacity-10"></i>
                            </div>
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark text-sm">{{ $product->Product->name }}</h6>
                                <span class="span-wrapper text-xs">{{ $stock }} in stock, <span class="font-weight-bold">{{ $salesHistory }}+
                                sold</span></span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-7 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">Sales overview</h6>
                <p class="text-sm mb-0">
                    <i class="fa fa-arrow-up text-success"></i>
                    Sales <span class="font-weight-bold">{{ $saleYearly }}% more</span> in {{ Carbon\Carbon::now()->year - 1 }}
                    <br><i class="fa fa-arrow-up text-success"></i> Purchases<span class="font-weight-bold"> {{ $purchaseYearly }}% more</span> in {{ Carbon\Carbon::now()->year - 1 }}
                </p>
            </div>
            <div class="card-body p-3">
                <div class="chart">
                    <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('page-script')
<script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
<script>
    // Sample data for demonstration (replace with actual data)
    var salesData = [100, 200, 150, 300, 400, 250, 350, 200, 300, 400, 500, 450]; // Sales data for each month
    var purchaseData = [80, 150, 120, 250, 350, 200, 300, 180, 280, 350, 450, 400]; // Purchase data for each month
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']; // Months

    // Get the canvas element
    var ctx = document.getElementById('chart-line').getContext('2d');
    var gradientStroke1 = ctx.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');

    var gradientStroke = ctx.createLinearGradient(0, 230, 0, 50);

    gradientStroke.addColorStop(1, 'rgba(255, 99, 132, 1)'); // Red color with full opacity
    gradientStroke.addColorStop(0.4, 'rgba(255, 99, 132, 0.2)'); // Red color with lower opacity
    gradientStroke.addColorStop(0, 'rgba(255, 99, 132, 0)'); // Transparent


    // Create the line chart
    var myChart = new Chart(ctx, {
        type: 'line'
        , data: {
            labels: {!! json_encode($months) !!}, // X-axis labels (months)
            datasets: [{
                    label: 'Sales', // Sales dataset
                    data: {!! json_encode($saleData) !!},     // Sales data
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Fill color
                    borderColor: 'rgba(54, 162, 235, 1)', // Line color
                    borderWidth: 1,
                    tension: 0.4, 
                    borderWidth: 0, 
                    pointRadius: 0, 
                    borderColor: "#5e72e4",
                    backgroundColor: gradientStroke1, 
                    borderWidth: 3, 
                    fill: true
                }, {
                    label: 'Purchase', // Purchase dataset
                    data: {!! json_encode($purchaseData) !!}, // Purchase data
                    backgroundColor: 'rgba(255, 99, 132, 0.2)', // Fill color
                    borderColor: 'rgba(255, 99, 132, 1)', // Line color
                    borderWidth: 1 // Line width
                    , tension: 0.4
                    , borderWidth: 0
                    , pointRadius: 0
                    , borderColor: "#ff0000" // Red color
                    , backgroundColor: gradientStroke
                    , borderWidth: 3
                    , fill: true

                }
            ]
        }
        , options: {
            responsive: true
            , maintainAspectRatio: false
            , plugins: {
                legend: {
                    display: false
                , }
            }
            , interaction: {
                intersect: false
                , mode: 'index'
            , }
            , scales: {
                y: {
                    grid: {
                        drawBorder: false
                        , display: true
                        , drawOnChartArea: true
                        , drawTicks: false
                        , borderDash: [5, 5]
                    }
                    , ticks: {
                        display: true
                        , padding: 10
                        , color: '#fbfbfb'
                        , font: {
                            size: 11
                            , family: "Open Sans"
                            , style: 'normal'
                            , lineHeight: 2
                        }
                    , }
                }
                , x: {
                    grid: {
                        drawBorder: false
                        , display: false
                        , drawOnChartArea: false
                        , drawTicks: false
                        , borderDash: [5, 5]
                    }
                    , ticks: {
                        display: true
                        , color: '#ccc'
                        , padding: 20
                        , font: {
                            size: 11
                            , family: "Open Sans"
                            , style: 'normal'
                            , lineHeight: 2
                        }
                    , }
                }
            , }
        , }
    });

</script>

@endsection
