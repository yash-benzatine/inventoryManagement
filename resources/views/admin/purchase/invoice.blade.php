@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Purchase Details')
@section('content')
<div class="row mt-4 mx-4">
   <div class="col-12">
      <div class="card mb-4">
         <div class="card-header d-flex justify-content-between">
            <h5>Manage Purchase</h5>
            <a href="#" class="btn btn-dark" id="printInvoice">Print</a>
         </div>
         <div class="card-body px-4 pt-0 pb-2">
            <div id="invoice" class="card-block">
               <div class="row">
                  <div class="col-sm-4">
                     <h6 class="mb-3">From:</h6>
                     <div><strong>Comany</strong></div>
                     <div>Phone: {{ $purchase1->Supplier->phone}}</div>
                     <div>Email: {{ $purchase1->Supplier->email }}</div>
                     <!-- <div>Currency: DH</div> -->
                  </div>
                  <div class="col-sm-8 d-flex justify-content-end">
                     <div class="col-sm-4">
                        <div>
                           <h6 class="mb-3">To</h6>
                           <strong>Purchase Code :</strong><span style="color: #1ab394;"> {{ $purchase1->purchase_code }}</span>
                        </div>
                        <div>Name: {{ \Auth::user()->firstname.' '. \Auth::user()->lastname ?? '' }}</div>
                        <div>Phone: {{ \Auth::user()->phone ?? '' }}</div>
                        <div>Email: {{ \Auth::user()->email ?? '' }}</div>
                        <div>{{ \Carbon\Carbon::parse($purchase1->created_date)->format('d F Y') }}</div>
                     </div>
                  </div>
               </div>
               <div class="mt-4">
                  <table class="table table-bordered">
                     <thead>
                        <tr>
                           <th class="center">#</th>
                           <th>Description</th>
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
                        @foreach($purchases as $purchase)
                        <?php 
                            $product = \App\Models\PurchaseHistory::where('purchase_code', $purchase->purchase_code)->get();
                            $total =  $purchase->quantity * $purchase->Product->purchase_price;
                            $subTotal += $total;
                        ?>
                            <tr data-index="{{ $i }}">
                            <td class="center">{{ $i }}</td>
                            <td class="left">{{ $purchase->Product->name }}</td>
                            <td class="center">{{ $purchase->quantity }}</td>
                            <td class="right">{{ $purchase->Product->purchase_price }}</td>
                            <td class="right">{{ $total }}</td>
                            </tr>
                            <?php $i++; ?> 
                        @endforeach
                     </tbody>
                  </table>
               </div>
               <div class="row mt-4">
                  <div class="col-lg-12 d-flex justify-content-end">
                     <div class="col-lg-4">
                        <table class="table table-clear">
                           <tbody>
                              <tr>
                                 <td class="left"><strong>Sub Total</strong></td>
                                 <td class="right">{{ $subTotal }}</td>
                              </tr>
                              <tr>
                                 <td class="left"><strong>Total Paid</strong></td>
                                 <td class="right">{{ $purchase1->amount }}</td>
                              </tr>
                              <tr>
                                 <td class="left"><strong>Payment Due</strong></td>
                                 <td class="right">{{ $purchase1->due }}</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('page-script')
<script>
    document.getElementById('printInvoice').addEventListener('click', function() {
        var printContents = document.getElementById('invoice').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    });
</script>
@endsection