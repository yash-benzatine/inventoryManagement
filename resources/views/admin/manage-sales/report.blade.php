@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Sales Report')
@section('content')
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h5>Sales</h5>
                {{-- <a href="{{ route('manage-sale.index') }}" class="btn bg-gradient-dark btn-sm float-end mb-0">Add Sale</a> --}}
            </div>
            <div class="card-body px-4 pt-0 pb-2">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label for="from" class="col-md-2 col-form-label form-control-label">Date</label>
                            <div class="col-md-9">
                                <input class="form-control" type="date" value="{{ date('Y-m-d') }}" id="from">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label for="to" class="col-md-3 col-form-label form-control-label">To Date</label>
                            <div class="col-md-8">
                                <input class="form-control" type="date" value="{{ date('Y-m-d') }}" id="to">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-danger">PDF Download</button>
                    </div>

                </div>

                <div class="table-responsive p-0 mt-5">
                    <table class="table align-items-center mb-0" id="saleTable">
                        <thead>
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
            processing: true
            , serverSide: true
            , ajax: {
                url: "{{ route('manage-sale.get-data') }}"
                , type: "POST"
                , data: function(d) {
                    d.from = $('#from').val();
                    d.to = $('#to').val();
                }

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
                    , name: 'customer'
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
            , ]
        });

        $('#from, #to').change(function() {
            // Reload the DataTable when either date changes
            table.ajax.reload();
        });

    });

</script>
@endsection
