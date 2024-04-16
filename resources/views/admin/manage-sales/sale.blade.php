@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Sales History')
@section('content')
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h5>Sales</h5>
                <a href="{{ route('manage-sale.index') }}" class="btn btn-dark">Add Sale</a>
            </div>
            <div class="card-body px-4 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 table-flush dataTable" id="saleTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Id</th>
                                <th>Invoice Code</th>
                                <th>Customer Name</th>
                                <th>Sub Total</th>
                                <th>Discount</th>
                                <th>VAT</th>
                                <th>Grand Total</th>
                                <th>Due</th>
                                <th>Received Amount</th>
                                <th>Payment Type</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-script')
<script type="text/javascript">
    $(function() {
        var table = $('#saleTable').DataTable({
            processing: false,
            "responsive": true
                , language: {
                    paginate: {
                        next: '&#8594;', // or '→'
                        previous: '&#8592;' // or '←'
                    }
                }
            , serverSide: true
            , ajax: {
                url: "{{ route('sale.get-data') }}"
                , type: "POST"
            }
            , columns: [{
                    data: 'id'
                    , name: 'id'
                    , render: function(data, type, row, meta) {
                        return meta.settings._iDisplayStart + meta.row + 1; // Global sequential number
                    }
                }, {
                    data: 'invoice_code'
                    , name: 'invoice_code'
                }
                , {
                    data: 'customer'
                    , name: 'customer',
                    orderable: false
                }
                , {
                    data: 'sub_total'
                    , name: 'sub_total'
                }
                , {
                    data: 'discount'
                    , name: 'discount'
                }
                , {
                    data: 'vat'
                    , name: 'vat'
                }
                , {
                    data: 'grand_total'
                    , name: 'grand_total'
                }
                , {
                    data: 'due'
                    , name: 'due'
                }
                , {
                    data: 'received_amount'
                    , name: 'received_amount'
                }
                
                , {
                    data: 'payment_type'
                    , name: 'payment_type'
                }
                , {
                    data: 'date'
                    , name: 'date'
                }
                , {
                    data: 'action'
                    , name: 'action'
                    , orderable: false
                    , searchable: false
                }
            , ]
        });
    });

</script>
@endsection
