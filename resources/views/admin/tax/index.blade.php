@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Tax Management')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h5>Tax</h5>
                <button class="btn btn-dark" data-toggle="modal" data-target="#exampleModalLong">Add Tax</button>
            </div>

            <div class="card-body px-4 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 table-flush dataTable" id="taxTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Id</th>
                                <th>Name
                                </th>
                                <th class="">
                                    Rate
                                </th>
                                <th>
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add Tax</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" action="{{ route('tax.store') }}" enctype="multipart/form-data" id="taxForm">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Name <span>*</span></label>
                                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror">
                                        {{-- @error('company_name') --}}
                                        <div class="invalid-feedback"></div>
                                        {{-- @enderror --}}
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="form-label">Rate <span>*</span></label>
                                        <input type="text" id="rate" name="rate" class="form-control @error('rate') is-invalid @enderror">
                                        {{-- @error('name') --}}
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

            <!-- Edit Tax Modal -->
            <div class="modal fade" id="editTax" tabindex="-1" role="dialog" aria-labelledby="editTaxModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTaxModalLabel">Edit Tax</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" action="#" enctype="multipart/form-data" id="editTaxForm">
                            @csrf
                            {{-- @method('PUT') --}}
                            <input type="hidden" name="id" id="taxId" value="">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Name <span>*</span></label>
                                        <input type="text" id="edit_name" name="name" class="form-control @error('name') is-invalid @enderror">
                                        {{-- @error('company_name') --}}
                                        <div class="invalid-feedback"></div>
                                        {{-- @enderror --}}
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="form-label">Rate <span>*</span></label>
                                        <input type="text" id="edit_rate" name="rate" class="form-control @error('rate') is-invalid @enderror">
                                        {{-- @error('name') --}}
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
        var table = $('#taxTable').DataTable({
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
                url: "{{ route('tax.get-data') }}"
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
                    data: 'rate'
                    , name: 'rate'
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
        $('#taxForm').on('submit', function(e) {
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
                        $('#taxTable').DataTable().ajax.reload();
                        // Display success message
                        $('#exampleModalLong').hide();
                        toastr.success(response.message, 'Success');
                        $('#taxForm')[0].reset();

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

        $('#editTaxForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Serialize form data
            var formData = new FormData(this);
            var taxId = $('#taxId').val();

            // Send AJAX request
            $.ajax({
                url: 'tax/update/' + taxId + ''
                , type: 'POST'
                , data: formData
                , processData: false
                , contentType: false
                , success: function(response) {
                    if (response.alert === 'success') {
                        $('#taxTable').DataTable().ajax.reload();
                        // Display success message
                        $('#editTax').hide();
                        toastr.success(response.message, 'Success');
                        $('#editTaxForm')[0].reset();

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
        var taxId = $(this).data('id');

        // AJAX request to fetch Tax details
        $.ajax({
            url: '/tax/' + taxId + '/edit'
            , type: 'GET'
            , success: function(response) {
                // Populate modal fields with Tax data
                $('#taxId').val(response.id);
                $('#edit_name').val(response.name);
                $('#edit_rate').val(response.rate);
                $('#editTaxModal').modal('show');
            }
            , error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error
            }
        });
    });

</script>
@endsection
