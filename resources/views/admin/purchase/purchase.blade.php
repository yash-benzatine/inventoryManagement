@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Purchase History')
@section('content')
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h5>Purchase</h5>
                <a href="{{ route('manage-purchase.index') }}" class="btn btn-dark">Add Purchase</a>
            </div>
            <div class="card-body px-4 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 table-flush dataTable" id="purchaseTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Id</th>
                                <th>Purchase Code</th>
                                <th>Supplier Name</th>
                                <th>Amount</th>
                                <th>Due</th>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    });
    $(function() {
        var table = $('#purchaseTable').DataTable({

            processing: false,
            "responsive": true
                , language: {
                    paginate: {
                        next: '&#8594;', // or '→'
                        previous: '&#8592;' // or '←'
                    }
                }
            ,  serverSide: true
            , ajax: {
                url: "{{ route('purchase.get-data') }}"
                , type: "POST"
            }
            , columns: [{
                    data: 'id'
                    , name: 'id'
                    , render: function(data, type, row, meta) {
                        return meta.settings._iDisplayStart + meta.row + 1; // Global sequential number
                    }
                }, {
                    data: 'purchase_code'
                    , name: 'purchase_code'
                }
                , {
                    data: 'supplier_id'
                    , name: 'supplier_id',
                    orderable: false
                }
                , {
                    data: 'amount'
                    , name: 'amount'
                }
                , {
                    data: 'due'
                    , name: 'due'
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
