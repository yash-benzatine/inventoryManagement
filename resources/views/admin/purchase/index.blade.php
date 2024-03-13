@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Manage Purchase'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h5>Manage Purchase</h5>
                <a href="{{ route('manage-purchase.create') }}" class="btn bg-gradient-dark btn-sm float-end mb-0">Add Manage Purchase</a>
            </div>
            <div class="card-body px-4 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <div class="col-md-4 mb-4">
                        <select class="form-control" name="productId" id="productId">
                            <option value="">Purchase Product</option>
                            @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <table class="table align-items-center mb-0" id="managePurchaseTable">

                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Serial
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Quantity</th>
                                <th>
                                    Unit Price</th>
                                <th>
                                    Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                            {{-- <tr>
                                <td>{{ $product->id }}</td>
                            <td class="editable" data-id="{{ $product->id }}" data-field="serial">{{ $product->serial }}</td>
                            <td class="editable" data-id="{{ $product->id }}" data-field="name">{{ $product->name }}</td>
                            <td class="editable" data-id="{{ $product->id }}" data-field="quantity">{{ $product->quantity }}</td>
                            <td class="editable" data-id="{{ $product->id }}" data-field="unit_price">{{ $product->unit_price }}</td>
                            <td>{{ $product->quantity * $product->unit_price }}</td> <!-- Total will be calculated dynamically -->
                            </tr> --}}

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    });
    $('#productId').change(function(e) {
        e.preventDefault();
        var productId = $(this).val();
        if (productId != '') {
            $.ajax({
                url: '/manage-purchase-get-data/'
                , type: 'POST'
                , data: {
                    productId: productId
                }
                , success: function(response) {
                    // $('#managePurchaseTable tbody').empty();

                    if (response.product.length > 0) {
                        $.each(response.product, function(index, product) {
                            var total = product.quantity * product.purchase_price;
                            var newRow = '<tr>' +
                                '<td>' + product.id + '</td>' +
                                '<td class="editable" data-id="' + product.id + '" data-field="serial">' + product.serial_number + '</td>' +
                                '<td class="editable" data-id="' + product.id + '" data-field="name">' + product.name + '</td>' +
                                '<td class="editable" data-id="' + product.id + '" data-field="quantity">' + product.quantity + '</td>' +
                                '<td class="editable" data-id="' + product.id + '" data-field="unit_price">' + product.unit_price + '</td>' +
                                '<td>' + total + '</td>' +
                                '</tr>';
                            $('#managePurchaseTable tbody').append(newRow);
                        });
                    } else {
                        $('#managePurchaseTable tbody').append('<tr> <td colspan = "6" > No data found< /td>< /tr > ');
                    }
                }
            });
        } else {
            $('#managePurchaseTable tbody').empty();
        }
    });

</script>
@endsection
