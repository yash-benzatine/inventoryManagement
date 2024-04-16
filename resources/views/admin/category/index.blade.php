@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Category Management')
@section('content')

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h5>Category</h5>
                <a href="{{ route('category.create') }}" class="btn btn-dark">Add Category</a>
            </div>
            <div class="card-body px-4 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 table-flush dataTable" id="categoryTable" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th>Id</th>
                                <th>Name
                                </th>
                                <th>
                                    Description
                                </th>
                                <th>
                                    Status</th>
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
<style>
#categoryTable th:nth-child(3),
#categoryTable td:nth-child(3) {
    white-space: normal; /* Allow wrapping */
    overflow: hidden; /* Hide overflow content */
    text-overflow: ellipsis; /* Display ellipsis for overflow content */
}
</style>
@endsection
@section('page-script')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    });
    $(function() {
        var table = $('#categoryTable').DataTable({
            processing: false,
            ordering: true,
            order: [[0, "desc"]],
            "responsive": true
                , language: {
                    paginate: {
                        next: '&#8594;', // or '→'
                        previous: '&#8592;' // or '←'
                    }
                }
            ,  
            serverSide: true
            , ajax: {
                url: "{{ route('category.get-data') }}"
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
                    , name: 'name'
                }
                , {
                    data: 'description'
                    , name: 'description'
                }
                , {
                    data: 'status'
                    , name: 'status',  
                    orderable: false                          
                },
                // {
                //     data: 'cat_id'
                //     , name: 'cat_id'
                // },

                {
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
