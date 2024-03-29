@extends('admin.layout.master')
@section('title')
Role Management
@endsection
@section('content')
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h5>Manage Roles</h5>
                @can('role-create')
                    <a href="{{ route('roles.create') }}" class="btn btn-dark"><i class="bi bi-plus-circle"></i> Add New Role</a>
                @endcan
            </div>
            <div class="card-body">
                <table class="table align-items-center mb-0 mt-3" id="roleTable">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th class="col-md-7">Permission</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
<script>
    $(function() {
        var table = $('#roleTable').DataTable({
            processing: false,
            order: [[0, "desc"]]
            , serverSide: true
            , ajax: {
                url: "{{ route('roles.get-data') }}"
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
                },
                {
                    data: 'permission'
                    , name: 'permission'
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
