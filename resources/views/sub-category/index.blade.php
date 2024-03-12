@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Category'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h5>Category</h5>
                <a href="{{ route('sub-category.create') }}" class="btn bg-gradient-dark btn-sm float-end mb-0">Add Sub Category</a>
            </div>
            <div class="card-body px-4 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="subCategoryTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Description
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center align-middle">
                                    Category Name</th>

                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
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
{{-- <script>
        const dataTableBasic = new simpleDatatables.DataTable("#categoryTable", {
            searchable: true,
            fixedHeight: true,
            columns: [{
                select: [0, 5],
                sortable: false
            }]
        });
    </script> --}}
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    });
    $(function() {
        var table = $('#subCategoryTable').DataTable({

            processing: true
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
                    , name: 'status'
                }
                , {
                    data: 'cat_id'
                    , name: 'cat_id'
                },

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
