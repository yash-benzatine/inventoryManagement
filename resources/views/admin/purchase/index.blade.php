@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Purchase Management')
@section('content')
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h5>Manage Purchase</h5>
                <a href="{{ route('manage-purchase.create') }}" class="btn bg-gradient-dark btn-sm float-end mb-0">Add Manage Purchase</a>
            </div>
            <div class="card-body px-4 pt-0 pb-2">
                <div class="col-md-4 mb-4">
                    <select class="form-control" name="productId" id="productId">
                        <option value="">Purchase Product</option>
                        @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="table-responsive p-0">
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
                            <tr class="tr-wrapper">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Not Found</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <form action="{{ route('manage-purchase.store') }}" method="POST" id="purchaseForm">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <h6>Supplier</h6>
                    <div class="card-wrapper">
                        <input type="hidden" name="data_id" value="" id="data_id">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Purchase Code</label>
                            <div class="col-md-7">
                                <input class="form-control @error('purchase_code') is-invalid @enderror" type="text" value="{{ old('purchase_code') }}" name="purchase_code" id="example-text-input">
                                @error('purchase_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Supplier</label>
                            <div class="col-md-7">
                                <select type="text" id="supplier_id" name="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror">
                                    <option value="">Please Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Supplier</label>
                            <div class="col-md-7">
                                <input class="form-control @error('date') is-invalid @enderror" type="datetime-local" name="date" value="{{ old('date') }}" id="example-text-input">
                                @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6>Payment</h6>
                    <div class="card-wrapper row">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Grand Total</label>
                            <div class="col-md-7">
                                <input class="form-control @error('total') is-invalid @enderror" name="total" type="text" value="{{ old('total') }}" id="total" readonly="">

                                @error('total')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Amount</label>
                            <div class="col-md-7">
                                <input class="form-control @error('amount') is-invalid @enderror" name="amount" type="number" value="{{ old('amount') }}" id="amount">
                                @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Due</label>
                            <div class="col-md-7">
                                <input class="form-control @error('due') is-invalid @enderror" name="due" type="number" value="{{ old('due') }}" id="due" readonly="">

                                @error('due')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Payment Type</label>
                            <div class="col-md-7">
                                <select type="text" id="paymentType" name="paymentType" class="form-control @error('paymentType') is-invalid @enderror" value="{{ old('paymentType') }}">
                                    <option value="">Please Select</option>
                                    <option value="1" {{ old('paymentType') == 1 ? 'selected' : '' }}>cash</option>
                                    <option value="2" {{ old('paymentType') == 2 ? 'selected' : '' }}>check</option>
                                    <option value="3" {{ old('paymentType') == 3 ? 'selected' : '' }}>card</option>
                                    <!---->
                                </select>
                                @error('paymentType')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 col-md-4">Create New Purchase</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection
@section('page-script')
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#purchaseForm').validate({

            rules: {
                // Define validation rules for each form field
                'purchase_code': {
                    required: true,
                    // Add additional rules as needed
                }
                , 'supplier_id': {
                    required: true
                , }
                , 'total': {
                    required: true
                , }
                , 'amount': {
                    required: true
                    , number: true
                , }
                , 'paymentType': {
                    required: true
                , }
            , }
            , messages: {
                // Define custom error messages for each field if needed
                'purchase_code': {
                    required: "Please enter a purchase code"
                , }
                , 'supplier_id': {
                    required: "Please select a supplier"
                , }
                , 'total': {
                    required: "Please enter a valid grand total"
                , }
                , 'amount': {
                    required: "Please enter a valid amount"
                    , number: "Please enter a valid number"
                , }
                , 'paymentType': {
                    required: "Please select a payment type"
                , }
            , }
            , submitHandler: function(form) {
                // If the form is valid, submit it
                form.submit();
            }
        });
    });


    $(function() {
        $('#managePurchaseTable').DataTable();
    });


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
                    var sub_total = 0;
                    var product_id = [];

                    if (response.product.length > 0) {
                        $.each(response.product, function(index, product) {
                            $('.tr-wrapper').closest('tr').remove();
                            var total = product.quantity * product.purchase_price;
                            sub_total += total;
                            alert();
                            product_id.push(product.id);
                            var newRow = '<tr>' +
                                '<td>' + product.id + '</td>' +
                                '<td><input type="text" class="form-control" class="editable" data-id="' + product.id + '" data-field="serial_number" value="' + product.serial_number + '" readonly></td>' +
                                '<td><input type="text" class="form-control" class="editable" data-id="' + product.id + '" data-field="name" value="' + product.name + '"></td>' +
                                '<td><input type="text" class="form-control" class="editable" data-id="' + product.id + '" data-field="quantity" value="' + product.quantity + '"></td>' +
                                '<td><input type="text" class="form-control" class="editable" data-id="' + product.id + '" data-field="purchase_price" value="' + product.purchase_price + '"></td>' +
                                '<td><input type="text" class="form-control" class="editable" data-id="' + product.id + '" data-field="total" value="' + total + '" readonly></td>' +
                                '<td><button class="btn btn-danger remove-row mt-3">Remove</button></td>' +
                                '</tr>';
                            $('input[id="total"]').val(sub_total.toFixed(2)); // Assuming 2 decimal places for grand total
                            $('input[name="data_id"]').val(product_id);
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

    $(document).on('input', '#managePurchaseTable input', function() {
        var $input = $(this);
        var productId = $input.closest('tr').find('td:first').text(); // Get the product ID from the first column of the current row
        var field = $input.data('field');
        var value = $input.val();

        $.ajax({
            url: '/update-product-data/'
            , type: 'POST'
            , data: {
                productId: productId
                , field: field
                , value: value
            }
            , success: function(response) {
                // Handle success response
                console.log(response);
            }
            , error: function(xhr, status, error) {
                // Handle error response
                console.error(xhr.responseText);
            }
        });
    });
    $(document).on('input', '#managePurchaseTable input', function() {
        var $input = $(this);
        var productId = $input.closest('tr').find('td:first').text(); // Get the product ID from the first column of the current row
        var field = $input.data('field');
        var value = $input.val();

        $.ajax({
            url: '/update-product-data/'
            , type: 'POST'
            , data: {
                productId: productId
                , field: field
                , value: value
            }
            , success: function(response) {
                updateGrandTotal();
                // Handle success response
                if (field === 'quantity' || field === 'purchase_price') {
                    updateTotal(productId);
                    updateGrandTotal();
                }
            }
            , error: function(xhr, status, error) {
                // Handle error response
                console.error(xhr.responseText);
            }
        });
    });

    function updateTotal(productId) {
        // Calculate total based on quantity and unit_price
        var quantity = parseFloat($('input[data-id="' + productId + '"][data-field="quantity"]').val());
        var unitPrice = parseFloat($('input[data-id="' + productId + '"][data-field="purchase_price"]').val());
        var total = isNaN(quantity) || isNaN(unitPrice) ? 0 : quantity * unitPrice;

        // Update total column in the table
        $('input[data-id="' + productId + '"][data-field="total"]').val(total);
    }
    $(document).on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
    });

    function updateGrandTotal() {
        var grandTotal = 0;
        $('#managePurchaseTable input[data-field="total"]').each(function() {
            var totalValue = parseFloat($(this).val());
            if (!isNaN(totalValue)) {
                grandTotal += totalValue;
            }
        });
        $('input[name="total"]').val(grandTotal.toFixed(2)); // Assuming 2 decimal places for grand total
    }
    $('#amount').on('input', function() {
        updateDue();
    });
    // Function to update the due amount
    function updateDue() {
        var grandTotal = parseFloat($('#grand_total').val()) || 0;
        var amountPaid = parseFloat($('#amount').val()) || 0;
        var due = grandTotal - amountPaid;
        $('#due').val(due.toFixed(2));
    }

</script>

@endsection
