@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Purchase Management')
@section('content')
<div class="row mt-4 mx-4">
    <div class="col-12">
        <form action="{{ route('manage-purchase.store') }}" method="POST" id="purchaseForm">

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h5>Manage Purchase</h5>
                <a href="{{ route('manage-purchase.create') }}" class="btn btn-dark">Add Manage Purchase</a>
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
                    <table class="table align-items-center mb-0 table-flush dataTable" id="managePurchaseTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Id</th>
                                <th>Serial</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <h6>Supplier</h6>
                    <div class="card-wrapper"> 
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
                            <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Date</label>
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
                                <div class="mt-2 error" id="error_message"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Due</label>
                            <div class="col-md-7">
                                <input class="form-control @error('due') is-invalid @enderror change" name="due" type="text" value="{{ old('due') }}" id="due" readonly="">

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
                                    <option value="cash" {{ old('paymentType') == "cash" ? 'selected' : '' }}>CASH</option>
                                    <option value="check" {{ old('paymentType') == "check" ? 'selected' : '' }}>CHECK</option>
                                    <option value="card" {{ old('paymentType') == "card" ? 'selected' : '' }}>CARD</option>
                                    <!---->
                                </select>
                                @error('paymentType')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                        <button type="submit" id="submit" class="btn btn-primary mt-4 col-md-4">Create New Purchase</button>
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
        $('#managePurchaseTable').style('display: none');
        $('#managePurchaseTable').DataTable({
            language: {
                paginate: {
                next: '&#8594;', // or '→'
                previous: '&#8592;' // or '←' 
                }
            }
        });
    });

    $('#productId').change(function(e) {
        e.preventDefault();
        var productId = $(this).val();
        if (productId != '') {
            $.ajax({
                url: "{{ route('manage-purchase.get-data') }}", 
                type: "POST", 
                data: {
                    productId: productId
                }, 
                success: function(response) {
                    // $('#managePurchaseTable tbody').empty();
                    var sub_total = 0;
                    var product_id = [];
                    var rowCount = $('#managePurchaseTable tbody tr').length;
                    if (response.product.length > 0) {
                        $.each(response.product, function(index, product) {
                            $('.tr-wrapper').closest('tr').remove();
                            var total = product.quantity * product.purchase_price;
                            var total1 = product.quantity * product.purchase_price;
                            sub_total += total;
                            product_id.push(product.id);
                            var newRow = '<tr><input type="hidden" name="data_id[]" value="'+ product.id +'" id="data_id">' +
                                '<td>' + (rowCount + 1) + '</td>' +
                                '<td><input type="text" class="form-control" class="editable" data-id="' + product.id + '" data-field="serial_number" value="' + product.serial_number + '" readonly></td>' +
                                '<td><input type="text" class="form-control" class="editable" data-id="' + product.id + '" data-field="name" value="' + product.name + '"></td>' +
                                '<td><input type="text" class="purchase_quantity form-control"  id="'+ product.id +'" data-field="purchase_quantity"  name="purchase_quantity[]" value="' + product.quantity + '"></td>' +
                                '<td><input type="text" class="form-control" class="editable" data-id="' + product.id + '" data-field="purchase_price" value="' + product.purchase_price + '"></td>' +
                                '<td><input type="text" class="form-control" class="editable" data-id="' + product.id + '" data-field="total" value="' + total1 + '" readonly></td>' +
                                '<td><button class="btn btn-danger remove-row mt-3 change">Remove</button></td>' +
                                '</tr>';
                            $('input[id="total"]').val(sub_total.toFixed(2)); // Assuming 2 decimal places for grand total
                            $('#managePurchaseTable').show();
                            $('#managePurchaseTable tbody').append(newRow);
                            updateGrandTotal();
                        });
                    } else {
                        $('#managePurchaseTable').show();
                        $('#managePurchaseTable tbody').append('<tr> <td colspan = "6"> No data found</td></tr> ');
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
                updateGrandTotal();
                // Handle success response
                if (field === 'purchase_quantity' || field === 'purchase_price') {
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

      $(document).on('change', '.purchase_quantity', function() {
        var productId = this.id;
        updateTotal(productId);
    });

    function updateTotal(productId) {
        // Calculate total based on quantity and unit_price
        var quantity = parseFloat($('input[id="' + productId + '"][data-field="purchase_quantity"]').val());
        var unitPrice = parseFloat($('input[data-id="' + productId + '"][data-field="purchase_price"]').val());
        var total = isNaN(quantity) || isNaN(unitPrice) ? 0 : quantity * unitPrice;
        // Update total column in the table
        $('input[data-id="' + productId + '"][data-field="total"]').val(total);
        updateGrandTotal();
    }
    $(document).on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
        updateDue();
        updateGrandTotal();
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
        updateDue();
    }
    $('#amount').on('input', function() {
        updateDue();
    });
    // Function to update the due amount
    function updateDue() {
        var grandTotal = parseFloat($('#total').val()) || 0;
        var amountDue = parseFloat($('#amount').val()) || 0;
        if (amountDue > grandTotal) {
            $('#error_message').text("Received amount cannot be greater than grand total.");
            $('#submit').prop('disabled', true);
        } else {
            $('#error_message').text("");
            $('#submit').prop('disabled', false);
        }
        var due = grandTotal - amountDue;
        $('#due').val(due);
        // $('#due').val(amountDue.toFixed(2));

    }

    $('.change').on('click', function() {
        updateGrandTotal();
    });
</script>

@endsection
