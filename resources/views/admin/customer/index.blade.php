@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Customer Management')

@section('content')
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h5>Customer</h5>
                <a href="{{ route('customer.create') }}" class="btn btn-dark">Add Customer</a>
            </div>
            <div class="card-body px-4 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 table-flush dataTable" id="customerTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Phone</th>
                                <th>
                                    Address</th>
                                <th>
                                    Discount</th>
                                <th>
                                    Status</th>
                                <th>
                                    Gender</th>
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
        var table = $('#customerTable').DataTable({
            order: [[0, "desc"]],
            ordering: true,
            "responsive": true
                , language: {
                    paginate: {
                        next: '&#8594;', // or '→'
                        previous: '&#8592;' // or '←'
                    }
                }
            , 
            processing: false
            , serverSide: true
            , ajax: {
                url: "{{ route('customer.get-data') }}"
                , type: "POST"
            }
            , columns: [{
                    data: 'id'
                    , name: 'id'
                    , render: function(data, type, row, meta) {
                        return meta.settings._iDisplayStart + meta.row + 1; // Global sequential number
                    }
                }
                , {
                    data: 'name'
                    , name: 'name',
                    orderable: true
                    
                }
                , {
                    data: 'email'
                    , name: 'email',
                    orderable: true
                }
                , {
                    data: 'phone'
                    , name: 'phone'
                }
                , {
                    data: 'address'
                    , name: 'address'
                }
                , {
                    data: 'discount'
                    , name: 'discount'
                }
                , {
                    data: 'status'
                    , name: 'status',
                    orderable: false
                }
                , {
                    data: 'gender'
                    , name: 'gender',
                    orderable: false
                }
                , {
                    data: 'image'
                    , name: 'image'
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
