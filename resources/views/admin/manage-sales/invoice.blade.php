@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Sale Details')
@section('content')
<div class="row mt-4 mx-4">
   <div class="col-12">
      <div class="card mb-4">
         <div class="card-header d-flex justify-content-between">
            <h5>Manage Sale</h5>
            <a href="#" class="btn btn-dark" id="printInvoice">Print</a>
         </div>
         <div class="card-body px-4 pt-0 pb-2">
            <div id="invoice" class="card-block">
               <div class="row">
                  <div class="col-sm-4">
                     <h6 class="mb-3">From:</h6>
                     <div><strong>Comany</strong></div>
                     <div>Name: {{ \Auth::user()->firstname.' '. \Auth::user()->lastname ?? '' }}</div>
                     <div>Phone: {{ \Auth::user()->phone ?? '' }}</div>
                     <div>Email: {{ \Auth::user()->email ?? '' }}</div>
                     <div>{{ \Carbon\Carbon::parse($sale1->created_date)->format('d F Y') }}</div>
                  </div>
                  <div class="col-sm-8 d-flex justify-content-end">
                     <div class="col-sm-4">
                        <div>
                           <h6 class="mb-3">To</h6>
                           <strong>Invoice Code :</strong><span style="color: #1ab394;"> {{ $sale1->invoice_code }}</span>
                        </div>
                        <div>Phone: {{ $sale1->Customer->phone}}</div>
                        <div>Email: {{ $sale1->Customer->email }}</div>
                        <!-- <div>Currency: DH</div> -->
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
                        @foreach($sale as $sale2)
                        <?php 
                            $product = \App\Models\SaleHistory::where('invoice_code', $sale2->invoice_code)->get();
                            $total =  $sale2->quantity * $sale2->Product->selling_price;
                            $subTotal += $total;
                        ?>
                            <tr data-index="{{ $i }}">
                            <td class="center">{{ $i }}</td>
                            <td class="left">{{ $sale2->Product->name }}</td>
                            <td class="center">{{ $sale2->quantity }}</td>
                            <td class="right">{{ $sale2->Product->selling_price ?? '' }}</td>
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
                                 <td class="right">{{ $sale1->received_amount }}</td>
                              </tr>
                              <tr>
                                 <td class="left"><strong>Payment Due</strong></td>
                                 <td class="right">{{ $sale1->due }}</td>
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