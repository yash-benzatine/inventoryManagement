@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Sub Category Management')
@section('content')
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h5>Sub Category</h5>
                <a href="{{ route('sub-category.create') }}" class="btn btn-dark">Add Sub Category</a>
            </div>
            <div class="card-body px-4 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 table-flush dataTable" id="subCategoryTable" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th>Id</th>
                                <th>
                                    Category Name</th>
                                <th>Sub Category Name
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
#subCategoryTable th:nth-child(4),
#subCategoryTable td:nth-child(4) {
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
        var table = $('#subCategoryTable').DataTable({
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
                url: "{{ route('subCategory.get-data') }}"
                , type: "POST"
            }
            , columns: [{
                    data: 'id'
                    , name: 'id'
                    , render: function(data, type, row, meta) {
                        return meta.settings._iDisplayStart + meta.row + 1; // Global sequential number
                    }
                }, {
                    data: 'cat_id'
                    , name: 'cat_id',
                    orderable: true
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
