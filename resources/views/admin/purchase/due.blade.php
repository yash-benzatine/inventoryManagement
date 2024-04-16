@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Purchase Due History')
@section('content')
<div class="row mt-4 mx-4">
   <div class="col-12">
      <div class="card mb-4">
         <div class="card-header d-flex justify-content-between">
            <h5>Invoice<strong class="mx-2">#{{ $purchase->purchase_code }}</strong></h5>
         </div>
         <div class="card-body px-4 pt-0 pb-2">
            <form method="post" action="{{ route('manage-purchase.update', $purchase->purchase_code) }}" enctype="multipart/form-data" class="form-horizontal">
                @csrf
                @method('PUT')
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="center">#</th>
                            <th>Name</th>
                            <th class="center">Quantity</th>
                            <th class="right">Unit Cost</th>
                            <th class="right">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i = 1;
                                $subTotal = 0;
                            ?>  
                            @foreach($purchase->PurchaseHistory as $purchaseHistory)
                                <?php
                                    $total = $purchaseHistory->quantity * $purchaseHistory->Product->purchase_price;
                                    $subTotal += $total;
                                ?>
                                <tr data-index="0">
                                    <td class="center">{{ $i }}</td>
                                    <td class="left">{{ $purchaseHistory->Product->name }}</td>
                                    <td class="center">{{ $purchaseHistory->quantity }}</td>
                                    <td class="right">{{  $purchaseHistory->Product->purchase_price }}</td>
                                    <td class="right">{{ $total }}</td>
                                </tr>
                            <?php $i++; ?>
                            @endforeach
                        <!---->
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-6 px-3" style="margin-top: 10px;">
                        <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <td class="left"><strong>Sub Total</strong></td>
                                <td class="right">{{ $subTotal }}</td>
                            </tr>
                            <tr>
                                <td class="left"><strong>Total Paid</strong></td>
                                <td class="right">{{ $purchase->amount }}</td>
                            </tr>
                            <tr>
                                <td class="left"><strong>Payment Due</strong></td>
                                <td class="right">{{ $purchase->due }}</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6 px-3">
                        <legend class="scheduler-border">Payment</legend>
                        <div class="form-group row">
                            <label for="date" class="col-3 col-form-label">Date <span>*</span></label>
                            <div class="col-8">
                                <div class="input-group">
                                    <input placeholder="" type="datetime-local" name="date" id="date" required="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="receivedAmount" class="col-3 col-form-label">Received Amount <span>*</span></label>
                            <div class="col-8"><input type="number" id="receivedAmount" name="amount" required="" class="form-control ng-untouched ng-pristine ng-invalid"></div>
                        </div>
                        <div class="form-group row">
                            <label for="paymentType" class="col-3 col-form-label">Payment Type <span>*</span></label>
                            <div class="col-8">
                                <select type="text" id="paymentType" name="paymentType" required="" class="form-control ng-untouched ng-pristine ng-invalid">
                                    <option value="" selected="">Please Select</option>
                                    <option value="1">cash</option>
                                    <option value="2">check</option>
                                    <option value="3">card</option>
                                    <!---->
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Payment</button>
                    </div>
                    <!---->
                </div>
            </form>
        </div>
   </div>
</div>
           
@endsection
@section('page-script')
@endsection