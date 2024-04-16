@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Product Create')
@section('content')
<div class="row mt-4 mx-4">
    <div class="container-fluid my-5 py-2">
        <div class="d-flex justify-content-center mb-5">
            <div class="col-lg-9 mt-lg-0 mt-4">

                <div class="card mt-4" id="basic-info">
                    <div class="card-header">
                        <h5>New Product</h5>
                    </div>
                    <div class="card-body pt-0">
                        <form method="post" enctype="multipart/form-data" class="" action="{{ route('product.store') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="serial_number" class="form-label">Serial Code</label>
                                    <input type="text" id="serial_number" name="serial_number" readonly="" class="form-control @error('serial_number') is-invalid @enderror">
                                    @error('serial_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label">image</label>
                                    <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror">
                                    @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="category" class="form-label">Category</label>
                                    <select id="category" name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                        <option value="" selected="" disabled="">Please Select</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="subCategory" class="form-label">Sub Category</label>
                                    <select id="subCategory" name="sub_category_id" class="form-control @error('sub_category_id') is-invalid @enderror">
                                        <option value="" selected disabled>Please Select</option>
                                    </select>
                                    @error('sub_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="text" id="quantity" name="quantity" class="form-control  @error('quantity') is-invalid @enderror">
                                    @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!---->
                                <div class="form-group col-md-4">
                                    <label for="purchase_price" class="form-label">Purchase Price</label>
                                    <input type="text" id="purchase_price" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror">
                                    @error('purchase_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="selling_price" class="form-label">Selling Price</label>
                                    <input type="text" id="selling_price" name="selling_price" class="form-control  @error('selling_price') is-invalid @enderror">
                                    @error('selling_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="status" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="0">Inactive</option>
                                        <option value="1">Active</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="note" class="form-label">Note</label>
                                    <textarea type="text" id="note" name="note" class="form-control  @error('note') is-invalid @enderror"></textarea>
                                    @error('note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <button type="submit" class="btn bg-gradient-primary m-0 ms-2">Submit</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-script')
<script>
    $(document).ready(function() {
        $('#category').change(function() {
            var categoryId = $(this).val();
            if(categoryId) {
                $.ajax({
                    type: 'GET',
                    url: '/get-subcategories/' + categoryId,
                    success: function(response) {
                        var data = response.data; // Access the data array
                        $('#subCategory').empty();
                        $('#subCategory').append('<option value="" selected disabled>Please Select</option>');
                        $.each(data, function(index, item) {
                            $('#subCategory').append('<option value="'+ item.id +'">'+ item.name +'</option>');
                        });
                    }
                });
            }
        });
    });
    $(document).ready(function() {
        // Function to generate random 8-digit number
        function generateRandomNumber() {
            return Math.floor(10000000 + Math.random() * 90000000);
        }

        // Set the generated number to the serial_number input field
        $('#serial_number').val(generateRandomNumber());
    });

</script>

@endsection
