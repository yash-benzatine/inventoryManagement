@extends('admin.layout.master')
@section('title', 'User Management')

@section('content')
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h5>User Management</h5>
                @can('user-create')
                <a class="btn btn-dark" href="{{ route('users.create') }}"> Create New User</a>
                @endcan
            </div>

            <div class="card-body">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 table-flush dataTable" id="userTable">
                        <thead class="thead-light">
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="user-modal-permission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">User Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('roles.update', $role->id) }}" enctype="multipart/form-data" id="taxForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            @foreach ($permissions as $permission)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" name="permissions[]" {{ in_array($permission->id, $rolePermissions ?? []) ? 'checked' : '' }}>

                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                            @endforeach
                            @if ($errors->has('permissions'))
                            <span class="text-danger">{{ $errors->first('permissions') }}</span>
                            @endif

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

@endsection
@section('page-script')
<script type="text/javascript">
    $(function() {
        var table = $('#userTable').DataTable({
            processing: false,
            "responsive": true, 
            language: {
                paginate: {
                    next: '&#8594;', // or '→'
                    previous: '&#8592;' // or '←'
                }
            }, 
            order: [[0, "desc"]]
            , serverSide: true
            , ajax: {
                url: "{{ route('users.get-data') }}"
                , type: "POST"
            }
            , columns: [{
                    data: 'id'
                    , name: 'id'
                    , render: function(data, type, row, meta) {
                        return meta.settings._iDisplayStart + meta.row + 1; // Global sequential number
                    }
                }, {
                    data: 'username'
                    , name: 'username'
                }
                , {
                    data: 'email'
                    , name: 'email'
                }
                , {
                    data: 'roles'
                    , name: 'roles'
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

    // $('.user-permission').click({
    //     $('#user-modal-permission').modal('show');
    // });

</script>

@endsection
