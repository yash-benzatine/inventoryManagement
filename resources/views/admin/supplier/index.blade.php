@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Supplier Management')
@section('content')
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h5>Supplier</h5>
                <button class="btn btn-dark" data-toggle="modal" data-target="#exampleModalLong">Add supplier</button>
            </div>

            <div class="card-body px-4 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 table-flush dataTable" id="supplierTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Id</th>
                                <th>Company Name</th>
                                <th>Name
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Phone</th>
                                <th>
                                    Status</th>
                                <th>
                                    Image</th>
                                <th>
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Supplier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{ route('supplier.store') }}" enctype="multipart/form-data" id="supplierForm">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group">
                                    <label for="name" class="form-label">Company Name <span>*</span></label>
                                    <input type="text" id="name" name="company_name" class="form-control @error('company_name') is-invalid @enderror">
                                    {{-- @error('company_name') --}}
                                    <div class="invalid-feedback"></div>
                                    {{-- @enderror --}}
                                </div>
                                <div class="form-group">
                                    <label for="name" class="form-label">Name <span>*</span></label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror">
                                    {{-- @error('name') --}}
                                    <div class="invalid-feedback"></div>
                                    {{-- @enderror --}}
                                </div>

                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror">
                                    {{-- @error('email') --}}
                                    <div class="invalid-feedback"></div>
                                    {{-- @enderror --}}
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="form-label">Phone <span>*</span></label>
                                    <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror">
                                    {{-- @error('phone') --}}
                                    <div class="invalid-feedback"></div>
                                    {{-- @enderror --}}
                                </div>
                                <div class="form-group">
                                    <label for="status" class="form-label">status</label>
                                    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="1" selected="">Active</option>
                                        <option value="0">Deactive</option>
                                    </select>
                                    {{-- @error('status') --}}
                                    <div class="invalid-feedback"></div>
                                    {{-- @enderror --}}
                                </div>
                                <div class="form-group">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="customFileLang" lang="en">
                                    {{-- @error('image') --}}
                                    <div class="invalid-feedback"></div>
                                    {{-- @enderror --}}
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-gradient-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Supplier Modal -->
        <div class="modal fade" id="editSupplier" tabindex="-1" role="dialog" aria-labelledby="editSupplierModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSupplierModalLabel">Edit Supplier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="#" enctype="multipart/form-data" id="editSupplierForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="supplierId" value="">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group">
                                    <label for="name" class="form-label">Company Name <span>*</span></label>
                                    <input type="text" id="edit_company_name" name="company_name" class="form-control @error('company_name') is-invalid @enderror">
                                    {{-- @error('company_name') --}}
                                    <div class="invalid-feedback"></div>
                                    {{-- @enderror --}}
                                </div>
                                <div class="form-group">
                                    <label for="name" class="form-label">Name <span>*</span></label>
                                    <input type="text" id="edit_name" name="name" class="form-control @error('name') is-invalid @enderror">
                                    {{-- @error('name') --}}
                                    <div class="invalid-feedback"></div>
                                    {{-- @enderror --}}
                                </div>

                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" id="edit_email" name="email" class="form-control @error('email') is-invalid @enderror">
                                    {{-- @error('email') --}}
                                    <div class="invalid-feedback"></div>
                                    {{-- @enderror --}}
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="form-label">Phone <span>*</span></label>
                                    <input type="text" id="edit_phone" name="phone" class="form-control @error('phone') is-invalid @enderror">
                                    {{-- @error('phone') --}}
                                    <div class="invalid-feedback"></div>
                                    {{-- @enderror --}}
                                </div>
                                <div class="form-group">
                                    <label for="status" class="form-label">status</label>
                                    <select id="edit_status" name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="1" selected="">Active</option>
                                        <option value="0">Deactive</option>
                                    </select>
                                    {{-- @error('status') --}}
                                    <div class="invalid-feedback"></div>
                                    {{-- @enderror --}}
                                </div>
                                <div class="form-group">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="edit_image" lang="en">
                                    {{-- @error('image') --}}
                                    <div class="invalid-feedback"></div>
                                    {{-- @enderror --}}
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-gradient-primary">Submit</button>
                        </div>
                    </form>

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
        var table = $('#supplierTable').DataTable({
            "responsive": true
                , language: {
                    paginate: {
                        next: '&#8594;', // or '→'
                        previous: '&#8592;' // or '←'
                    }
                }
            , 
            processing: false,
            order: [[0, "desc"]],
            ordering: true
            , serverSide: true
            , ajax: {
                url: "{{ route('supplier.get-data') }}"
                , type: "POST"
            }
            , columns: [{
                    data: 'id'
                    , name: 'id'
                    , render: function(data, type, row, meta) {
                        return meta.settings._iDisplayStart + meta.row + 1; // Global sequential number
                    }
                }, {
                    data: 'company_name'
                    , name: 'company_name'
                }

                , {
                    data: 'name'
                    , name: 'name'
                }
                , {
                    data: 'email'
                    , name: 'email'
                }
                , {
                    data: 'phone'
                    , name: 'phone'
                }
                , {
                    data: 'status'
                    , name: 'status' ,
                    orderable: false
                }
                , {
                    data: 'image'
                    , name: 'image',
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

<script>
    $(document).ready(function() {
        $('#supplierForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Serialize form data
            var formData = new FormData(this);

            // Send AJAX request
            $.ajax({
                url: $(this).attr('action')
                , type: 'POST'
                , data: formData
                , processData: false
                , contentType: false
                , success: function(response) {
                    if (response.alert === 'success') {
                        $('#supplierTable').DataTable().ajax.reload();
                        // Display success message
                        $('#exampleModalLong').hide();
                        toastr.success(response.message, 'Success');
                        $('#supplierForm')[0].reset();

                        $('.modal-backdrop').hide();
                        
                        // Optionally, remove validation classes and messages
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').empty();
                    } else {
                        console.log(response);
                    }

                }
                , error: function(xhr, status, error) {

                    // Display validation error for the "Company Name" field
                    var errorMessages = xhr.responseJSON.errors;
                    $.each(errorMessages, function(fieldName, messages) {
                        var errorField = $('[name="' + fieldName + '"]');
                        errorField.addClass('is-invalid');

                        // Clear previous error messages
                        errorField.siblings('.invalid-feedback').empty();

                        // Iterate over error messages for the current field and display each one
                        $.each(messages, function(index, errorMessage) {
                            errorField.siblings('.invalid-feedback').append('<div>' + errorMessage + '</div>');
                        });
                    });

                }
            });
        });

        $('#editSupplierForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Serialize form data
            var formData = new FormData(this);
            var supplierId = $('#supplierId').val();

            // Send AJAX request
            $.ajax({
                url: 'supplier/' + supplierId + ''
                , type: 'POST'
                , data: formData
                , processData: false
                , contentType: false
                , success: function(response) {
                    if (response.alert === 'success') {
                        $('#supplierTable').DataTable().ajax.reload();
                        // Display success message
                        $('#editSupplier').hide();
                        toastr.success(response.message, 'Success');
                        // Optionally, clear the form fields
                        $('#editSupplierForm')[0].reset();

                        $('.modal-backdrop').hide();
                        
                        // Optionally, remove validation classes and messages
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').empty();
                    } else {
                        console.log(response);
                    }   

                }
                , error: function(xhr, status, error) {

                    // Display validation error for the "Company Name" field
                    var errorMessages = xhr.responseJSON.errors;
                    $.each(errorMessages, function(fieldName, messages) {
                        var errorField = $('[name="' + fieldName + '"]');
                        errorField.addClass('is-invalid');

                        // Clear previous error messages
                        errorField.siblings('.invalid-feedback').empty();

                        // Iterate over error messages for the current field and display each one
                        $.each(messages, function(index, errorMessage) {
                            errorField.siblings('.invalid-feedback').append('<div>' + errorMessage + '</div>');
                        });
                    });

                }
            });
        });

    });


    $(document).on('click', '.edit-btn', function() {
        var supplierId = $(this).data('id');

        // AJAX request to fetch supplier details
        $.ajax({
            url: '/supplier/' + supplierId + '/edit'
            , type: 'GET'
            , success: function(response) {
                // Populate modal fields with supplier data
                $('#supplierId').val(response.id);
                $('#edit_company_name').val(response.company_name);
                $('#edit_name').val(response.name);
                $('#edit_email').val(response.email);
                $('#edit_phone').val(response.phone);
                $('#edit_status').val(response.status);
                $('#edit_image').val(response.image);

                // Populate other fields similarly
                // Show the modal
                $('#editSupplierModal').modal('show');
            }
            , error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error
            }
        });
    });

</script>

@endsection
