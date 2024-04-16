@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Sale Management')
@section('content')
<div class="row mt-4 mx-4">
    <div class="col-12">
        <form action="{{ route('manage-sale.store') }}" method="POST" id="SaleForm">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <h5>Manage Sale</h5>
                    {{-- <a href="{{ route('manage-sale.index') }}" class="btn btn-dark">Add Manage Sale</a> --}}
                </div>
                <div class="card-body px-4 pt-0 pb-2">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <select class="form-control" name="category_id" id="category_id">
                                <option value="">Category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4" style="display: none;" id="sub_category">
                            <select type="text" id="sub_category_id" name="sub_category_id" class="form-control @error('sub_category_id') is-invalid @enderror product-data">
                                <option value="">Please Select Sub Category</option>
                            </select>
                            @error('sub_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4" style="display: none;" id="product">
                            <select type="text" id="product_id" name="product_id" class="form-control @error('product_id') is-invalid @enderror product-data">
                                <option value="">Please Select Product</option>
                            </select>
                            @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="table-responsive p-0" id="table" style="display: none;">
                        <table class="table align-items-center mb-0 table-flush dataTable" id="manageSaleTable">
                            <thead class="thead-light">
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
                                    <th>
                                        Remove</th>

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
            @csrf
            <div class="row mt-6">
                <div class="col-md-6">
                    <h6>Supplier</h6>
                    <div class="card-wrapper">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Invoice Code</label>
                            <div class="col-md-7">
                                <input class="form-control @error('invoice_code') is-invalid @enderror" type="text" value="{{ $invoice_code }}" name="invoice_code" id="example-text-input" readonly="">
                                @error('invoice_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Category</label>
                            <div class="col-md-7">
                                <select type="text" id="customer_id" name="customer_id" class="form-control @error('customer_id') is-invalid @enderror">
                                    <option value="">Please Select Customer</option>
                                    @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                                @error('customer_id')
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
                            <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Sub Total</label>
                            <div class="col-md-7">
                                <input class="form-control @error('sub_total') is-invalid @enderror" name="sub_total" type="text" value="{{ old('sub_total') }}" id="sub_total" readonly="">
                                @error('sub_total')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Discount</label>
                            <div class="col-md-7">
                                <input class="form-control @error('discount') is-invalid @enderror total" name="discount" type="number" value="{{ old('discount') }}" id="discount">
                                @error('discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-4 col-form-label form-control-label">VAT</label>
                            <div class="col-md-7">
                                <select type="text" id="vat" name="vat" class="form-control @error('vat') is-invalid @enderror total" value="{{ old('vat') }}">
                                    <option value="">Please Select VAT</option>
                                    @foreach ($taxes as $tax)
                                    <option value="{{ $tax->id }}">{{ $tax->rate }}</option>
                                    @endforeach
                                </select>
                                @error('vat')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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
                            <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Received Amount</label>
                            <div class="col-md-7">
                                <input class="form-control @error('receive_amount') is-invalid @enderror" name="received_amount" type="number" value="{{ old('receive_amount') }}" id="receive_amount">
                                @error('receive_amount')
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
                                <div id="error_message" class="error my-1"></div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-4 col-form-label form-control-label">Payment Type</label>
                            <div class="col-md-7">
                                <select type="text" id="paymentType" name="paymentType" class="form-control @error('paymentType') is-invalid @enderror" value="{{ old('paymentType') }}">
                                    <option value="">Please Select</option>
                                    <option value="cach" {{ old('paymentType') == "cash" ? 'selected' : '' }}>CASH</option>
                                    <option value="check" {{ old('paymentType') == "check" ? 'selected' : '' }}>CHECK</option>
                                    <option value="card" {{ old('paymentType') == "card" ? 'selected' : '' }}>CARD</option>
                                    <!---->
                                </select>
                                @error('paymentType')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                        <button type="submit" id="submit" class="btn btn-primary mt-4 col-md-4">Create New Sale</button>
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
        $('#SaleForm').validate({

            rules: {
                // Define validation rules for each form field
                'invoice_code': {
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
                'invoice_code': {
                    required: "Please enter a Sale code"
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
        $('#manageSaleTable').DataTable({
            language: {
                paginate: {
                next: '&#8594;', // or '→'
                previous: '&#8592;' // or '←' 
                }
            }
        });
    });

    $(document).on('keypress', '#receive_amount', function() {
        updateDue();
    });

     // Function to update the due amount
    function updateDue() {
        var grandTotal = parseFloat($('#total').val()) || 0;
        var amountPaid = parseFloat($('#receive_amount').val()) || 0;
        if (amountPaid > grandTotal) {
            $('#error_message').text("Received amount cannot be greater than grand total.");
            $('#submit').prop('disabled', true);
        } else {
            $('#error_message').text("");
            $('#submit').prop('disabled', false);
        }
        var due = grandTotal - amountPaid;
        $('#due').val(due.toFixed(2));
    }

    function product() {
        // e.preventDefault();
        var productId = $('#product_id').val();
        var subCategoryId = $('#sub_category_id').val();
        var categoryId = $('#category_id').val();
        var subCategorySelect = document.getElementById('sub_category_id');
        subCategorySelect.innerHTML = '<option value="">Please Select Sub Category</option>';
        var productSelect = document.getElementById('product_id');
        productSelect.innerHTML = '<option value="">Please Select Product</option>';

        $.ajax({
            url: "{{ route('manage-sale.get-data') }}"
            , type: 'POST'
            , data: {
                productId: productId
                , subCategoryId: subCategoryId,
                categoryId: categoryId
            , }
            , success: function(response) {
                // $('#manageSaleTable tbody').empty();
                $('#manageSaleTable tbody').empty();
                $.each(response.subCategory, function(index, subcategory) {
                    var option = document.createElement('option');
                    option.value = subcategory.id;
                    option.text = subcategory.name;
                    if (subcategory.id == subCategoryId) {
                        option.selected = true;
                    }
                    subCategorySelect.appendChild(option);
                });
                
                if (response.product.length > 0) {
                    var sub_total = 0;
                    var product_id = [];
                    var option = document.createElement('option');
                    $.each(response.product, function(index, product) {
                        option.value = product.id;
                        option.text = product.name;
                        if (product.id == productId) {
                            option.selected = true;
                        }
                        productSelect.appendChild(option);
                         if(productId != ""){
                                $('#table').show();
                                 // if(response.total_quantity != ""){
                            var total_quantity = product.quantity - response.total_quantity;
                            $('.tr-wrapper').closest('tr').remove();
                            var total = product.quantity * product.selling_price;
                            sub_total += total;
                            product_id.push(product.id);
                            var dataIdString = product_id.join(',');
                            var rowCount = $('#managePurchaseTable tbody tr').length;
                            var newRow = '<tr><input type="hidden" name="data_id[]" value="'+ product.id +'" id="data_id">' +
                                '<td>' + (rowCount + 1) + '</td>' +
                                '<td><input type="text" class="form-control" class="editable" data-id="' + product.id + '" data-field="serial_number" value="' + product.serial_number + '" readonly></td>' +
                                '<td><input type="text" class="form-control" class="editable" data-id="' + product.id + '" data-field="name" value="' + product.name + '"></td>' +
                                '<td><input type="text" class="form-control sale_quantity" class="editable" data-id="' + product.id + '" data-field="sale_quantity" name="sale_quantity[]" value="' + product.quantity + '"></td><div id="total_quantity_message" class="error"></div>' +
                                '<td><input type="text" class="form-control" class="editable" data-id="' + product.id + '" data-field="selling_price" value="' + product.selling_price + '"></td>' +
                                '<td><input type="text" class="form-control" class="editable" data-id="' + product.id + '" data-field="total" value="' + total + '" readonly></td>' +
                                '<td><button class="btn btn-danger remove-row mt-3">Remove</button></td>' +
                                '</tr>';
                            $('input[name="sub_total"]').val(sub_total.toFixed(2)); // Assuming 2 decimal places for grand total
                            $('input[name="data_id"]').val(dataIdString);
                            $('#manageSaleTable tbody').append(newRow);
                            updateGrandTotal();
                            updateSubTotal();
                            updateDue();
                            calculateGrandTotal();
                            if(total_quantity >= 1){
                                $('#total_quantity_message').text("");
                                $('#submit').prop("disabled", false);
                            }else{
                                toastr.error("Product is out of Stock !", 'danger');
                                $('#total_quantity_message').text("Product is out of stock !");
                                $('#submit').prop("disabled", true);
                            }
                        }else{
                            $('#table').hide();
                        }
                    });
                }else{
                    $('#table').hide();
                }
            }
        });

    };

    $(document).on('change', '.product-data', function(){
        product();
    });
    $(document).on('input', '#manageSaleTable input', function() {
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
                if (field === 'sale_quantity' || field === 'selling_price') {
                    updateTotal(productId);
                    updateSubTotal();
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
        var quantity = parseFloat($('input[data-id="' + productId + '"][data-field="sale_quantity"]').val());
        var unitPrice = parseFloat($('input[data-id="' + productId + '"][data-field="selling_price"]').val());
        var total = isNaN(quantity) || isNaN(unitPrice) ? 0 : quantity * unitPrice;

        // Update total column in the table
        $('input[data-id="' + productId + '"][data-field="total"]').val(total);
    }
    $(document).on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
        updateGrandTotal();
        updateSubTotal();
        updateDue();
    });

    function updateSubTotal() {
        var sub_total = 0;
        $('#manageSaleTable input[data-field="total"]').each(function() {
            var totalValue = parseFloat($(this).val());
            if (!isNaN(totalValue)) {
                sub_total += totalValue;
            }
        });
        $('input[name="sub_total"]').val(sub_total.toFixed(2)); // Assuming 2 decimal places for grand total
    }


    function updateGrandTotal() {
        var grandTotal = 0;
        $('#manageSaleTable input[data-field="total"]').each(function() {
            var totalValue = parseFloat($(this).val());
            if (!isNaN(totalValue)) {
                grandTotal += totalValue;
            }
        });
        $('input[name="total"]').val(grandTotal.toFixed(2)); // Assuming 2 decimal places for grand total
    }

    $('#receive_amount').on('input', function() {
        updateDue();
    });
    

</script>

<script>
    document.getElementById('category_id').addEventListener('change', function() {
        var categoryId = this.value;
        var subCategorySelect = document.getElementById('sub_category_id');
        subCategorySelect.innerHTML = '<option value="">Please Select Sub Category</option>';
        var productSelect = document.getElementById('product_id');
        productSelect.innerHTML = '<option value="">Please Select Product</option>';

        if (categoryId !== '') {
            // Show sub category dropdown
            document.getElementById('sub_category').style.display = 'block';
            document.getElementById('product').style.display = 'block';

            // product();

            // Fetch sub categories based on the selected category id
            fetch('/get-sub-categories/' + categoryId)
                .then(response => response.json())
                .then(data => {
                    if (data && data.data && data.data.length > 0) {
                        data.data.forEach(function(subCategory) {
                            var option = document.createElement('option');
                            option.value = subCategory.id;
                            option.text = subCategory.name;
                            subCategorySelect.appendChild(option);
                        });
                    }
                    if (data && data.data_product && data.data_product.length > 0) {
                        data.data_product.forEach(function(product) {
                            var option = document.createElement('option');
                            option.value = product.id;
                            option.text = product.name;
                            productSelect.appendChild(option);
                        });
                    }   
                })

                .catch(error => console.error('Error:', error));
        } else {
            // Hide sub category and product dropdowns if category is not selected
            document.getElementById('sub_category').style.display = 'none';
            document.getElementById('product').style.display = 'none';
        }
    });

    function calculateGrandTotal() {
        var sub_total = parseFloat($('#sub_total').val());
        var discount = parseFloat($('#discount').val());
        var vat_rate = parseFloat($('#vat option:selected').text());

        // Check if sub_total is a valid number
        if (!isNaN(sub_total)) {
            // Calculate the total before VAT
            var total_discount = sub_total / discount;
            var total_before_vat = sub_total - total_discount;

            // Calculate VAT amount
            var vat_amount = total_before_vat * (vat_rate / 100);

            // Calculate grand total
            var grand_total = total_before_vat + vat_amount;

            // Update the grand total input field
            $('#total').val(grand_total.toFixed(2));
            updateDue();
        }
    }

    // Event listener for change in VAT and discount fields
    $('.total').change(function() {
        calculateGrandTotal();
    });

    // Initial calculation when page loads
    calculateGrandTotal();

    $(document).ready(function() {
        $(document).on('keyup', '.sale_quantity', function () {
            updateGrandTotal();
            updateSubTotal();
            updateDue();
            calculateGrandTotal();
            $quantity = $(this).val();
            $id = $(this).attr('data-id');


            $.ajax({
                url: '/sale-quantity/'
                , type: 'POST'
                , data: {
                    productId: $id
                    , quantity: $quantity
                }
                , success: function(response) {
                    // Handle success response
                    if(response.total_quantity >= 1){
                        $('#total_quantity_message').text("");
                        $('#submit').prop("disabled", false);
                    }else{
                        toastr.error("Product is out of Stock !", 'danger');
                        $('#total_quantity_message').text("Product is out of stock !");
                        $('#submit').prop("disabled", true);
                    }
                }
                , error: function(xhr, status, error) {
                    // Handle error response
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
