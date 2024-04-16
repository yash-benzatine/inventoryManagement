@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Product Management')
@section('content')
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h5>Product</h5>
                <a href="{{ route('product.create') }}" class="btn btn-dark">Add Product</a>
            </div>
            <div class="card-body px-4 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 table-flush dataTable" id="productTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Purchase Price</th>
                                <th>Selling Price</th>
                                <th>Image</th>
                                <th>Quantity</th>
                                <th>Inventory</th>
                                <th>Note</th>
                                <th>Status</th>
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
        var table = $('#productTable').DataTable({

            processing: false,
            "responsive": true
                , language: {
                    paginate: {
                        next: '&#8594;', // or '→'
                        previous: '&#8592;' // or '←'
                    }
                },  
            serverSide: true
            , ajax: {
                url: "{{ route('product.get-data') }}"
                , type: "POST"
            }
            , columns: [{
                    data: 'id'
                    , name: 'id'
                    , render: function(data, type, row, meta) {
                        return meta.settings._iDisplayStart + meta.row + 1; // Global sequential number
                    }
                }, {
                    data: 'name'
                    , name: 'name'
                }
                , {
                    data: 'category_id'
                    , name: 'category_id'
                }
                , {
                    data: 'purchase_price'
                    , name: 'purchase_price'
                }
                , {
                    data: 'selling_price'
                    , name: 'selling_price'
                }
                , {
                    data: 'image'
                    , name: 'image',
                    orderable: false
                }, {
                    data: 'quantity'
                    , name: 'quantity'
                }
                , {
                    data: 'inventory'
                    , name: 'inventory',
                    orderable: false
                }
                , {
                    data: 'note'
                    , name: 'note'
                }
                , {
                    data: 'status'
                    , name: 'status',
                    orderable: false
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
